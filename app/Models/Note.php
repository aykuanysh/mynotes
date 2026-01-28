<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

        static::creating(function ($note) {
            if (is_null($note->user_note_id)) {
                $maxId = static::where('user_id', $note->user_id)
                    ->max('user_note_id');

                $note->user_note_id = ($maxId ?? 0) + 1;
            }
        });
    }

    /**
     * @return BelongsTo<User, Note>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
