<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;
    protected $fillable =[
        'file_name',
        'file_type',
        'model_id',
        'model_type'
    ];

}
