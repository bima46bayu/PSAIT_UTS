<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Form for adding new value -->
    <div class="bg-white shadow-md rounded my-6 p-6">
            <h2 class="text-lg font-bold mb-4">Tambah Nilai Baru</h2>
            <form id="addNilaiForm" class="space-y-4">
                <div>
                    <label for="addNIM" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="addNIM" name="addNIM" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan NIM">
                </div>
                <div>
                    <label for="addKodeMK" class="block text-sm font-medium text-gray-700">Kode Mata Kuliah</label>
                    <input type="text" id="addKodeMK" name="addKodeMK" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan Kode Mata Kuliah">
                </div>
                <div>
                    <label for="addNilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                    <input type="text" id="addNilai" name="addNilai" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan Nilai">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Tambah Nilai</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Data Nilai Mahasiswa</h1>
        <!-- Table for displaying data -->
        <div class="bg-white shadow-md rounded my-6">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">NIM</th>
                        <th class="py-3 px-6 text-left">Kode Mata Kuliah</th>
                        <th class="py-3 px-6 text-left">Nama Mata Kuliah</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Nilai</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light" id="nilaiTableBody">
                    <!-- Data will be fetched and displayed here -->
                </tbody>
            </table>
        </div>

        

    <script>
        // Function to fetch and display data
        function fetchData() {
            fetch('http://localhost/sait_uts_api/kuliah_api.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('nilaiTableBody');
                    tableBody.innerHTML = '';
                    data.forEach(nilai => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="py-3 px-6">${nilai.nim}</td>
                            <td class="py-3 px-6">${nilai.kode_mk}</td>
                            <td class="py-3 px-6">${nilai.nama_mk}</td>
                            <td class="py-3 px-6">${nilai.nama}</td>
                            <td class="py-3 px-6">${nilai.nilai}</td>
                            <td class="py-3 px-6">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2" onclick="updateNilai('${nilai.nim}', '${nilai.kode_mk}', '${nilai.nilai}')">Update</button>
                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="deleteNilai('${nilai.nim}', '${nilai.kode_mk}')">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Call fetchData function when page loads
        fetchData();

        // Function to add new value
        document.getElementById('addNilaiForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const nim = document.getElementById('addNIM').value;
            const kode_mk = document.getElementById('addKodeMK').value;
            const nilai = document.getElementById('addNilai').value;

            fetch('http://localhost/sait_uts_api/kuliah_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nim: nim,
                    kode_mk: kode_mk,
                    nilai: nilai
                }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                // fetchData(); // Refresh data after adding new value
                document.getElementById('addNIM').value = '';
                document.getElementById('addKodeMK').value = '';
                document.getElementById('addNilai').value = '';
            })
            .catch((error) => {
                console.error('Error:', error);
                fetchData();
            });
        });

        // Function to update value
        function updateNilai(nim, kode_mk, nilai) {
            const newNilai = prompt('Masukkan nilai baru:', nilai);
            if (newNilai !== null) {
                fetch(`http://localhost/sait_uts_api/kuliah_api.php?nim=${nim}&kode_mk=${kode_mk}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nilai: newNilai
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchData(); // Refresh data after updating value
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        }

        // Function to delete value
        function deleteNilai(nim, kode_mk) {
            const confirmation = confirm('Apakah Anda yakin ingin menghapus nilai ini?');
            if (confirmation) {
                fetch(`http://localhost/sait_uts_api/kuliah_api.php?nim=${nim}&kode_mk=${kode_mk}`, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchData(); // Refresh data after deleting value
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        }
    </script>
</body>
</html>
