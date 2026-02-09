<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\IImporter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JSONImporter implements IImporter
{

    public function importHandle(string $apiUrl, int $userId): array
    {
        Log::info("Начало импорта для пользователя {$userId} из {$apiUrl}");

        $user = User::findOrFail($userId);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::timeout(30)->get($apiUrl);

        if (!$response->successful()) {
            throw new Exception("API запрос не удался с кодом: " . $response->status());
        }

        $posts = $response->json();

        if (!is_array($posts)) {
            throw new Exception("API вернул неожиданный формат данных");
        }

        Log::info("Импортируем " . count($posts) . " заметок");

        DB::beginTransaction();

        try {

            foreach ($posts as $index => $post) {

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
            };

            DB::commit();

            Log::info("Импорт успешно завершен для пользователя {$userId}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Ошибка импорта: " . $e->getMessage());
            throw $e;
        }
        return [];
    }
}
