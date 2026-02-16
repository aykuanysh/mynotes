<?php

namespace Modules\Export\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Export\Exports\NotesExport;

class ExportNotesJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected int $userId,
        protected string $filePath
    ) {}

    public function handle(): void
    {
        Log::info("Начало экспорта заметок для пользователя: {$this->userId}");

        Excel::store(
            new NotesExport($this->userId),
            $this->filePath,
            'local'
        );

        Log::info("Экспорт заметок завершён: {$this->filePath}");
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("ExportNotesJob провалился: " . $exception->getMessage());
    }
}
