<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipNoticeController extends Controller
{
    public function index()
    {
        // Si el usuario ya está activo, lo mandamos al dashboard normal
        if (auth()->user()->is_admin || auth()->user()->membership_status === 'active') {
            return redirect()->route('dashboard');
        }

        return view('user.membership-pending');
    }
}