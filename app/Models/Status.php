<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Status extends Model
{
    //Indicamos que no deseamos proteccion para asignaciones masivas de ningun campo
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
