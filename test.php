<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\IImporter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Формат CSV: id,title,description,note_date
class CSVImporter implements IImporter
{
    public function importHandle(string $filePath, int $userId): array
    {
        Log::info("Начало CSV импорта для пользователя {$userId} из {$filePath}");

        $user = User::findOrFail($userId);
        $fullPath = Storage::path($filePath);
        $handle = fopen($fullPath, 'r');


        // Пропускаем заголовок
        fgetcsv($handle);

        $rows = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }

        fclose($handle);

        Log::info("Импортируем " . count($rows) . " заметок из CSV");

        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {

                if (empty($row[1]) || trim($row[1]) === '') {
                    throw new Exception("Заметка #{$index}: отсутствует поле 'title'!");
                }

                $user->notes()->create([
                    'title' => substr($row[1], 0, 255),
                    'description' => $row[2] ?? '',
                    'note_date' => !empty($row[3]) ? trim($row[3]) : now(),
                ]);
            }

            DB::commit();

            Log::info("CSV импорт успешно завершен для пользователя {$userId}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Ошибка CSV импорта: " . $e->getMessage());
            throw $e;
        }



        return [];
    }
}
