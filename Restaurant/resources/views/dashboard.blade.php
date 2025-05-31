@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h2 class="text-2xl font-bold mb-4">Sales & Orders Analytics</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Customers --}}
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-gray-500 mb-2">Customers</p>
            <div class="flex justify-center gap-2 mb-3">
                <button id="custWeeklyBtn" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Weekly</button>
                <button id="custMonthlyBtn" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Monthly</button>
            </div>
            <h3 id="customerCount" class="text-3xl font-bold text-indigo-600">{{ $weeklyCustomers }}</h3>
        </div>

        {{-- Orders Chart --}}
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-gray-500 mb-2">Orders</p>
            <div class="flex justify-center gap-2 mb-3">
                <button id="ordersWeeklyBtn" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Weekly</button>
                <button id="ordersMonthlyBtn" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Monthly</button>
            </div>
            <canvas id="ordersChart" height="120"></canvas>
        </div>

        {{-- Best Sellers --}}
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-gray-500 mb-2">Best Sellers</p>
            <div class="flex justify-center gap-2 mb-3">
                <button id="bestWeeklyBtn" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Weekly</button>
                <button id="bestMonthlyBtn" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Monthly</button>
            </div>
            <ul id="bestSellerList" class="text-left text-sm text-gray-700 space-y-1 max-h-40 overflow-y-auto">
                @foreach ($weeklyBestSellers as $item)
                    <li><span class="font-semibold">{{ $item->name }}</span> — {{ $item->total_sold }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.dashboardData = {
        weeklyCustomers: {{ $weeklyCustomers }},
        monthlyCustomers: {{ $monthlyCustomers }},
        weeklyData: @json($weeklyData),
        monthlyData: @json($monthlyData),
        weeklyBestSellers: @json($weeklyBestSellers),
        monthlyBestSellers: @json($monthlyBestSellers)
    };
</script>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
