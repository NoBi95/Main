<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = DB::select('select * from users where email = ?', [$request->email]);

    if (!empty($user) && Hash::check($request->password, $user[0]->password)) {
        $token = Str::random(60);

        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\\Models\\User',
            'tokenable_id' => $user[0]->id,
            'name' => 'auth-token',
            'token' => hash('sha256', $token),
            'abilities' => json_encode(['*']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'access_token' => $token,
            'email' => $user[0]->email,
            'user_id' => $user[0]->id,
            'token_type' => 'Bearer',
        ]);
    }

    // Add this return for failed login
    return response()->json([
        'status' => 'error',
        'message' => 'Invalid credentials',
    ], 401);
}

}
