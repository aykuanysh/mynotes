<?php

namespace App\Jobs;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportNotesFromApiJob implements ShouldQueue
{
    use Queueable;

    protected $userId;
    protected $apiUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, string $apiUrl)
    {
        $this->userId = $userId;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("Начало импорта для пользователя {$this->userId} из {$this->apiUrl}");

            $user = User::findOrFail($this->userId);

            $response = Http::timeout(30)->get($this->apiUrl);

            if (!$response->successful()) {
                Log::error("API запрос не удался: " . $response->status());
                return;
            }

            $posts = $response->json();

            $postsToImport = $posts;

            Log::info("Импортируем " . count($postsToImport) . " заметок");

            foreach ($postsToImport as $post) {
                $user->notes()->create([
                    'title' => substr($post['title'], 0, 255),
                    'description' => $post['body'],
                    'note_date' => now(),
                ]);
            }

            Log::info("Импорт успешно завершен для пользователя {$this->userId}");
        } catch (\Exception $e) {
            Log::error("Ошибка импорта: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ImportNotesFromApiJob провалился: " . $exception->getMessage());
    }
}
