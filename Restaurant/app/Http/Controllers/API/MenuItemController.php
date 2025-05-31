<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    public function list()
    {
        $items = DB::select("SELECT * FROM menuitems WHERE active = 1");
        return response()->json(['status' => 'success', 'data' => $items]);
    }

    public function show($id)
    {
        $item = DB::selectOne("SELECT * FROM menuitems WHERE item_id = ? AND active = 1", [$id]);

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Menu item not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $item]);
    }
}
