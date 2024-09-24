<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'administrator_id', 'profile_id'];
    
   
    /**
     * Get the administrator that owns the comment.
     *
     * @return BelongsTo<Administrator, Comment>
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }

     /**
     * Get the profile that owns the comment.
     *
     * @return BelongsTo<Profile, Comment>
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
  
    /**
     * Scope a query to only include comments of a specific profile.
     *
     * @param Builder $query
     * @param int $administratorId
     * @param int $profileId
     * @return Builder
     */
    public function scopeOfProfile(Builder $query, int $administratorId,int $profileId): Builder
    {
        return $query->where('administrator_id', $administratorId)->where('profile_id', $profileId);
    }
}
