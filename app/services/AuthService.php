<?php

namespace App\Services;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\services\SmsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function __invoke()
    {
        // You can inject dependencies here if needed
    }

    public function signup(array $data): array
    {
        // Create a new user
        $user = User::create($data);

        // Generate API token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        // Check user credentials
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get authenticated user
        /** @var User $user */
        $user = Auth::user();

        // Generate API token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function sendResetOtp(string $phone):string
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            throw new Exception("No user found with this phone number.");
        }


        $otp = rand(100000, 999999);


        PasswordResetOtp::updateOrCreate(
            ['phone' => $phone],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        $message = "Your POS App password reset OTP is: {$otp}. Valid for 10 minutes.";
        $this->smsService->sendSms($user->phone, $message);

        if(!$this->smsService->sendSms($user->phone, $message)){
            throw new Exception("Failed to send OTP. Please try again later.");
        }

        return "OTP sent successfully to your phone number.";

    }

    public function resetWithOtp(array $data):string
    {
        $record=PasswordResetOtp::where('phone',$data['phone'])->first();

        if(!$record || !$record->otp==$data['otp']){
            throw new Exception("Invalid OTP or phone number.");

        }

        if(Carbon::now()->isAfter($record->expires_at)){
            throw new Exception("OTP has expired. Please request a new one.");

        }

        User::where('phone',$data['phone'])->update(['password'=>$data['password']]);
        PasswordResetOtp::where('phone',$data['phone'])->update(['otp'=>null,'expires_at'=>null]);
        return "Password reset successfully.";
    }


}
