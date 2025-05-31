<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function list()
    {
        $staff = DB::select("SELECT * FROM staff WHERE active = 1");
        return response()->json(['status' => 'success', 'data' => $staff]);
    }

    public function show($id)
    {
        $staff = DB::selectOne("SELECT * FROM staff WHERE staff_id = ? AND active = 1", [$id]);

        if (!$staff) {
            return response()->json(['status' => 'error', 'message' => 'Staff not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $staff]);
    }
}
