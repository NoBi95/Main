<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TableController extends Controller
{
    public function index()
    {
        $tables = DB::select("SELECT * FROM tables WHERE deleted_at IS NULL");
        return view('tables.list', ['tables' => $tables]);
    }

    public function tables_datatables()
    {
        $tables = DB::table('tables')->whereNull('deleted_at');
        return DataTables::of($tables)->make(true);
    }
}
