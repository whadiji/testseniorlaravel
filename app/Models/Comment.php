<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'administrator_id', 'profile_id'];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function scopeOfProfile($query,$administratorId,$profileId)
    {
        return $query->where('administrator_id',$administratorId)->where('profile_id', $profileId);
    }
}
