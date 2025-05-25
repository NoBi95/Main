<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
{
    $customers = DB::select("SELECT * FROM customers WHERE is_active = 1");
    return view('customers.list',[
        'customers' => $customers
    ] );
}

   public function customers_datatables()
{
    $customers = DB::select("SELECT * FROM customers WHERE is_active = 1");
    return DataTables::of($customers)->make(true);
}
    public function store(Request $request)
    {
        DB::insert("INSERT INTO customers (name, phone, email) VALUES (?, ?, ?)", [
            $request->name,
            $request->phone,
            $request->email
        ]);

        return redirect()->route('customers.list')->with('success', 'Customer added successfully');
    }

    public function edit($id)
    {
        $customer = DB::selectOne("SELECT * FROM customers WHERE customer_id = ?", [$id]);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        DB::update("UPDATE customers SET name = ?, phone = ?, email = ? WHERE customer_id = ?", [
            $request->name,
            $request->phone,
            $request->email,
            $id
        ]);

        return redirect()->route('customers.list');
    }
public function destroy($id)
{
    DB::update("UPDATE customers SET is_active = 0 WHERE customer_id = ?", [$id]);

    return redirect()->route('customers.list')->with('success', 'Customer removed from view.');
}

}
