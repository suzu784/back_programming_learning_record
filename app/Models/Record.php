<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Record extends Model
{
    use HasFactory;

    const DRAFT_ENABLED = true;
    const DRAFT_DISABLED = false;

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_draft',
        'learning_date',
        'duration',
    ];

    public function scopeDraft($query)
    {
        return $query->where('is_draft', self::DRAFT_ENABLED);
    }

    public function scopeNotDraft($query)
    {
        return $query->where('is_draft', self::DRAFT_DISABLED);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    /**
     * 学習記録にいいねされているかを判定
     *
     * @param User|null $user ユーザー(Nullを許容)
     * @return boolean
     */
    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function countLikes(): int
    {
        return $this->likes->count();
    }
}
