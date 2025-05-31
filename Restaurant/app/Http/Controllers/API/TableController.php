<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function list()
    {
        $tables = DB::select("SELECT * FROM tables WHERE active = 1");
        return response()->json(['status' => 'success', 'data' => $tables]);
    }

    public function show($id)
    {
        $table = DB::selectOne("SELECT * FROM tables WHERE table_id = ? AND active = 1", [$id]);

        if (!$table) {
            return response()->json(['status' => 'error', 'message' => 'Table not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $table]);
    }
}
