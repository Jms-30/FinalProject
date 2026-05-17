<!DOCTYPE html>
<html>
<head>
    <title>Halaman Khusus Faktur - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded border shadow-sm">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h1 class="text-lg font-bold">🛒 Halaman Faktur & Keranjang</h1>
            <a href="{{ route('user.items') }}" class="text-sm text-blue-500 hover:underline">← Kembali ke Katalog</a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-xs">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(!empty($cart))
            <table class="w-full text-sm border mb-4">
                <thead class="bg-gray-100 border-b text-xs uppercase">
                    <tr>
                        <th class="p-2 border text-left">Nama Barang</th>
                        <th class="p-2 border text-left">Harga</th>
                        <th class="p-2 border text-center">Jumlah</th>
                        <th class="p-2 border text-left">Subtotal</th>
                        <th class="p-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php 
                            $subtotal = $details['price'] * $details['quantity']; 
                            $total += $subtotal;
                        @endphp
                        <tr class="border-b text-gray-600" data-id="{{ $id }}">
                            <td class="p-2 border">
                                <div class="font-bold text-gray-800 text-xs">{{ $details['name'] }}</div>
                                <div class="text-[10px] text-gray-400">Kategori: {{ $details['category'] }}</div>
                            </td>
                            <td class="p-2 border text-xs">Rp. {{ number_format($details['price'], 0, ',', '.') }}</td>
                            <td class="p-2 border text-center">
                                <input type="number" value="{{ $details['quantity'] }}" min="1" class="w-12 border p-1 rounded text-center update-cart text-xs">
                            </td>
                            <td class="p-2 border text-xs font-semibold text-gray-900">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="p-2 border text-center">
                                <button class="text-red-500 text-xs hover:underline remove-item">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right font-bold text-base mb-6">
                Total Harga Semua Barang: <span class="text-blue-500">Rp. {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST" class="border p-4 rounded bg-gray-50 space-y-3 text-sm">
                @csrf
                <h3 class="font-bold">Informasi Pengiriman Faktur</h3>
                <div>
                    <label class="block text-xs mb-1">Alamat Pengiriman (10 - 100 karakter)</label>
                    <textarea name="address" rows="2" required class="w-full border p-2 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs mb-1">Kode Pos (5 digit)</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="w-full border p-2 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 rounded text-xs">Simpan Data Faktur & Cetak Struk</button>
            </form>
        @else
            <p class="text-center text-gray-400 py-10">Faktur belanja Anda masih kosong.</p>
        @endif
    </div>

    <script>
        document.querySelectorAll('.update-cart').forEach(input => {
            input.addEventListener('change', function() {
                let id = this.closest('tr').getAttribute('data-id');
                let qty = this.value;
                fetch("{{ route('cart.update') }}", {
                    method: "PATCH",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: JSON.stringify({ id: id, quantity: qty })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.error) alert(data.error);
                    window.location.reload();
                });
            });
        });

        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Hapus item dari faktur?')) {
                    let id = this.closest('tr').getAttribute('data-id');
                    fetch("{{ route('cart.remove') }}", {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ id: id })
                    })
                    .then(res => window.location.reload());
                }
            });
        });
    </script>
</body>
</html>