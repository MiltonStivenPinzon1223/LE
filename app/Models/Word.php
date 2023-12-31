<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $primaryKey = 'wor_id';
    protected $fillable = [
        'wor_english',
        'wor_spanish',
        'cat_id',
    ];
}
