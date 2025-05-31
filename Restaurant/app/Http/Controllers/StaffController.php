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
        $staff = DB::select("SELECT * FROM staff WHERE active = 1");
        return view('staff.list', [
            'staff' => $staff
        ]);
    }

    public function staff_datatables()
    {
        $staff = DB::select("SELECT * FROM staff WHERE active = 1");
        return DataTables::of($staff)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'role' => 'required|string|max:100',
                'hire_date' => 'required|date'
            ]);

            DB::insert("INSERT INTO staff (name, role, hire_date, active) VALUES (?, ?, ?, 1)", [
                $request->name,
                $request->role,
                $request->hire_date
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff added successfully'
                ]);
            }
            return redirect()->route('staff.list')->with('success', 'Staff added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('staff.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add staff: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('staff.list')->with('error', 'Failed to add staff');
        }
    }

    public function edit($id)
    {
        $staff = DB::selectOne("SELECT * FROM staff WHERE staff_id = ?", [$id]);
        return response()->json($staff);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'role' => 'required|string|max:100',
                'hire_date' => 'required|date'
            ]);

            DB::update("UPDATE staff SET name = ?, role = ?, hire_date = ? WHERE staff_id = ?", [
                $request->name,
                $request->role,
                $request->hire_date,
                $id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff updated successfully'
                ]);
            }
            return redirect()->route('staff.list');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->route('staff.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update staff: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('staff.list')->with('error', 'Failed to update staff');
        }
    }

    public function destroy($id)
    {
        try {
            DB::update("UPDATE staff SET active = 0 WHERE staff_id = ?", [$id]);

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff deleted successfully'
                ]);
            }
            return redirect()->route('staff.list')->with('success', 'Staff deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete staff'
                ], 500);
            }
            return redirect()->route('staff.list')->with('error', 'Failed to delete staff');
        }
    }
}