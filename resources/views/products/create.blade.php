<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-5 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Tambah Menu</h2>

    <form action="/products" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" placeholder="Nama Menu"
            class="border p-2 w-full mb-3">

        <input type="number" name="price" placeholder="Harga"
            class="border p-2 w-full mb-3">

        <input type="file" name="image"
            class="border p-2 w-full mb-3">

        <button class="bg-blue-500 text-white p-2 w-full">
            Simpan
        </button>
    </form>

</div>

</body>
</html>