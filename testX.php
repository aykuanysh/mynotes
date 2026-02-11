<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\IImporter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class XMLImporter implements IImporter
{
    public function importHandle(string $filePath, int $userId): array
    {
        Log::info("Начало XML импорта для пользователя {$userId} из {$filePath}");

        $user = User::findOrFail($userId);
        $fullPath = Storage::path($filePath);
        $xml = simplexml_load_file($fullPath);

        Log::info("Импортируем " . count($xml->note) . " заметок из XML");

        DB::beginTransaction();

        try {
            foreach ($xml->note as $index => $noteNode) {

                $title = (string) $noteNode->title;

                if (empty($title) || trim($title) === '') {
                    throw new Exception("Заметка #{$index}: отсутствует поле 'title'!");
                }

                $user->notes()->create([
                    'title' => substr($title, 0, 255),
                    'description' => (string) ($noteNode->description ?? ''),
                    'note_date' => !empty((string) $noteNode->note_date) ? (string) $noteNode->note_date : now(),
                ]);
            }

            DB::commit();

            Log::info("XML импорт успешно завершен для пользователя {$userId}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Ошибка XML импорта: " . $e->getMessage());
            throw $e;
        }

        Storage::delete($filePath);

        return [];
    }
}
