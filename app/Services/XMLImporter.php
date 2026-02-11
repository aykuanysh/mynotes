<?php

namespace App\Services;

use App\Services\Interfaces\IImporter;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class XMLImporter implements IImporter
{
    public function importHandle(string $source, int $userId): void
    {
        $user = User::findOrFail($userId);
        $filePath = Storage::path($source);
        $xml = simplexml_load_file($filePath);

        if ($xml === false) {
            throw new Exception("Не удалось загрузить XML файл: {$filePath}");
        }

        DB::beginTransaction();

        try {
            foreach ($xml->note as $note) {
                $user->notes()->create([
                    'title' => substr((string)$note->title, 0, 255),
                    'description' => (string) ($note->description ?? ''),
                    'note_date' => !empty((string)$note->note_date) ? (string)$note->note_date : now()
                ]);
            }

            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error("Импорт заметок из XML файла не удался: " . $err->getMessage());
            throw $err;
        }
    }
}
