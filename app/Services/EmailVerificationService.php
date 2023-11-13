<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationService
{


    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return [
                'message' => 'Already Verified'
            ];
        }

        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);
        if (! hash_equals((string) $user->getKey(), (string) $request->id)) {
            return false;
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->hash)) {
            return false;
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return [
            'message' => 'Email has been verified'
        ];
    }
}
