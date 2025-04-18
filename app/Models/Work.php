<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'works';
    protected $fillable = [
        'id', 'work_number', 'date_work','cows_seeded','cows_palpated', 'cows_calved', 'price_overall',
        'fast_notes', 'status', 'farms_id', 'user_veterinarian_charge_id'
    ];
    // public $timestamps=false;

    // para mostrar la finca a la que pertenece ese trabajo
    public function farms()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    // para mostrar el trabajo al cual pertenece el pago
    public function paymentHistorys()
    {
        return $this->hasMany(PaymentHistory::class, 'work_id');
    }

    // *----------------------Relaciones para validar la eliminacion de los datos------------*
    public function users()
    {
        return $this->belongsTo(User::class, 'user_veterinarian_charge_id');
    }
}
