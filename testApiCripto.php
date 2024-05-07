<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Cripto Indodax</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-16 py-8">
        <h1 class="text-2xl font-bold mb-4 text-gray-600">Data Cripto Indodax</h1>
        <!-- Search bar -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search by symbol...">
        </div>
        <!-- Table for displaying data -->
        <div class="bg-white shadow-md rounded my-6">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-blue-800 text-gray-100 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Symbol</th>
                        <th class="py-3 px-6 text-left">Base Currency</th>
                        <th class="py-3 px-6 text-left">Trade Min Base Currency</th>
                        <th class="py-3 px-6 text-left">Trade Min Traded Currency</th>
                        <th class="py-3 px-6 text-left">Is Maintenance</th>
                        <th class="py-3 px-6 text-left">Is Market Suspended</th>
                        <th class="py-3 px-6 text-left">URL Logo</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light" id="nilaiTableBody">
                    <!-- Data will be fetched and displayed here -->
                    <?php
                        // Fetch data from API
                        $pairs_json = file_get_contents('https://indodax.com/api/pairs');
                        $pairs_data = json_decode($pairs_json);

                        // Check if data is successfully fetched
                        if ($pairs_data) {
                            foreach ($pairs_data as $pair) {
                                echo '<tr>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . $pair->id . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . $pair->symbol . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . $pair->base_currency . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . number_format($pair->trade_min_base_currency, 2) . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . number_format($pair->trade_min_traded_currency, 10) . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . ($pair->is_maintenance ? 'Ya' : 'Tidak') . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">' . ($pair->is_market_suspended ? 'Ya' : 'Tidak') . '</td>';
                                echo '<td class="py-3 px-6 border border-gray-300">';
                                echo '<img src="' . $pair->url_logo . '" alt="' . $pair->symbol . ' Logo" class="h-8 w-8">';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            // Display error message if unable to fetch data
                            echo '<tr>';
                            echo '<td colspan="8" class="py-3 px-6 border border-gray-300 text-red-500">Failed to fetch data from the API.</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Function to handle search
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("nilaiTableBody");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Index 1 corresponds to the Symbol column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Add event listener to search input
        document.getElementById("searchInput").addEventListener("keyup", search);
    </script>
</body>
</html>
