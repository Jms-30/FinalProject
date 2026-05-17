<!DOCTYPE html>
<html>
<head>
    <title>Login - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 flex justify-center">
    <div class="bg-white p-8 rounded border w-96 shadow-sm mt-10">
        <h2 class="text-xl font-bold mb-4 text-center">Login Aplikasi</h2>

        @if ($errors->any())
            <p class="text-red-500 text-sm mb-3 text-center">{{ $errors->first() }}</p>
        @endif
        @if (session('success'))
            <p class="text-green-500 text-sm mb-3 text-center">{{ session('success') }}</p>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" required class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required class="w-full border p-2 rounded text-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded text-sm font-bold hover:bg-blue-600">Login</button>
        </form>
        <p class="text-xs text-center mt-4">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500">Daftar disini</a></p>
    </div>
</body>
</html>