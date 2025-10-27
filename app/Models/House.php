<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HouseFeature;
class House extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'description',
    'price',
    'location',
    'image',
    'user_id',
    'status',
    ];
    
    public function features()
    {
        return $this->hasMany(HouseFeature::class);
    }
}
