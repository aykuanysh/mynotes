<?php

namespace App\Services\Interfaces;

interface IImporter
{
    public function importHandle(string $source, int $userId): void;
}
