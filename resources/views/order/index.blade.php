<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menu Angkringan - Pesan Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 pb-24">

   <div class="bg-orange-500 text-white p-6 shadow-md rounded-b-3xl text-center">
    <h1 class="text-2xl font-bold tracking-wide">Angkringan Modern</h1>
    <p class="opacity-90">Pesan Menu Favoritmu Lewat HP</p>
</div>

<div class="p-4">
    <label class="block text-gray-700 font-bold mb-2">Nomor Meja Anda:</label>
    <input type="number" id="input-meja" 
           class="w-full p-4 rounded-xl border-2 border-orange-200 focus:border-orange-500 outline-none text-xl font-bold text-center" 
           placeholder="Contoh: 05">
</div>

<script>
    function submitOrder() {
        const noMeja = document.getElementById('input-meja').value;
        let orderItems = [];
        let totalAll = 0;

        // Validasi Nomor Meja
        if(!noMeja) return alert('Ups! Tolong isi nomor meja Anda dulu ya.');

        inputs.forEach(i => {
            if(i.value > 0) {
                orderItems.push({
                    product_id: i.dataset.id,
                    quantity: i.value
                });
                totalAll += i.value * i.dataset.price;
            }
        });

        if(orderItems.length === 0) return alert('Pilih menu dulu dong!');

        fetch('{{ route("order.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                table_number: noMeja, // Mengambil dari input manual
                total_price: totalAll,
                items: orderItems
            })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            location.reload();
        });
    }
</script>
</body>
</html>