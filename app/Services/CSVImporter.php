<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\IImporter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CSVImporter implements IImporter
{
    public function importHandle(string $source, int $userId): void
    {
        $user = User::findOrFail($userId);
        $filePath = Storage::path($source);
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new Exception("Не удалось открыть CSV файл: {$filePath}");
        }

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);
            throw new Exception("CSV файл пуст или не содержит заголовков");
        }

        $rows = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                fclose($handle);
                throw new Exception("Количество колонок в строке не совпадает с заголовком");
            }
            $rows[] = array_combine($header, $row);
        }

        fclose($handle);

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {

                $user->notes()->create([
                    'title' => substr($row['title'], 0, 255),
                    'description' => $row['description'] ?? '',
                    'note_date' => !empty($row['note_date']) ? $row['note_date'] : now()
                ]);
            }

            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error("Ошибка импорта CSV файла" . $err->getMessage());
            throw $err;
        }
    }
}
