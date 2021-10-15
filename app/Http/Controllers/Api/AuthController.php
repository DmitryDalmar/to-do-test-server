<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User\User;
use App\Services\User\UserService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Hash;
use DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))
            ->first();

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages(['password' => 'Имя пользователя и пароль не совпадают!']);
        }

        auth()->login($user);

        $token = $user->createToken('spa-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => (new UserService($user))
                ->withAvatar()
                ->get(),
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $user->email_verified_at = Carbon::now();
        $user->save();

        $token = $user->createToken('spa-token')->plainTextToken;

        auth()->login($user);

        DB::commit();

        return response()->json([
            'token' => $token,
            'user' => (new UserService($user))
                ->withAvatar()
                ->get(),
        ], 200);
    }

    public function logout()
    {
        /* @var \App\Models\User\User $user */
        if ($user = auth()->user()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'logout'], 200);
    }
}
