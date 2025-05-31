<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // Returns full customer data where active = 1
    public function list()
    {
        $customers = DB::select("SELECT * FROM customers WHERE active = 1");

        return response()->json([
            'status' => 'success',
            'rows' => count($customers),
            'data' => $customers
        ]);
    }

    public function listIds()
    {
        $customerIds = DB::select("SELECT customer_id FROM customers WHERE active = 1");

        return response()->json([
            'status' => 'success',
            'rows' => count($customerIds),
            'data' => $customerIds
        ]);
    }
}
