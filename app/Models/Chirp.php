<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;
    /* 
    si agregas las columnas message, type y date a 
    la propiedad $fillable del modelo Chirp, podrás
     crear un nuevo registro y asignar valores a 
     estas columnas al mismo tiempo utilizando el método create.
    */
    //dentro del array fillable vamos a poner los datos que querramos protejer de asignacion masiva
    //en este caso seria la columna message de nuestra base de datos
    protected $fillable = [
        'message',
    ];

    //cuando se cree una chirp se dispara el evento
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class
    ];

    //relacion de uno a uno (un chirp puede tener un usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
