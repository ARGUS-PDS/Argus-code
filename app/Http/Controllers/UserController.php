<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function checkEmail(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['error' => 'E-mail não informado'], 400);
        }

        $exists = User::where('email', $email)->exists();

        if ($exists) {
            return response()->json(['available' => false, 'message' => 'E-mail já em uso'], 409);
        }

        return response()->json(['available' => true, 'message' => 'E-mail disponível']);
    }
}