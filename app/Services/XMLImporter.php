<?php

namespace App\Services;

use App\Services\Interfaces\IImporter;

class XMLImporter implements IImporter
{

    public function importHandle(string $apiUrl, int $userId): array
    {
        return [];
    }
}
