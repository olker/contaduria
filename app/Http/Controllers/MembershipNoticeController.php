<?php

namespace App\Http\Controllers;

class MembershipNoticeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasActiveMembership()) {
            return redirect()->route('dashboard');
        }

        return view('user.membership-pending', [
            'expired' => $user->membershipIsExpired(),
        ]);
    }
}
