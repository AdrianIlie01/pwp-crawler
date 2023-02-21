<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Categories extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function slug() {
//        $this->attributes['slug'] = Str::slug($this->name,'-');

        return Str::slug($this->name, '-');
//        $lastParam = basename(parse_url($value, PHP_URL_PATH));
//        $this->attributes['name'] = $lastParam;
    }
    public function categoryLikns() {
        return $this->hasMany(CategoryLinks::class);
    }
    public function announces() {
        return $this->hasMany(Announces::class);
    }
}
