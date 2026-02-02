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
            // Логируем начало импорта
            Log::info("Начало импорта для пользователя {$this->userId} из {$this->apiUrl}");

            // Получаем пользователя
            $user = User::findOrFail($this->userId);

            // Скачиваем данные с API
            $response = Http::timeout(30)->get($this->apiUrl);

            // Проверяем что запрос успешен
            if (!$response->successful()) {
                Log::error("API запрос не удался: " . $response->status());
                return;
            }

            // Получаем данные в формате JSON
            $posts = $response->json();
            

            // Импортируем только первые 10 заметок
            $postsToImport = array_slice($posts, 0, 10);

            Log::info("Импортируем " . count($postsToImport) . " заметок");

            // Создаем заметки
            foreach ($postsToImport as $post) {
                $user->notes()->create([
                    'title' => substr($post['title'], 0, 255), // Обрезаем до 255 символов
                    'description' => $post['body'],
                    'note_date' => now(), // Текущая дата
                ]);
            }

            Log::info("Импорт успешно завершен для пользователя {$this->userId}");
        } catch (\Exception $e) {
            Log::error("Ошибка импорта: " . $e->getMessage());
            throw $e; // Перебрасываем исключение для повтора задачи
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
