<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResources;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('no_hp', $request->no_hp)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['message' => 'Invalid Credentials']);
            }

            $accessToken = $user->createToken(
                'authToken',
                ['*'],
                Carbon::now()->addMonth()
            )->plainTextToken;

            return ResponseFormatter::success(
                [
                    'user' => UserResources::make($user),
                    'access_token' => $accessToken,
                    'token_type' => 'Bearer',
                ],
                "Successful Login"
            );
        } catch (ValidationException $validationError) {
            return ResponseFormatter::error(
                message: $validationError->getMessage(),
                code: JsonResponse::HTTP_UNAUTHORIZED
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(null, $error->getMessage());
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $request['password'] = bcrypt($request->tanggal_lahir);
            $user = User::create($request->all());
            event(new Registered($user));
            $accessToken = $user->createToken(
                'authToken',
                ['*'],
                Carbon::now()->addMonth()
            )->plainTextToken;
            return ResponseFormatter::success(
                [
                    'user' => UserResources::make($user),
                    'access_token' => $accessToken,
                    'token_type' => 'Bearer',
                ],
                'Successfully Register New User'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(null, $error->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
            if ($status != Password::RESET_LINK_SENT) {
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }
            return ResponseFormatter::success('Silahkan check email Anda', 'Successfully Send Reset Email');
        } catch (ValidationException $validationError) {
            return ResponseFormatter::error(
                [
                    'message' => $validationError->getMessage(),
                    'code' => JsonResponse::HTTP_BAD_REQUEST
                ],
                'Reset Password Failed'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(null, $error->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success(
            $token ? "Successfully Logout" : "Failed Logout",
            'Token Revoked'
        );
    }
}
