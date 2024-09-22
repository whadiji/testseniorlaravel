<?php

namespace App\Models;

use App\Enums\ProfileStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_name', 'administrator_id', 'first_name', 'image', 'status',
    ];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status',ProfileStatus::ACTIVE->value);
    }
}
