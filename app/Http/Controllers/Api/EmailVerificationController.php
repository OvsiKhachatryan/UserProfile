<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    private EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function sendVerificationEmail(Request $request)
    {
        return $this->emailVerificationService->sendVerificationEmail($request);
    }

    public function verify(Request $request)
    {
        return $this->emailVerificationService->verify($request);
    }
}
