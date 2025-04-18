<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestock extends Model
{
    use HasFactory;

    protected $table = 'livestocks';
    protected $fillable = [
        'id','type_livestock','state_productive','fast_notes', 'farms_id'
    ];
    // public $timestamps=false;

    // para mostrar de que finca es ese ganado
    public function farms()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    // *----------------------Relaciones para validar la eliminacion de los datos------------*
}
