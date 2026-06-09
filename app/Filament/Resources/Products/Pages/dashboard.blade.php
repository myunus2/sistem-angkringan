<x-filament::page>

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">
            Halo, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-gray-500">Selamat datang di sistem absensi</p>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow border-l-4 border-primary-500">
            <h2 class="text-gray-500">Total User</h2>
            <p class="text-3xl font-bold text-primary-600">
                {{ \App\Models\User::count() }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow border-l-4 border-green-500">
            <h2 class="text-gray-500">Total Absen</h2>
            <p class="text-3xl font-bold text-green-600">
                {{ \App\Models\Absen::count() ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow border-l-4 border-blue-500">
            <h2 class="text-gray-500">Absen Hari Ini</h2>
            <p class="text-3xl font-bold text-blue-600">
                {{ \App\Models\Absen::whereDate('created_at', today())->count() ?? 0 }}
            </p>
        </div>

    </div>

    <!-- MENU CEPAT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

        <a href="/admin/absens" class="bg-primary-500 text-white p-6 rounded-2xl shadow hover:scale-105 transition">
            📸 Input Absen
        </a>

        <a href="/admin/users" class="bg-green-500 text-white p-6 rounded-2xl shadow hover:scale-105 transition">
            👤 Data User
        </a>

    </div>

    <!-- DATA TERBARU -->
    <div class="mt-10 bg-white p-6 rounded-2xl shadow">
        <h2 class="text-lg font-bold mb-4">Data Absen Terbaru</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-2">Nama</th>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Absen::latest()->limit(5)->get() as $absen)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $absen->nama }}</td>
                    <td class="p-2">{{ $absen->tanggal }}</td>
                    <td class="p-2">{{ $absen->waktu }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-filament::page>