<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Pastikan $request tidak null
        if (!$request) {
            return back()->withErrors(['error' => 'Invalid request']);
        }

        // Pastikan user terautentikasi sebelum mengakses
        $user = $request->user();
        if (!$user) {
            return back()->withErrors(['error' => 'User not authenticated']);
        }

        // Pastikan user telah terverifikasi email
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Kirim notifikasi verifikasi email
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}

