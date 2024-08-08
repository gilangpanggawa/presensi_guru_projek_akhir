<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echa extends Model
{
    use HasFactory;
    protected $table =  "echa";
    protected $primaryKey = "id_echa";
    protected $fillable = [
        'nama',
        'nim'
    ];
}
