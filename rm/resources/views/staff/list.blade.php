@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white text-black py-10 px-6">
    <div class="w-full max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-center">Staff List</h2>

        <!-- Add Staff Button -->
        <div class="mb-4">
            <button onclick="openModal('addStaffModal')"
                class="inline-block bg-green-100 hover:bg-green-200 text-black px-4 py-2 rounded shadow transition">
                Add Staff
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table id="stafftable" class="min-w-full border border-gray-300 text-sm text-left mx-auto">
            
            </table>
        </div>
    </div>
</div>





@push('scripts')
<script>

    // DataTables init
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#stafftable');
    });
</script>
@endpush
@endsection
