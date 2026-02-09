<?php

namespace App\Services\Interfaces;

interface IImporter
{
    public function importHandle(string $apiUrl, int $userId): array;
}
