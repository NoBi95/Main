@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white text-black py-10 px-6">
    <div class="w-full max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-center">Restaurant Tables</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <!-- Table List -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table id="tablestable" class="min-w-full border border-gray-300 text-sm text-left mx-auto">
             
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#tablestable');
    });
</script>
@endpush
@endsection

    
