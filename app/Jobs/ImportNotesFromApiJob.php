<?php

namespace App\Jobs;

use App\Models\Note;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::timeout(30)->get($this->apiUrl);

            if (!$response->successful()) {
                Log::error("API запрос не удался: " . $response->status());
                return;
            }

            $posts = $response->json();

            $postsToImport = $posts;

            Log::info("Импортируем " . count($postsToImport) . " заметок");

            DB::transaction(function () use ($user, $postsToImport) {

                foreach ($postsToImport as $index => $post) {

                    if (empty($post['title']) || trim($post['title']) === '') {
                        throw new Exception("Заметка #{$index}: отсутвует поле 'title'!");
                    }

                    if (!isset($post['body'])) {
                        throw new Exception("Заметка #{$index}:  отсутствует поле 'body'!");
                    }


                    $user->notes()->create([
                        'title' => substr($post['title'], 0, 255),
                        'description' => $post['body'],
                        'note_date' => now(),
                    ]);
                }
            });



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
