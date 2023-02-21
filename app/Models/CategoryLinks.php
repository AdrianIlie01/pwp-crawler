<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CategoryLinks extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    protected $table = 'category_links';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function categories() {
        return $this->belongsTo(Categories::class);
    }
    // hasMany
}
