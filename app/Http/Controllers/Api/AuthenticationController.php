<?php

namespace App\Http\Controllers\Api;

use App\Events\WelcomeNewUserEvent;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Ahmed Rizk"),
     *             @OA\Property(property="email", type="string", example="ahmed@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="register success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ahmed Rizk"),
     *                     @OA\Property(property="email", type="string", example="ahmed@example.com")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK...")
     *             )
     *         )
     *     )
     * )
     */

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        if ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->addRole('user');
            event(new WelcomeNewUserEvent($user));
            $user->token_name = 'register_token';
            return ApiResponse::sendResponse(201, 'register success', new UserResource($user));
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="ahmed@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ahmed Rizk"),
     *                     @OA\Property(property="email", type="string", example="ahmed@example.com")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK...")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Email or password is not correct', $validator->errors()->all());
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $roles = $user->roles()->pluck('name')->toArray();
            $user->token_name = 'login_token';
            return ApiResponse::sendResponse(200, 'Login success', new UserResource($user));
            // dd($user);
        } else {
            return ApiResponse::sendResponse(401, 'Unauthorized ,Email or password is not correct ', []);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Get current user profile",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User data fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User data fetched successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Ahmed Rizk"),
     *                 @OA\Property(property="email", type="string", example="ahmed@example.com")
     *             )
     *         )
     *     )
     * )
     */

    public function profile(Request $request)
    {
        $user = $request->user();
        return ApiResponse::sendResponse(
            200,
            'User data fetched successfully',
            $user
        );
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout current user",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout successful"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return ApiResponse::sendResponse(401, 'Unauthorized', []);
        }
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200, 'Logout successful', []);
    }
}
