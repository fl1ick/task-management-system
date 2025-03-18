<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RencanaKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow-md py-4 px-6 flex justify-between items-center z-50">
        <a href="#" class="text-xl font-bold text-gray-800">RencanaKu</a>
        <ul class="hidden md:flex space-x-6 text-gray-700">
            <li><a href="#about" class="hover:text-gray-900">About</a></li>
            <li><a href="#contact" class="hover:text-gray-900">Contact</a></li>
            <li><a href="#board" class="hover:text-gray-900">Board</a></li>
            @auth
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-500">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="hover:text-gray-900">Login</a></li>
            @endauth
        </ul>
    </nav>
    
    <!-- Hero Section -->
    <header class="relative h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative text-center text-white px-6">
            <h1 class="text-5xl font-bold">RencanaKu</h1>
            <p class="mt-4 text-lg max-w-xl mx-auto">Platform yang membantu Anda mengatur rencana dan tugas dengan mudah dan efisien.</p>
            <a href="#board" class="mt-6 inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition">Buat Board</a>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 md:flex md:items-center">
            <!-- Text Content -->
            <div class="md:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800">Tentang RencanaKu</h2>
                <p class="mt-4 text-gray-600">
                    RencanaKu adalah platform manajemen tugas yang membantu Anda mengorganisir pekerjaan dengan efisien.
                    Dengan fitur board interaktif, Anda bisa mengelola tugas dengan lebih mudah dan terstruktur.
                </p>
                <p class="mt-4 text-gray-600">
                    Kami percaya bahwa perencanaan yang baik adalah kunci produktivitas. Gunakan RencanaKu untuk meningkatkan efektivitas kerja Anda.
                </p>
            </div>
            <!-- Image -->
            <div class="md:w-1/2 mt-8 md:mt-0 md:ml-12">
                <img src="https://plus.unsplash.com/premium_photo-1706191097326-cd317671d1fb?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cGxhbm5pbmd8ZW58MHx8MHx8fDA%3D" alt="Planning Image" class="rounded-lg shadow-md">
            </div>
        </div>
    </section>

    <!-- Board Section -->
    <section id="board" class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Buat Board</h2>
            
            <!-- Form Buat Board -->
            <form action="{{ route('boards.store') }}" method="POST" class="mb-6 bg-white p-6 rounded-lg shadow-md">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Board</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                </div>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition">
                    Buat Board
                </button>
            </form>

            <!-- Daftar Board -->
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Daftar Board</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($boards as $board)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-800">{{ $board->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $board->description }}</p>
                        <a href="{{ route('tasks.index', $board->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">
                            Lihat Task
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Authentication Routes -->
    <section id="auth" class="hidden">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="text-blue-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-blue-500">Login</a>
            @endauth
        @endif
    </section>
</body>
    <!-- Footer -->
    <footer class="bg-white shadow-md py-4 text-center mt-10">
        <p class="text-gray-700 text-sm">&copy; 2025 RencanaKu. All rights reserved.</p>
        <p class="text-gray-500 text-xs mt-1">Dibuat dengan ❤️ oleh Bagas Maulana</p>
    </footer>
</html>
