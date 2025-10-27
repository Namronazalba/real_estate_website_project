<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = ['house_id', 'name', 'email', 'mobile', 'message', 'is_read'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
