<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.list');
    }

    public function customers_datatables()
    {
        $customers = DB::select("SELECT * FROM customers WHERE active = 1");
        return DataTables::of($customers)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255'
            ]);

            DB::insert("INSERT INTO customers (name, phone, email, active) VALUES (?, ?, ?, 1)", [
                $request->name,
                $request->phone,
                $request->email
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Customer added successfully'
                ]);
            }
            return redirect()->route('customers.list')->with('success', 'Customer added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('customers.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add customer: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('customers.list')->with('error', 'Failed to add customer');
        }
    }

    public function edit($id)
    {
        $customer = DB::selectOne("SELECT * FROM customers WHERE customer_id = ?", [$id]);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255'
            ]);

            DB::update("UPDATE customers SET name = ?, phone = ?, email = ? WHERE customer_id = ?", [
                $request->name,
                $request->phone,
                $request->email,
                $id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Customer updated successfully'
                ]);
            }
            return redirect()->route('customers.list');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('customers.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update customer: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('customers.list')->with('error', 'Failed to update customer');
        }
    }

    public function destroy($id)
    {
        try {
            DB::update("UPDATE customers SET active = 0 WHERE customer_id = ?", [$id]);

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Customer deleted successfully'
                ]);
            }
            return redirect()->route('customers.list')->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete customer'
                ], 500);
            }
            return redirect()->route('customers.list')->with('error', 'Failed to delete customer');
        }
    }
}