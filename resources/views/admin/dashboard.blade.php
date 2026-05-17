<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded border shadow-sm">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-xl font-bold">Admin Dashboard - CRUD Barang</h1>
            <div class="flex items-center space-x-4 text-sm">
                <span>Halo, {{ Auth::user()->name }} (Admin)</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-6">
                <div class="border p-4 rounded bg-gray-50">
                    <h2 class="font-bold mb-3 text-sm">Tambah Kategori Baru</h2>
                    <form action="{{ route('admin.category.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="name" required placeholder="Nama Kategori" class="w-full border p-2 text-sm rounded">
                        <button type="submit" class="w-full bg-green-500 text-white text-sm py-1.5 rounded">Simpan Kategori</button>
                    </form>
                </div>

                <div class="border p-4 rounded bg-gray-50">
                    <h2 class="font-bold mb-3 text-sm">Tambah Barang Baru</h2>
                    @if ($errors->any())
                        <div class="text-red-500 text-xs mb-2">
                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                        @csrf
                        <div>
                            <label class="block mb-1">Kategori Barang</label>
                            <select name="category_id" required class="w-full border p-2 rounded text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1">Nama Barang</label>
                            <input type="text" name="name" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="block mb-1">Harga Barang</label>
                            <input type="number" name="price" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="block mb-1">Jumlah Stok</label>
                            <input type="number" name="quantity" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="block mb-1">Foto Barang</label>
                            <input type="file" name="image" required class="w-full text-xs">
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white py-1.5 rounded font-bold">Simpan Barang</button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2 border p-4 rounded overflow-x-auto">
                <h2 class="font-bold mb-3">Daftar Pendataan Barang</h2>
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100 border-b text-xs uppercase">
                        <tr>
                            <th class="p-2 border">Foto</th>
                            <th class="p-2 border text-left">Nama Barang</th>
                            <th class="p-2 border text-left">Kategori</th>
                            <th class="p-2 border text-left">Harga</th>
                            <th class="p-2 border text-center">Stok</th>
                            <th class="p-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-b text-gray-600">
                                <td class="p-2 border text-center">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="w-10 h-10 object-cover mx-auto rounded border">
                                    @else
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    @endif
                                </td>
                                <td class="p-2 border font-medium text-gray-900">{{ $item->name }}</td>
                                <td class="p-2 border">{{ $item->category->name }}</td>
                                <td class="p-2 border font-bold">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="p-2 border text-center">{{ $item->quantity }}</td>
                                <td class="p-2 border text-center space-y-1">
                                    <button onclick="openEdit('{{ $item->id }}', '{{ $item->name }}', '{{ $item->price }}', '{{ $item->quantity }}', '{{ $item->category_id }}')" class="text-blue-500 hover:underline text-xs block mx-auto">Edit</button>
                                    <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-gray-400">Belum ada data barang di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center p-4">
        <div class="bg-white p-6 rounded border max-w-sm w-full shadow-md">
            <h3 class="font-bold mb-4">Update Data Barang</h3>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1">Kategori</label>
                    <select id="edit_category_id" name="category_id" required class="w-full border p-2 rounded text-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        </foreach>
                    </select>
                </div>
                <div>
                    <label class="block mb-1">Nama Barang</label>
                    <input type="text" id="edit_name" name="name" required class="w-full border p-2 rounded text-sm">
                </div>
                <div>
                    <label class="block mb-1">Harga</label>
                    <input type="number" id="edit_price" name="price" required class="w-full border p-2 rounded text-sm">
                </div>
                <div>
                    <label class="block mb-1">Jumlah</label>
                    <input type="number" id="edit_quantity" name="quantity" required class="w-full border p-2 rounded text-sm">
                </div>
                <div>
                    <label class="block mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" class="w-full text-xs">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeEdit()" class="bg-gray-300 px-3 py-1 rounded text-xs">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(id, name, price, quantity, categoryId) {
            document.getElementById('editForm').action = '/admin/barang/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_category_id').value = categoryId;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEdit() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>