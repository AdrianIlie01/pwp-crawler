<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Announces extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    protected $table = 'announces';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'subcategory',
        'car_body',
        'price',
        'manufacture_year',
        'mileage_km',
        'combustible',
        'gearbox',
        'engine_capacity',
        'hp_power',
        'color',
        'steering_wheel',
        'status'
    ];
    public function categories() {
        return $this->belongsTo(Categories::class);
    }
    public function images() {
        return $this->hasMany(Images::class);
    }

    public function owner() {
        $this->belongsTo(Owner::class);
    }
}
