<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'product_id'
    ]; //上書き可能なカラムの決まり文句
}
