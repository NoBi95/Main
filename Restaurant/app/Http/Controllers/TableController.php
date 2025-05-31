<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TableController extends Controller
{
    public function index()
    {
        return view('tables.list');
    }

    public function tables_datatables()
    {
        $tables = DB::select("SELECT * FROM tables WHERE active = 1");
        return DataTables::of($tables)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'table_number' => 'required|integer|min:1',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|string|in:Available,Occupied,Reserved'
            ]);

            DB::insert("INSERT INTO tables (table_number, capacity, status, active) VALUES (?, ?, ?, 1)", [
                $request->table_number,
                $request->capacity,
                $request->status
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Table added successfully'
                ]);
            }
            return redirect()->route('tables.list')->with('success', 'Table added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('tables.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add table: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('tables.list')->with('error', 'Failed to add table');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'table_number' => 'required|integer|min:1',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|string|in:Available,Occupied,Reserved'
            ]);

            DB::update("UPDATE tables SET table_number = ?, capacity = ?, status = ? WHERE table_id = ?", [
                $request->table_number,
                $request->capacity,
                $request->status,
                $id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Table updated successfully'
                ]);
            }
            return redirect()->route('tables.list');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('tables.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update table: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('tables.list')->with('error', 'Failed to update table');
        }
    }

    public function destroy($id)
    {
        try {
            DB::update("UPDATE tables SET active = 0 WHERE table_id = ?", [$id]);

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Table deleted successfully'
                ]);
            }
            return redirect()->route('tables.list')->with('success', 'Table deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete table'
                ], 500);
            }
            return redirect()->route('tables.list')->with('error', 'Failed to delete table');
        }
    }
}