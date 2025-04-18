<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_history';
    protected $fillable = [
        'id','payment_receipt_date','amount_received','outstanding_balance',
        'total_work_balance', 'fast_notes', 'work_id', 'farms_id', 'user_veterinarian_charge_id'
    ];
    // public $timestamps=false;

    // para mostrar el trabajo al cual pertenece el pago
    public function works()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }

    // para la finca que le debe dinero al veterinario
    public function farms()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    // *----------------------Relaciones para validar la eliminacion de los datos------------*
    public function users()
    {
        return $this->belongsTo(User::class, 'user_veterinarian_charge_id');
    }
}
