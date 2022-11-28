<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'cocktail_name', 'genre', 'image' ,'degree' ,'taste','material','make','recommends'
    ]; //上書き可能なカラムの決まり文句

}
