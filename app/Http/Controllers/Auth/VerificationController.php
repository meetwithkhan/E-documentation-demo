<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Manual signature verification since we're overriding
        if (! hash_equals(
            (string) $request->route('id'),
            (string) $request->user()?->getKey()
        )) {
            abort(403, 'Invalid verification link.');
        }

        if (! hash_equals(
            (string) $request->route('hash'),
            sha1($request->user()->getEmailForVerification())
        )) {
            abort(403, 'Invalid verification link.');
        }

        if (! $request->hasValidSignature()) {
            abort(403, 'Verification link has expired.');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return view('auth.verified-welcome', [
            'user' => $request->user()->load('designation', 'department', 'function'),
        ]);
    }
}