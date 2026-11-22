<?php

namespace App\Services\Ai;

use App\Models\AgentConfig;
use App\Models\AgentRun;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Models\CrmDeal;
use App\Models\FinanceInvoice;
use App\Models\HireJob;
use App\Models\HrEmployee;
use App\Models\Org;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TuahAiService
{
    /**
     * Get or create Tuah agent configuration for the organization.
     * Default provider is Ollama.
     */
    public function getConfig(string $orgId): AgentConfig
    {
        $defaultProvider = config('services.ai.default_provider', 'ollama');
        $defaultOllamaUrl = config('services.ollama.url', 'http://127.0.0.1:11434');
        $defaultOllamaModel = config('services.ollama.model', 'gemma4:e2b');
        $defaultGeminiModel = config('services.gemini.model', 'gemini-2.5-flash');

        return AgentConfig::firstOrCreate(
            [
                'org_id' => $orgId,
                'agent_name' => 'Tuah',
            ],
            [
                'provider' => $defaultProvider,
                'gemini_model' => $defaultGeminiModel,
                'gemini_api_key' => null, // null falls back to config('services.gemini.api_key')
                'ollama_url' => $defaultOllamaUrl,
                'ollama_model' => $defaultOllamaModel,
                'model' => $defaultProvider === 'ollama' ? $defaultOllamaModel : $defaultGeminiModel,
                'system_prompt' => "Anda adalah Tuah AI, penasihat dan pembantu operasi perniagaan PKS Malaysia bagi platform KerjaAI. Anda fasih menyelaraskan modul Lekir (Kewangan & Invois), Lekiu (Modal Insan & Pengambilan Staf), Kasturi (Jualan, CRM & Produk), dan Jebat (Iklan & Pemasaran).

PANDUAN FORMAT MAKLUM BALAS:
- Formatkan jawapan anda dengan gaya tulisan yang kemas, profesional, dan mudah dibaca.
- JANGAN gunakan tanda pagar (#, ##, ###) untuk tajuk. Sebaliknya gunakan teks tebal (**Tajuk**) atau huruf besar yang jelas.
- JANGAN gunakan tanda tiga bintang (***). Gunakan teks tebal (dua bintang **) untuk penegasan penting.
- Gunakan senarai titik ringkas (-) atau nombor (1, 2, 3) untuk susunan fakta.
- Berikan jawapan yang tepat, padat, berfokuskan penyelesaian perniagaan, dan gunakan Bahasa Melayu standard atau dwibahasa Malaysia yang profesional.",
                'temperature' => 0.70,
                'tools_enabled' => ['finance', 'people', 'crm', 'reach', 'hire'],
                'is_active' => true,
            ]
        );
    }

    /**
     * Update Tuah agent configuration for the organization.
     */
    public function updateConfig(string $orgId, array $data): AgentConfig
    {
        $config = $this->getConfig($orgId);

        $updateData = [];

        if (isset($data['provider'])) {
            $updateData['provider'] = in_array($data['provider'], ['gemini', 'ollama']) ? $data['provider'] : 'ollama';
        }

        if (array_key_exists('gemini_api_key', $data)) {
            // If empty string submitted, reset to null to use system default
            $updateData['gemini_api_key'] = !empty(trim($data['gemini_api_key'] ?? '')) ? trim($data['gemini_api_key']) : null;
        }

        if (isset($data['gemini_model'])) {
            $updateData['gemini_model'] = trim($data['gemini_model']) ?: 'gemini-2.5-flash';
        }

        if (array_key_exists('ollama_url', $data)) {
            $url = trim($data['ollama_url'] ?? '');
            $updateData['ollama_url'] = !empty($url) ? rtrim($url, '/') : 'http://127.0.0.1:11434';
        }

        if (isset($data['ollama_model'])) {
            $updateData['ollama_model'] = trim($data['ollama_model']) ?: 'gemma4:e2b';
        }

        if (isset($data['system_prompt'])) {
            $updateData['system_prompt'] = $data['system_prompt'];
        }

        if (isset($data['temperature'])) {
            $updateData['temperature'] = (float) $data['temperature'];
        }

        if (isset($data['is_active'])) {
            $updateData['is_active'] = (bool) $data['is_active'];
        }

        // Set general model identifier based on active provider
        if (($updateData['provider'] ?? $config->provider) === 'ollama') {
            $updateData['model'] = $updateData['ollama_model'] ?? $config->ollama_model;
        } else {
            $updateData['model'] = $updateData['gemini_model'] ?? $config->gemini_model;
        }

        $config->update($updateData);

        return $config->fresh();
    }

    /**
     * Pull all models dynamically from Google Gemini API with connection status.
     */
    public function fetchGeminiModelsWithDetails(?string $apiKey = null): array
    {
        $key = $apiKey ?: config('services.gemini.api_key');

        $fallbackModels = [
            'gemini-2.5-flash',
            'gemini-2.5-pro',
            'gemma-4-31b-it',
            'gemma-4-26b-a4b-it',
            'gemini-flash-latest',
            'gemini-pro-latest',
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash',
            'gemini-2.0-flash-lite',
            'gemini-1.5-flash',
            'gemini-1.5-pro',
            'gemini-1.5-flash-8b',
        ];

        if (empty($key)) {
            return [
                'models' => $fallbackModels,
                'live' => false,
                'message' => 'Kunci API Gemini tidak dibekalkan. Senarai model rasmi Google dimuatkan sebagai rujukan.',
            ];
        }

        try {
            $response = Http::timeout(10)->get("https://generativelanguage.googleapis.com/v1beta/models?key={$key}");

            if ($response->successful()) {
                $rawModels = $response->json()['models'] ?? [];
                $pulled = collect($rawModels)
                    ->filter(fn($m) => in_array('generateContent', $m['supportedGenerationMethods'] ?? []))
                    ->pluck('name')
                    ->map(fn($n) => str_replace('models/', '', $n))
                    ->values()
                    ->toArray();

                if (!empty($pulled)) {
                    return [
                        'models' => $pulled,
                        'live' => true,
                        'message' => 'Berjaya menarik ' . count($pulled) . ' model daripada Google Gemini API!',
                    ];
                }
            }

            return [
                'models' => $fallbackModels,
                'live' => false,
                'message' => "Google Gemini API membalas status HTTP {$response->status()}. Senarai model rasmi dimuatkan.",
            ];
        } catch (\Throwable $e) {
            Log::info("Fetch Gemini Models Notice: " . $e->getMessage());

            return [
                'models' => $fallbackModels,
                'live' => false,
                'message' => 'Tidak dapat menyambung ke Google Gemini API: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Pull all models dynamically from Google Gemini API without restrictions.
     */
    public function fetchGeminiModels(?string $apiKey = null): array
    {
        return $this->fetchGeminiModelsWithDetails($apiKey)['models'];
    }

    /**
     * Pull all models installed on the Ollama server with detailed status.
     */
    public function fetchOllamaModelsWithDetails(?string $url = null): array
    {
        $ollamaUrl = rtrim($url ?: config('services.ollama.url', 'http://127.0.0.1:11434'), '/');

        $defaultModels = [
            'gemma4:e2b',
            'llama3',
            'mistral',
            'deepseek-r1:8b',
            'qwen2.5:7b',
            'phi3',
            'gemma2',
        ];

        try {
            $response = Http::timeout(5)->get("{$ollamaUrl}/api/tags");

            if ($response->successful()) {
                $rawModels = $response->json()['models'] ?? [];
                $pulled = collect($rawModels)->pluck('name')->toArray();

                if (!empty($pulled)) {
                    return [
                        'models' => $pulled,
                        'live' => true,
                        'message' => 'Berjaya menarik ' . count($pulled) . " model terus dari pelayan Ollama ({$ollamaUrl})!",
                    ];
                }

                return [
                    'models' => $defaultModels,
                    'live' => true,
                    'message' => "Pelayan Ollama disambung ({$ollamaUrl}), namun tiada model dimuat turun lagi. Menggunakan model cadangan.",
                ];
            }

            return [
                'models' => $defaultModels,
                'live' => false,
                'message' => "Pelayan Ollama membalas status HTTP {$response->status()}. Menggunakan senarai model cadangan.",
            ];
        } catch (\Throwable $e) {
            Log::info("Fetch Ollama Models Notice: " . $e->getMessage());

            return [
                'models' => $defaultModels,
                'live' => false,
                'message' => "Pelayan Ollama di '{$ollamaUrl}' tidak aktif atau tidak dapat dicapai. Senarai model cadangan dimuatkan sebagai rujukan.",
            ];
        }
    }

    /**
     * Pull all models installed on the Ollama server.
     */
    public function fetchOllamaModels(?string $url = null): array
    {
        return $this->fetchOllamaModelsWithDetails($url)['models'];
    }

    /**
     * Test connection to selected provider.
     */
    public function testConnection(
        string $orgId,
        ?string $provider = null,
        ?string $geminiKey = null,
        ?string $geminiModel = null,
        ?string $ollamaUrl = null,
        ?string $ollamaModel = null
    ): array {
        $config = $this->getConfig($orgId);
        $activeProvider = $provider ?: $config->provider;

        if ($activeProvider === 'ollama') {
            $url = $ollamaUrl ?: ($config->ollama_url ?: config('services.ollama.url', 'http://127.0.0.1:11434'));
            $url = rtrim($url, '/');
            $model = $ollamaModel ?: ($config->ollama_model ?: config('services.ollama.model', 'gemma4:e2b'));

            try {
                $response = Http::timeout(5)->get("{$url}/api/tags");

                if ($response->successful()) {
                    $data = $response->json();
                    $models = collect($data['models'] ?? [])->pluck('name')->toArray();
                    $hasModel = in_array($model, $models) || in_array("{$model}:latest", $models);

                    return [
                        'success' => true,
                        'provider' => 'ollama',
                        'message' => $hasModel
                            ? "Berjaya menyambung ke Ollama ({$url}). Model '{$model}' sedia digunakan."
                            : "Berjaya menyambung ke Ollama ({$url}). Model sedia ada: " . (empty($models) ? 'Tiada model dimuat turun lagi. Sila jalankan `ollama pull ' . $model . '`' : implode(', ', $models)),
                        'details' => [
                            'url' => $url,
                            'model' => $model,
                            'available_models' => $models,
                        ],
                    ];
                }

                return [
                    'success' => false,
                    'provider' => 'ollama',
                    'message' => "Pelayan Ollama membalas dengan status HTTP {$response->status()}.",
                    'details' => ['status' => $response->status()],
                ];
            } catch (\Throwable $e) {
                return [
                    'success' => false,
                    'provider' => 'ollama',
                    'message' => "Tidak dapat menyambung ke pelayan Ollama di '{$url}'. Sila pastikan pelayan Ollama sedang berjalan (`ollama serve`).",
                    'details' => ['error' => $e->getMessage()],
                ];
            }
        }

        // Gemini connection test
        $apiKey = $geminiKey ?: ($config->gemini_api_key ?: config('services.gemini.api_key'));
        $model = $geminiModel ?: ($config->gemini_model ?: config('services.gemini.model', 'gemini-2.5-flash'));

        if (empty($apiKey)) {
            return [
                'success' => false,
                'provider' => 'gemini',
                'message' => "Kunci Gemini API belum ditetapkan. Sila masukkan Kunci API syarikat anda atau tetapkan GEMINI_API_KEY di fail persekitaran pelayan (.env).",
                'details' => ['error' => 'API key missing'],
            ];
        }

        try {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
            $response = Http::timeout(10)->post($endpoint, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [['text' => 'Ping connection test. Reply with OK.']],
                    ],
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 10,
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'provider' => 'gemini',
                    'message' => "Sambungan ke Google Gemini API ({$model}) berjaya disahkan! Kunci API sah dan sedia beroperasi.",
                    'details' => ['model' => $model],
                ];
            }

            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? "Ralat HTTP {$response->status()} daripada Google Gemini API";

            return [
                'success' => false,
                'provider' => 'gemini',
                'message' => "Sambungan ke Gemini gagal: {$errorMessage}",
                'details' => $errorBody,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'provider' => 'gemini',
                'message' => "Ralat sambungan ke Google Gemini: {$e->getMessage()}",
                'details' => ['error' => $e->getMessage()],
            ];
        }
    }

    /**
     * Send chat prompt to Tuah AI and obtain response.
     * Strictly calls only the active provider (Gemini OR Ollama). Never both.
     */
    public function chat(
        string $orgId,
        string $prompt,
        ?string $threadId = null,
        ?string $contextModule = 'general',
        ?User $user = null
    ): array {
        $config = $this->getConfig($orgId);

        // Resolve or create thread
        if ($threadId) {
            $thread = ChatThread::where('org_id', $orgId)->find($threadId);
        } else {
            $thread = null;
        }

        if (!$thread) {
            $thread = ChatThread::create([
                'org_id' => $orgId,
                'user_id' => $user?->id,
                'title' => mb_strimwidth($prompt, 0, 40, '...'),
                'context_module' => $contextModule ?: 'general',
            ]);
        }

        // Save User Message
        $userMessage = ChatMessage::create([
            'thread_id' => $thread->id,
            'role' => 'user',
            'content' => $prompt,
            'metadata' => [
                'context_module' => $contextModule,
            ],
        ]);

        // Office Hub: satu task = satu staff di office
        $hub = app(\App\Services\OfficeHub\OfficeHubNotifier::class);
        $taskId = substr((string) \Illuminate\Support\Str::uuid(), 0, 8);
        $taskTitle = mb_strimwidth($prompt, 0, 80, '...');
        $hub->started($taskId, $taskTitle, $contextModule, $orgId);

        // Zero-Token Scope Guardrail: Block exploit/cybersecurity/unrelated coding abuse
        $scopeViolation = $this->checkScopeViolation($prompt, $orgId, $user);
        if ($scopeViolation !== null) {
            $hub->failed($taskId, $taskTitle, $contextModule, $orgId);
            $hub->finished($taskId, $taskTitle, $contextModule, $orgId);

            $assistantMessage = ChatMessage::create([
                'thread_id' => $thread->id,
                'role' => 'assistant',
                'content' => $scopeViolation,
                'metadata' => [
                    'provider' => $config->provider,
                    'model' => $config->model,
                    'tokens_used' => 0,
                    'context_module' => $contextModule,
                    'scope_blocked' => true,
                ],
            ]);

            $run = AgentRun::create([
                'org_id' => $orgId,
                'agent_config_id' => $config->id,
                'thread_id' => $thread->id,
                'prompt' => $prompt,
                'output' => $scopeViolation,
                'status' => 'completed',
                'tokens_used' => 0,
            ]);

            return [
                'thread_id' => $thread->id,
                'thread' => $thread,
                'user_message' => $userMessage,
                'assistant_message' => $assistantMessage,
                'run_id' => $run->id,
                'provider' => $config->provider,
                'model' => $config->model,
                'tokens_used' => 0,
            ];
        }

        // Build live SME business context with multi-tenancy & role awareness
        $businessContext = $this->gatherBusinessContext($orgId, $user);
        $systemInstruction = $this->buildSystemInstruction($config, $businessContext, $orgId, $user);

        // Fetch recent messages in current thread
        $previousMessages = ChatMessage::where('thread_id', $thread->id)
            ->where('id', '!=', $userMessage->id)
            ->orderByDesc('created_at')
            ->take(6)
            ->get()
            ->reverse()
            ->values();

        $hub->working($taskId, $taskTitle, $contextModule, $orgId);

        // Strictly call only the chosen provider
        if ($config->provider === 'ollama') {
            $aiResponse = $this->callOllama($config, $prompt, $systemInstruction, $previousMessages);
        } else {
            $aiResponse = $this->callGemini($config, $prompt, $systemInstruction, $previousMessages);
        }

        $assistantText = static::cleanMarkdown($aiResponse['content']);
        $tokensUsed = $aiResponse['tokens_used'];
        $providerUsed = $aiResponse['provider'];
        $modelUsed = $aiResponse['model'];

        // Save Assistant Message
        $assistantMessage = ChatMessage::create([
            'thread_id' => $thread->id,
            'role' => 'assistant',
            'content' => $assistantText,
            'metadata' => [
                'provider' => $providerUsed,
                'model' => $modelUsed,
                'tokens_used' => $tokensUsed,
                'context_module' => $contextModule,
            ],
        ]);

        // Record Agent Run
        $run = AgentRun::create([
            'org_id' => $orgId,
            'agent_config_id' => $config->id,
            'thread_id' => $thread->id,
            'prompt' => $prompt,
            'output' => $assistantText,
            'status' => 'completed',
            'tokens_used' => $tokensUsed,
        ]);

        $hub->finished($taskId, $taskTitle, $contextModule, $orgId);

        return [
            'thread_id' => $thread->id,
            'thread' => $thread,
            'user_message' => $userMessage,
            'assistant_message' => $assistantMessage,
            'run_id' => $run->id,
            'provider' => $providerUsed,
            'model' => $modelUsed,
        ];
    }

    /**
     * Execute Gemini API call.
     */
    protected function callGemini(AgentConfig $config, string $prompt, string $systemInstruction, $previousMessages): array
    {
        $apiKey = $config->gemini_api_key ?: config('services.gemini.api_key');
        $model = $config->gemini_model ?: config('services.gemini.model', 'gemini-2.5-flash');

        if (empty($apiKey)) {
            return [
                'content' => "Kunci Google Gemini API belum ditetapkan. Sila masukkan Kunci API syarikat anda melalui menu 'Tetapan Enjin AI' di atas atau tetapkan GEMINI_API_KEY di fail persekitaran pelayan (.env).",
                'tokens_used' => 50,
                'provider' => 'gemini',
                'model' => $model,
            ];
        }

        try {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            $contents = [];
            foreach ($previousMessages as $msg) {
                $contents[] = [
                    'role' => $msg->role === 'assistant' ? 'model' : 'user',
                    'parts' => [['text' => $msg->content]],
                ];
            }

            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $prompt]],
            ];

            $payload = [
                'contents' => $contents,
                'systemInstruction' => [
                    'parts' => [['text' => $systemInstruction]],
                ],
                'generationConfig' => [
                    'temperature' => (float) ($config->temperature ?: 0.70),
                    'maxOutputTokens' => 2048,
                ],
            ];

            $response = Http::timeout(25)->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                $tokens = $data['usageMetadata']['totalTokenCount'] ?? 150;

                if ($text) {
                    return [
                        'content' => trim($text),
                        'tokens_used' => $tokens,
                        'provider' => 'gemini',
                        'model' => $model,
                    ];
                }
            }

            $errMsg = $response->json()['error']['message'] ?? "HTTP {$response->status()}";
            Log::warning("Tuah Gemini API Error: {$errMsg}");

            return [
                'content' => "⚠️ Ralat Google Gemini ({$model}): {$errMsg}. Sila semak semula model atau kuota Kunci API anda di Tetapan Enjin AI.",
                'tokens_used' => 60,
                'provider' => 'gemini',
                'model' => $model,
            ];
        } catch (\Throwable $e) {
            Log::error("Tuah Gemini Exception: {$e->getMessage()}");

            return [
                'content' => "⚠️ Tidak dapat berhubung dengan Google Gemini API ({$model}): {$e->getMessage()}. Sila pastikan pelayan mempunyai akses internet atau semak Kunci API anda.",
                'tokens_used' => 50,
                'provider' => 'gemini',
                'model' => $model,
            ];
        }
    }

    /**
     * Execute Ollama API call.
     */
    protected function callOllama(AgentConfig $config, string $prompt, string $systemInstruction, $previousMessages): array
    {
        $url = rtrim($config->ollama_url ?: config('services.ollama.url', 'http://127.0.0.1:11434'), '/');
        $model = $config->ollama_model ?: config('services.ollama.model', 'gemma4:e2b');

        $messages = [
            ['role' => 'system', 'content' => $systemInstruction],
        ];

        foreach ($previousMessages as $msg) {
            $messages[] = [
                'role' => $msg->role,
                'content' => $msg->content,
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $prompt,
        ];

        try {
            $response = Http::timeout(45)->post("{$url}/api/chat", [
                'model' => $model,
                'messages' => $messages,
                'stream' => false,
                'options' => [
                    'temperature' => (float) ($config->temperature ?: 0.70),
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['message']['content'] ?? null;
                $tokens = ($data['prompt_eval_count'] ?? 0) + ($data['eval_count'] ?? 0);

                if ($reply) {
                    return [
                        'content' => trim($reply),
                        'tokens_used' => $tokens ?: 150,
                        'provider' => 'ollama',
                        'model' => $model,
                    ];
                }
            }

            $errMsg = "HTTP {$response->status()}";
            Log::warning("Tuah Ollama API Error: {$errMsg}");

            return [
                'content' => "⚠️ Pelayan Ollama ({$url}) membalas dengan status ralat: {$errMsg}. Sila pastikan model '{$model}' telah selesai dimuat turun (`ollama run {$model}`).",
                'tokens_used' => 60,
                'provider' => 'ollama',
                'model' => $model,
            ];
        } catch (\Throwable $e) {
            Log::warning("Tuah Ollama Connection Error: {$e->getMessage()}");

            return [
                'content' => "⚠️ Tidak dapat berhubung dengan pelayan Ollama di '{$url}'. Sila pastikan servis Ollama sedang berjalan di pelayan anda (`ollama serve`) dan URL boleh diakses.",
                'tokens_used' => 50,
                'provider' => 'ollama',
                'model' => $model,
            ];
        }
    }

    /**
     * Check if the user prompt violates KerjaAI business-only scope.
     * Prevents token abuse (e.g. using Tuah as an unrestricted coding/hacking tool).
     */
    public function checkScopeViolation(string $prompt, ?string $orgId = null, ?User $user = null): ?string
    {
        $normalized = mb_strtolower(trim($prompt));

        // 1. Cybersecurity, exploit, vulnerability scanning, hacking tools
        $cyberSecurityPatterns = [
            'vulnerability', 'vulnerbility', 'kerentanan', 'exploit', 'cve-', 'cve ', 'cve_',
            'sql injection', 'sqli', 'cross-site scripting', 'xss', 'csrf', 'reverse shell',
            'payload', 'brute force', 'bruteforce', 'port scan', 'portscan', 'metasploit', 'nmap', 'ddos',
            'penetration test', 'pentest', 'penggodam', 'godam', 'keylogger',
            'malware', 'trojan', 'packet sniffer', 'wireshark', 'buffer overflow',
            'analisa website', 'analisis website', 'scan website', 'hacking', 'hacker',
            'burp suite', 'nikto', 'hydra', 'gobuster', 'sqlmap',
        ];

        foreach ($cyberSecurityPatterns as $pattern) {
            if (str_contains($normalized, $pattern)) {
                return "Maaf, Tuah AI adalah pembantu pengurusan operasi perniagaan khusus untuk platform KerjaAI bagi syarikat anda.\n\nSaya tidak dibenarkan menjana sebarang kod keselamatan siber, skrip analisis kerentanan (vulnerability scanner), atau alat penggodaman.\n\nPenggunaan Tuah AI dihadkan secara ketat untuk operasi perniagaan: Kewangan & Invois (Lekir), Modal Insan & Pengambilan Staf (Lekiu), Jualan/CRM & Produk (Kasturi), dan Pemasaran & Iklan (Jebat).";
            }
        }

        // 2. Disallowed external programming languages & general coding
        // RULE: General coding is strictly locked out to prevent token drain.
        // The ONLY exception allowed is HTML/CSS markup to format company business data/reports.
        $hasDisallowedLang = preg_match('/\b(python|py|php|javascript|js|typescript|ts|node|nodejs|c\+\+|cpp|c#|\bc\b|golang|go|rust|java|kotlin|swift|bash|sh|powershell|shell|solidity|ruby|perl|dart|r)\b/i', $normalized);
        $hasCodeIntent = preg_match('/\b(kod|code|script|skrip|coding|program|pengaturcaraan|fungsi|function|algoritma|algorithm)\b/i', $normalized)
            || preg_match('/\b(buat|buatkan|bina|tulis|jana|write|create|generate)\b.*?\b(kod|code|script|skrip|fungsi|function|program)\b/i', $normalized);
        $hasAllowedMarkup = preg_match('/\b(html|css|markup|templat|template)\b/i', $normalized);

        if ($hasDisallowedLang && ($hasCodeIntent || preg_match('/\b(python|py|bash|sh|c\+\+|cpp|rust|golang|java)\b/i', $normalized))) {
            return "Maaf, Tuah AI tidak dibenarkan menjana kod pengaturcaraan umum bagi mengelakkan pembaziran token dan penyalahgunaan sistem.\n\nSistem ini hanya menyokong kod format **HTML / CSS** khusus untuk paparan data perniagaan syarikat anda di KerjaAI (seperti templat cetakan invois HTML, reka bentuk penyata kewangan, atau templat emel rasmi syarikat).\n\nSila kemukakan soalan berkaitan operasi dan pengurusan perniagaan syarikat anda.";
        }

        if ($hasCodeIntent && !$hasAllowedMarkup) {
            return "Maaf, Tuah AI dihadkan secara ketat untuk operasi perniagaan dan tidak berfungsi sebagai enjin jana kod umum (general programming generator).\n\nSekiranya anda memerlukan kod untuk paparan sistem, Tuah AI hanya membenarkan format **HTML / CSS** untuk mempersembahkan data perniagaan syarikat ini (contohnya jadual invois, penyata untung rugi, atau templat cetakan dokumen rasmi).";
        }

        // 3. Multi-tenant boundary check (Non-Superadmin cannot query other companies)
        if ($user && !$user->isSuperadmin()) {
            $isCrossTenantAttempt = preg_match('/\b(data|maklumat|rekod|invois|kakitangan|staf|jualan|untung|hasil)\b.*?\b(syarikat|kompeni|organisasi|tenant)\s+lain\b/i', $normalized)
                || preg_match('/\b(senarai|tunjuk|papar|lihat|senaraikan)\b.*?\b(semua\s+)?(syarikat|kompeni|organisasi)\b.*?\b(sistem|platform|pangkalan\s+data|database)\b/i', $normalized)
                || preg_match('/\b(cross[- ]tenant|cross[- ]company|merentas\s+syarikat|kompeni\s+sebelah)\b/i', $normalized);

            if ($isCrossTenantAttempt) {
                $org = $orgId ? Org::find($orgId) : null;
                $orgName = $org?->name ?? 'syarikat anda';
                return "Maaf, akses data dihadkan secara ketat kepada syarikat yang anda log masuk sahaja ({$orgName}) selaras dengan dasar kedaulatan data berbilang penyewa (multi-tenancy) KerjaAI.\n\nAkaun anda tidak mempunyai kebenaran Superadmin untuk melihat atau merentas data syarikat/organisasi lain.";
            }
        }

        return null;
    }

    /**
     * Build the strict system instruction ensuring scope guardrails and tenant data isolation.
     */
    protected function buildSystemInstruction(
        AgentConfig $config,
        string $businessContext,
        string $orgId,
        ?User $user = null
    ): string {
        $org = Org::find($orgId);
        $orgName = $org?->name ?? 'Syarikat Semasa';
        $isSuperadmin = $user?->isSuperadmin() ?? false;

        $tenancyRule = $isSuperadmin
            ? "PENGGUNA INI ADALAH SUPERADMIN SISTEM: Pengguna mempunyai hak akses pentadbir super. Anda dibenarkan menganalisis data merentas syarikat dan status keseluruhan platform KerjaAI sekiranya diminta oleh Superadmin."
            : "ISOLASI DATA SYARIKAT (MULTI-TENANCY SOVEREIGNTY): Anda HANYA mempunyai akses kepada syarikat '{$orgName}' (ID: {$orgId}). Anda DILARANG KERAS merujuk, mendedahkan, merentas penyewa (cross-tenant), atau meneka data syarikat lain, pentadbir lain, atau sistem luar. Sekiranya pengguna meminta data syarikat lain atau meminta perbandingan rentas syarikat, tolak dengan tegas atas dasar kerahsiaan dan kedaulatan data syarikat.";

        $guardrails = <<<PROMPT
=== PERANAN & HAD KESELAMATAN TUAH AI (SISTEM OPERASI PERNIAGAAN KERJAAI) ===
1. PERANAN UTAMA: Anda adalah Tuah AI, pembantu operasi perniagaan pintar Malaysia khusus untuk platform KerjaAI. Anda membantu pengurusan syarikat merentas modul: Kewangan & Invois (Lekir), Modal Insan & Pengambilan Staf (Lekiu), Jualan/CRM & Produk (Kasturi), dan Pemasaran & Iklan (Jebat).
2. HAD KOD PENGATURCARAAN (PROGRAMMING SCOPE RESTRICTION):
   - Anda DILARANG sama sekali menjana kod pengaturcaraan umum (seperti Python, Bash, C++, Java, Rust, Go, PHP backend, skrip penggodaman, atau analisis kerentanan keselamatan web).
   - SATU-SATUNYA pengecualian kod yang dibenarkan adalah kod HTML / CSS untuk memformat, mereka bentuk laporan, atau templat dokumen bagi data perniagaan syarikat ini di dalam KerjaAI (contoh: templat invois HTML, jadual penyata untung rugi, atau templat emel rasmi hebahan kakitangan).
   - Sekiranya pengguna meminta anda membina kod di luar skop HTML data perniagaan syarikat ini, tolak dengan sopan dan jelaskan had peranan anda sebagai pembantu perniagaan KerjaAI.
3. KAWALAN DATA MULTI-PENYEWA (MULTI-TENANCY):
   {$tenancyRule}
4. KAWALAN PENGGUNAAN TOKEN & PENGELAKAN PENYALAHGUNAAN:
   - Jawab secara tepat, profesional, dan padat dalam Bahasa Melayu perniagaan Malaysia.
   - Jangan bertindak sebagai model sembang umum (ChatGPT) untuk tugasan luar seperti kerja sekolah, hal peribadi, atau perbualan yang tiada kaitan dengan perniagaan.
PROMPT;

        $userSystemPrompt = trim($config->system_prompt ?? '');
        if (!empty($userSystemPrompt)) {
            $guardrails .= "\n\nTETAPAN ARAHAN TAMBAHAN SYARIKAT:\n" . $userSystemPrompt;
        }

        $guardrails .= "\n\n" . $businessContext;

        return trim($guardrails);
    }

    /**
     * Gather live SME business metrics for Malaysian operational context.
     */
    protected function gatherBusinessContext(string $orgId, ?User $user = null): string
    {
        try {
            $isSuperadmin = $user?->isSuperadmin() ?? false;
            $org = Org::find($orgId);
            $orgName = $org?->name ?? 'Syarikat';

            $unpaidInvoices = FinanceInvoice::where('org_id', $orgId)
                ->whereIn('status', ['unpaid', 'partially_paid'])
                ->count();

            $totalEmployees = HrEmployee::where('org_id', $orgId)
                ->where('status', 'active')
                ->count();

            $openDeals = CrmDeal::where('org_id', $orgId)
                ->whereNotIn('stage_id', ['won', 'lost'])
                ->count();

            $openJobs = HireJob::where('org_id', $orgId)
                ->where('status', 'published')
                ->count();

            $totalProducts = \App\Models\Product::where('org_id', $orgId)->count();

            $context = "KONTEKS OPERASI PERNIAGAAN SEMASA:
- Nama Syarikat: {$orgName}
- Kewangan & Invois (Lekir): {$unpaidInvoices} invois belum dijelaskan sepenuhnya.
- Modal Insan & Pengambilan (Lekiu): {$totalEmployees} kakitangan aktif berdaftar, {$openJobs} iklan kekosongan jawatan aktif.
- Jualan / CRM & Produk (Kasturi): {$openDeals} urus niaga (deals) dalam proses pipeline, {$totalProducts} produk/servis berdaftar dalam katalog.
- Pemasaran & Iklan (Jebat): Enjin pintar automasi iklan digital berbilang saluran.";

            if ($isSuperadmin) {
                $totalOrgs = Org::count();
                $totalUsers = User::count();
                $context .= "\n\nSTATUS SUPERADMIN (AKSES MENYELURUH):
- Pengguna log masuk mempunyai kebenaran Superadmin.
- Jumlah Syarikat Berdaftar di Platform: {$totalOrgs}
- Jumlah Pengguna Platform: {$totalUsers}
- Superadmin dibenarkan meminta analitik merentas syarikat dan pemantauan sistem.";
            }

            return $context;
        } catch (\Throwable) {
            return "KONTEKS OPERASI: Platform KerjaAI bersepadu merentas Kewangan (Lekir), Modal Insan (Lekiu), Jualan/Produk (Kasturi), dan Pemasaran (Jebat) bagi syarikat ID: {$orgId}.";
        }
    }

    /**
     * Clean raw markdown to eliminate hashtags (#) and triple asterisks (***),
     * transforming headers into clean bold statements and stripping ugly artifacts.
     */
    public static function cleanMarkdown(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // 1. Remove isolated divider lines made of *** or ---
        $text = preg_replace('/^\s*[\*\-]{3,}\s*$/m', '', $text);

        // 2. Convert markdown headers (# Tajuk, ## Tajuk, ### Tajuk) into clean bold lines
        $text = preg_replace('/^#{1,6}\s*(.+)$/m', "**$1**\n", $text);

        // 3. Convert any inline triple asterisks (***teks***) to standard bold (**teks**)
        $text = str_replace('***', '**', $text);

        // 4. Clean up any excess asterisks (****+)
        $text = preg_replace('/\*{4,}/', '**', $text);

        return trim($text);
    }

    /**
     * Render markdown cleanly into semantic HTML without raw # or *** symbols.
     */
    public static function renderMarkdown(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        $cleaned = static::cleanMarkdown($text);

        return \Illuminate\Support\Str::markdown($cleaned);
    }
}
