<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'DBconnect.php';  // Database connection
require_once 'function.php';     // Function file
$result = display_Memorials();   // Calls function to fill rows
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bradford Memorials</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styling similar to BradMemGuest.html */
        .table-container {
            flex: 1;
            min-width: 0;
        }
        .scrollable-table {
            overflow-x: auto;
        }
        /* You can add more guest-specific styles if needed */
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Bradford Memorials</h1>

    <div class="search-row">
        <div class="input-group">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" placeholder="Enter forename">
        </div>
        <div class="input-group">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" placeholder="Enter surname">
        </div>
        <div class="search-buttons">
            <button type="button">Clear fields</button>
            <button type="button">Search</button>
        </div>
    </div>

    <div class="main-content">
        <div class="table-container">
            <div class="table-wrapper">
                <table id="dataTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Regiment</th>
                        <th>Unit</th>
                        <th>Memorial</th>
                        <th>Memorial location</th>
                        <th>Memorial info</th>
                        <th>Memorial Postcode</th>
                        <th>District</th>
                        <th>Photo available</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="radio" name="recordSelect"></td>
                            <td><?php echo $row['Surname']; ?></td>
                            <td><?php echo $row['Forename']; ?></td>
                            <td><?php echo $row['Regiment']; ?></td>
                            <td><?php echo $row['Battalion']; ?></td>
                            <td><?php echo $row['Memorial']; ?></td>
                            <td><?php echo $row['MemorialLocation']; ?></td>
                            <td><?php echo $row['MemorialInfo']; ?></td>
                            <td><?php echo $row['MemorialPostcode']; ?></td>
                            <td><?php echo $row['District']; ?></td>
                            <td><?php echo $row['PhotoAvailable']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bottom-section">
        <div class="search-results">
            No of search results: <span id="resultsCount">0</span>
        </div>
        <div class="nav-buttons">
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboardGuest.html">Back</a>
    </div>
</div>

<script>
    // Pagination functionality
    let currentPage = 1;
    const rowsPerPage = 6;
    const tableBody = document.querySelector('#dataTable tbody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) { currentPage = totalPages; }
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
        document.getElementById('resultsCount').textContent = totalRows;
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; updateTablePagination(); }
    });

    nextBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage < totalPages) { currentPage++; updateTablePagination(); }
    });

    updateTablePagination();
</script>
</body>
</html>
