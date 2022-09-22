<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['devices','patients'])
        ->where('id', auth()->id())
        ->first();
        // dd($user);
        return view('user.index')->with(['user'=>$user]);
    }
}
