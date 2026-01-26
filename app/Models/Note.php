<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'description',
        'note_date',
        'user_id',
        'user_note_id'
    ];

        protected $casts = [
        'note_date' => 'date',
    ];


     protected static function boot()
    {
        parent::boot();

        // Автоматически устанавливаем user_note_id при создании заметки
        static::creating(function ($note) {
            if (is_null($note->user_note_id)) {
                // Находим максимальный user_note_id для этого пользователя
                $maxId = static::where('user_id', $note->user_id)
                    ->max('user_note_id');
                
                // Устанавливаем следующий номер (или 1 если это первая заметка)
                $note->user_note_id = ($maxId ?? 0) + 1;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
