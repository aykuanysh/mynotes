<?php

namespace Modules\Export\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NotesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected int $userId
    ) {}

    public function collection()
    {
        return User::findOrFail($this->userId)
            ->notes()
            ->orderBy('note_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Note Date',
        ];
    }

    public function map($note): array
    {
        return [
            $note->title,
            $note->description,
            $note->note_date->format('Y-m-d'),
        ];
    }
}
