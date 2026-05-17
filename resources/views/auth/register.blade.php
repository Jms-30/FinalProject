<!DOCTYPE html>
<html>
<head>
    <title>Register - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 flex justify-center">
    <div class="bg-white p-8 rounded border w-96 shadow-sm mt-5">
        <h2 class="text-xl font-bold mb-4 text-center">Daftar Akun Baru</h2>

        @if ($errors->any())
            <div class="text-red-500 text-sm mb-3">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm mb-1">Nomor HP</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" required class="w-full border p-2 rounded text-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded text-sm font-bold hover:bg-blue-600">Register</button>
        </form>
        <p class="text-xs text-center mt-4">Sudah ada akun? <a href="{{ route('login') }}" class="text-blue-500">Login disini</a></p>
    </div>
</body>
</html>