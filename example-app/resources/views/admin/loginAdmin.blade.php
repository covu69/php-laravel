<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-gray-800">Admin Login</h2>

        <!-- Hiển thị thông báo lỗi -->
        @if (session('error'))
            <div class="text-red-500 text-sm mt-4 bg-red-100 p-2 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="text-red-500 text-sm mt-4 bg-red-100 p-2 rounded-md">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('check.admin.login') }}" class="mt-6">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
            </div>

            <!-- Mật khẩu -->
            <div class="mt-4">
                <label for="password" class="block text-gray-700 font-medium">Mật khẩu</label>
                <input type="password" id="password" name="password" required
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
            </div>

            <!-- Ghi nhớ đăng nhập -->
            <div class="mt-4 flex items-center">
                <input type="checkbox" id="remember" name="remember" class="text-blue-500" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 text-gray-700 text-sm">Ghi nhớ đăng nhập</label>
            </div>

            <!-- Nút đăng nhập -->
            <button type="submit"
                class="w-full mt-6 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
                Đăng nhập
            </button>

            <!-- Quên mật khẩu -->
            <p class="mt-4 text-center text-gray-600 text-sm">
                <a href="#" class="text-blue-500 hover:underline">Quên mật khẩu?</a>
            </p>
        </form>
    </div>

</body>
</html>
