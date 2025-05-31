<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    // Display all active staff
    public function index()
    {
        $staff = DB::select("SELECT * FROM staff WHERE is_active = 1");
        return view('staff.list', ['staff' => $staff]);
    }
   public function staff_datatables()
{

    $staff = DB::table('staff')->where('is_active', 1);
    return DataTables::of($staff)->make(true);
}


}
