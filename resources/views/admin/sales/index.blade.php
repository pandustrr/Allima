@extends('admin.layouts.app')

@section('title', 'Manajemen Penjualan')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Laporan Penjualan</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.sales.index', ['period' => 'daily']) }}"
                class="px-4 py-2 rounded {{ $period === 'daily' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                Harian
            </a>
            <a href="{{ route('admin.sales.index', ['period' => 'weekly']) }}"
                class="px-4 py-2 rounded {{ $period === 'weekly' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                Mingguan
            </a>
            <a href="{{ route('admin.sales.index', ['period' => 'monthly']) }}"
                class="px-4 py-2 rounded {{ $period === 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                Bulanan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-blue-800">Total Penjualan</h3>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-green-800">Total Pesanan</h3>
            <p class="text-2xl font-bold text-green-600">{{ $totalOrders }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-purple-800">Periode</h3>
            <p class="text-xl font-bold text-purple-600">
                @if($period === 'daily')
                    Hari Ini
                @elseif($period === 'weekly')
                    Minggu Ini
                @else
                    Bulan Ini
                @endif
            </p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">No. Pesanan</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Pelanggan</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">PGTPQ</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Total</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Status</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Tanggal</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->order_number }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->customer_name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->pgtpq }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($order->status === 'selesai') bg-green-100 text-green-800
                        @elseif($order->status === 'dibatalkan') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}
                    </span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->created_at->format('d M Y H:i') }}</td>
<td class="py-2 px-4 border-b border-gray-200">
    <div class="flex space-x-2">
        <a href="{{ route('admin.sales.show', $order) }}"
           class="text-blue-600 hover:text-blue-900"
           title="Detail">
            <i class="fas fa-eye"></i>
        </a>
        <form action="{{ route('admin.sales.destroy', $order) }}"
              method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="text-red-600 hover:text-red-900"
                    title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
