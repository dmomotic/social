<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    public function store()
    {
        request()->validate(['body' => 'required|min:5']);

        $status = Status::create([
            'body' => request('body'),
            'user_id' => auth()->id()
            ]);
        return response()->json(['body' => $status->body]);
    }

    public function index(){
        //La funcion latest() ordena por fecha de creacion del mas reciente al mas antiguo
        return Status::latest()->paginate(); //Automaticamente retoran un JSON
    }
}
