<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Owner extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    protected $table = 'owner';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
    ];

    public function announces() {
        return $this->hasMany(Announces::class);
    }
}
