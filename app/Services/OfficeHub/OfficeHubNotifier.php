<?php

namespace App\Services\OfficeHub;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Hantar progress task KerjaAI ke EA AI Office Hub (POST /api/ingest?src=generic).
 * Satu task = satu "staff" di office (agent key = task-<id>).
 * Tidak pernah membaling ralat: kegagalan hub tak boleh ganggu user.
 */
class OfficeHubNotifier
{
    /** Modul KerjaAI -> department di office. */
    private const DEPARTMENTS = [
        'crm' => 'frontdesk',
        'finance' => 'approval',
        'hr' => 'meeting',
        'hire' => 'meeting',
        'marketing' => 'research',
        'general' => 'kanban',
    ];

    public function started(string $taskId, string $title, ?string $module, ?string $org): void
    {
        $this->send($taskId, 'prompt', $title, $module, $org, 'kanban');
    }

    public function working(string $taskId, string $title, ?string $module, ?string $org): void
    {
        $this->send($taskId, 'tool_start', $title, $module, $org);
    }

    public function finished(string $taskId, string $title, ?string $module, ?string $org): void
    {
        $this->send($taskId, 'turn_done', $title, $module, $org);
        $this->send($taskId, 'session_end', $title, $module, $org);
    }

    public function failed(string $taskId, string $title, ?string $module, ?string $org): void
    {
        $this->send($taskId, 'error', $title, $module, $org);
    }

    private function send(string $taskId, string $event, string $title, ?string $module, ?string $org, ?string $department = null): void
    {
        $url = config('services.office_hub.url');
        $token = config('services.office_hub.token');

        if (! $url || ! $token) {
            return;
        }

        $module = $module ?: 'general';

        try {
            Http::withToken($token)
                ->connectTimeout(1)
                ->timeout(2)
                ->post(rtrim($url, '/').'/api/ingest?src=generic', [
                    'agent' => 'task-'.$taskId,
                    'name' => mb_strimwidth($title, 0, 24, '...'),
                    'label' => 'KerjaAI',
                    'event' => $event,
                    'tool' => $module,
                    'target' => mb_strimwidth($title, 0, 80, '...'),
                    'project' => $org ? 'org-'.substr($org, 0, 8) : 'kerjaai',
                    'department' => $department ?? (self::DEPARTMENTS[$module] ?? 'kanban'),
                    'pc' => 'kerjaai.my',
                    'ts' => now()->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            Log::debug('OfficeHub notify gagal: '.$e->getMessage());
        }
    }
}
