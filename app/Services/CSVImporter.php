<?php

namespace App\Services;

use App\Services\Interfaces\IImporter;

class CSVImporter implements IImporter
{
    public function importHandle(string $apiUrl, int $userId): array
    {
        return [];
    }
}
