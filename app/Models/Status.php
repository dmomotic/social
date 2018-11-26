<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Like;

class Status extends Model
{
    //Indicamos que no deseamos proteccion para asignaciones masivas de ningun campo
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function like()
    {
        //Si no encuentra uno crea el like para no duplilcar likes de un mismo usuario
        $this->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}
