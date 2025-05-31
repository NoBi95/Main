<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MenuItemsController extends Controller
{
    public function index()
    {
        $menuItems = DB::select("SELECT * FROM menuitems WHERE is_active = 1");
        return view('menuitems.list', [
        'menuitems' => $menuItems
    ] );
    }
    public function menuitems_datatables()
{
    $menuItems = DB::table('menuitems')->where('is_active', 1);
    return DataTables::of($menuItems)->make(true);
}

   
}
