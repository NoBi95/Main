<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MenuItemsController extends Controller
{
    // Show the menu items list view
    public function index()
    {
        return view('menuitems.list');
    }

    // Fetch data for DataTables
    public function menuitems_datatables()
    {
        try {
            $items = DB::table('menuitems')
                ->select(['item_id', 'name', 'description', 'category', 'price'])
                ->where('active', 1);

            return DataTables::of($items)
                ->addIndexColumn()
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch menu items'], 500);
        }
    }

    // Store new menu item
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'category' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
            ]);

            DB::table('menuitems')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'active' => 1
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu item added successfully'
                ]);
            }

            return redirect()->route('menuitems.list')->with('success', 'Menu item added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->route('menuitems.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add menu item: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('menuitems.list')->with('error', 'Failed to add menu item');
        }
    }

    // Update an existing menu item
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'category' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
            ]);

            $updated = DB::table('menuitems')
                ->where('item_id', $id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'category' => $request->category,
                    'price' => $request->price
                ]);

            if ($updated) {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Menu item updated successfully'
                    ]);
                }

                return redirect()->route('menuitems.list')->with('success', 'Menu item updated successfully');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No changes were made or item not found'
                    ], 404);
                }

                return redirect()->route('menuitems.list')->with('error', 'No changes were made or item not found');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->route('menuitems.list')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update menu item: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('menuitems.list')->with('error', 'Failed to update menu item');
        }
    }

    // Soft delete (set active = 0)
    public function destroy($id)
    {
        try {
            $deleted = DB::table('menuitems')
                ->where('item_id', $id)
                ->update(['active' => 0]);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu item deleted successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu item not found or already deleted'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete menu item: ' . $e->getMessage()
            ], 500);
        }
    }
}
