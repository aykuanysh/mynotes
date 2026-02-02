<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'title',
        'description',
        'note_date',
        'user_id',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    /**
     * @return BelongsTo<User, Note>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
