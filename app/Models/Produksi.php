<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi';
    
    protected $fillable = [
        'line',
        'part_number',
        'part_name',
        'qty_system',
        'qty_aktual',
        'gap',
    ];
}