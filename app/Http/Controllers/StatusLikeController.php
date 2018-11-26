<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusLikeController extends Controller
{
    public function store(Status $status)
    {
        $status->like();
    }
}
