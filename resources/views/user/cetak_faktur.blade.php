<!DOCTYPE html>
<html>
<head>
    <title>Cetak Faktur - {{ $invoice->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-6 flex flex-col items-center">
    <div class="w-full max-w-2xl no-print flex justify-between mb-4 bg-white p-3 rounded border text-xs">
        <a href="{{ route('user.items') }}" class="bg-gray-500 text-white py-1 px-3 rounded">← Kembali ke Katalog</a>
        <button onclick="window.print()" class="bg-green-500 text-white py-1 px-4 rounded font-bold">🖨️ Cetak Struk</button>
    </div>

    <div class="w-full max-w-2xl bg-white border p-6 text-sm text-gray-800 shadow-sm">
        <div class="text-center border-b pb-3 mb-4">
            <h1 class="text-xl font-bold tracking-wide">STRUK FAKTUR PENJUALAN</h1>
            <p class="text-xs text-gray-400">PT Londo Bell - Divisi Logistics</p>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs border p-3 rounded bg-gray-50 mb-4">
            <div>
                <p class="text-gray-400 font-bold">NOMOR INVOICE</p>
                <p class="font-mono font-bold text-blue-600 text-sm">{{ $invoice->invoice_number }}</p>
                <p class="text-gray-400 font-bold mt-2">TANGGAL</p>
                <p>{{ $invoice->created_at->format('d/m/Y H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-gray-400 font-bold">NAMA PEMBELI</p>
                <p class="font-semibold">{{ $invoice->user->name }}</p>
                <p class="text-gray-400 font-bold mt-2">NOMOR HP</p>
                <p>{{ $invoice->user->phone_number }}</p>
            </div>
        </div>

        <div class="border p-3 rounded text-xs mb-4">
            <p class="text-gray-400 font-bold mb-1">ALAMAT PENGIRIMAN</p>
            <p class="text-gray-700">{{ $invoice->address }}</p>
            <p class="font-bold mt-1 text-gray-800">Kode Pos: {{ $invoice->postal_code }}</p>
        </div>

        <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">Rincian Pembelian</h3>
        <table class="w-full text-left text-xs border mb-4">
            <thead class="bg-gray-50 font-bold">
                <tr>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Nama Barang & Jumlah</th>
                    <th class="p-2 border">Harga Satuan</th>
                    <th class="p-2 border text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $id => $item)
                    <tr>
                        <td class="p-2 border text-gray-400 uppercase text-[10px] font-bold">{{ $item['category'] }}</td>
                        <td class="p-2 border font-medium">{{ $item['name'] }} <span class="text-blue-500 font-bold">x{{ $item['quantity'] }}</span></td>
                        <td class="p-2 border">Rp. {{ number_format($item['image'] ?? $item['price'], 0, ',', '.') }}</td>
                        <td class="p-2 border text-right font-bold text-gray-900">Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border p-3 rounded bg-gray-50 flex justify-between items-center font-bold">
            <span>TOTAL PEMBAYARAN:</span>
            <span class="text-lg text-blue-600">Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}</span>
        </div>
    </div>
</body>
</html>