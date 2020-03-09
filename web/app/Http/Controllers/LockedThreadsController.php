<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{
    public function store(Thread $thread)
    {
//        authorization - Ahora no hará falta porque se ha creado un middleware
//        if (!auth()->user()->isAdmin()) {
//            return response('You do not have permission, you cannot locked this thread', 403);
//        }
        $thread->lock();
    }
}
