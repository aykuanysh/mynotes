<?php

namespace Modules\Statistics\Services;

use App\Models\User;

class NotesStatisticsService
{
    public function getStatistics(int $userId): array
    {
        $user = User::findOrFail($userId);
        $notes = $user->notes();

        $oldest = $user->notes()->orderBy('note_date', 'asc')->first();
        $newest = $user->notes()->orderBy('note_date', 'desc')->first();

        return [
            'total' => $notes->count(),
            'last_7_days' => $user->notes()->where('note_date', '>=', now()->subDays(7))->count(),
            'last_30_days' => $user->notes()->where('note_date', '>=', now()->subDays(30))->count(),
            'oldest' => $oldest ? [
                'title' => $oldest->title,
                'date' => $oldest->note_date->format('d.m.Y'),
            ] : null,
            'newest' => $newest ? [
                'title' => $newest->title,
                'date' => $newest->note_date->format('d.m.Y'),
            ] : null,
        ];
    }
}
