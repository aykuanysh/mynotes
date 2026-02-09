<?php

namespace App\Jobs;

use App\Services\Interfaces\IImporter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportNotesFromApiJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected int $userId,
        protected string $apiUrl
    ) {}

    /**
     * Execute the job.
     */
    public function handle(IImporter $importer): void
    {
        $importer->importHandle($this->apiUrl, $this->userId);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ImportNotesFromApiJob провалился: " . $exception->getMessage());
    }
}
