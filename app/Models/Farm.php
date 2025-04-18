<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;
    protected $table = 'farms';
    protected $fillable = [
        'id','name', 'total_debt', 'fast_notes', 'user_owner_id', 'user_veterinarian_charge_id'
    ];
    // public $timestamps=false;

    // para mostrar el dueño de la finca
    public function users()
    {
        return $this->belongsTo(User::class, 'user_owner_id');
    }

    // para mostrar de que finca es ese ganado
    public function livestocks()
    {
        return $this->hasMany(Livestock::class, 'farms_id');
    }

    // para mostrar la finca a la que pertenece ese trabajo
    public function works()
    {
        return $this->hasMany(Work::class, 'farms_id');
    }

    // para la finca que le debe dinero al veterinario
    public function paymentHistorys()
    {
        return $this->hasMany(PaymentHistory::class, 'farms_id');
    }

    // *----------------------Relaciones para validar la eliminacion de los datos------------*
}
