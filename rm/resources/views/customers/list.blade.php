@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white text-black py-10 px-6">
    <div class="w-full max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-center">Customer List</h2>


   <!-- Modal backdrop -->
<div id="modal-backdrop" class="hidden bg-gray-900/50 fixed inset-0 z-40"></div>

<!-- Edit Customer Modal -->
<div id="crud-modal" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-full">
  <div class="bg-white rounded-lg shadow p-6 w-full max-w-md">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold">Edit Customer</h2>
      <button type="button" class="text-gray-500 hover:text-black close-modal">&times;</button>
    </div>

    <form id="updateCustomerForm">
      <input type="hidden" id="id" name="id" />

      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" class="w-full border rounded px-3 py-2" required />
      </div>

      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" id="phone" name="phone" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="flex justify-end">
        <button type="submit" id="updateCustomer" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      </div>
    </form>
  </div>
</div>


        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table id="customertable" class="min-w-full border border-gray-300 text-sm text-left mx-auto">
              
            </table>
        </div>
    </div>
</div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#customertable');
    });
</script>
@endpush
@endsection
