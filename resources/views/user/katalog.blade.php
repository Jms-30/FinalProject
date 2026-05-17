<!DOCTYPE html>
<html>
<head>
    <title>Katalog Barang - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded border shadow-sm">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-xl font-bold">Katalog Produk</h1>
            <div class="flex items-center space-x-4 text-sm">
                <span>User: {{ Auth::user()->name }}</span>
                <a href="{{ route('cart.show') }}" class="bg-blue-500 text-white px-3 py-1.5 rounded font-bold">
                    Lihat Faktur ({{ session('cart') ? count(session('cart')) : 0 }})
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($items as $item)
                <div class="border rounded p-3 flex flex-col justify-between bg-white">
                    <div>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-40 object-cover rounded mb-2 border">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400 text-xs mb-2">No Image</div>
                        @endif
                        <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-bold uppercase">{{ $item->category->name }}</span>
                        <h3 class="font-bold text-sm mt-1 truncate">{{ $item->name }}</h3>
                        <p class="text-base font-semibold text-gray-800">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-1">Stok: {{ $item->quantity }} pcs</p>
                    </div>

                    <form action="{{ route('cart.add', $item->id) }}" method="POST" class="mt-3">
                        @csrf
                        @if($item->quantity <= 0)
                            <button type="button" disabled class="w-full bg-gray-200 text-gray-400 py-1 rounded text-xs cursor-not-allowed">Habis</button>
                        @else
                            <button type="submit" class="w-full bg-blue-500 text-white py-1 rounded text-xs hover:bg-blue-600">+ Ke Faktur</button>
                        @endif
                    </form>
                </div>
            @empty
                <p class="text-gray-400 text-center col-span-full py-10">Belum ada barang di katalog.</p>
            @endforelse
        </div>
    </div>
</body>
</html>