<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Images extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    protected $table = 'images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    ];

    public function announces() {
        return $this->belongsTo(Announces::class);
    }

//    public function subcategories() {
//        return $this->hasMany(Subcategories::class);
////        return $this->belongsToMany(Subcategories::class,'categories_subcategories','categories_id','subcategories_id');
//    }
}
