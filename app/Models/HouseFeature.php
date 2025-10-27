<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\House;
class HouseFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'caption',
    ];
    public function house()
    {
        return $this->belongsTo(House::class);
    }

}
