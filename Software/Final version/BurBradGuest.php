<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result = display_Burials(); // Calls on function to fill rows
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Those buried in Bradford</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container {
            flex: 1;
            min-width: 0;
        }
        .scrollable-table {
            overflow-x: auto;
        }
        /* (Optional) If you want to use additional styling from BurBradGuest.html for pagination: */
        .nav-buttons button {
            padding: 5px 10px;
            font-size: 1rem;
        }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Those buried in Bradford</h1>
    <div class="search-row">
        <div class="input-group">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" placeholder="Enter forename">
        </div>
        <div class="input-group">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" placeholder="Enter surname">
        </div>
        <div class="input-group">
            <label for="cemetery">Cemetery:</label>
            <input type="text" id="cemetery" placeholder="Enter cemetery">
        </div>
        <div class="search-buttons">
            <button type="button" id="clearBtn">Clear fields</button>
            <button type="button" id="searchBtn">Search</button>
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
                        <th>Age</th>
                        <th>Medals</th>
                        <th>Date of Death</th>
                        <th>Rank</th>
                        <th>Service Number</th>
                        <th>Regiment</th>
                        <th>Unit</th>
                        <th>Cemetery</th>
                        <th>Grave Reference</th>
                        <th>Info</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="radio-cell"><input type="radio" name="recordSelect"></td>
                            <td><?php echo $row['Surname']; ?></td>
                            <td><?php echo $row['Forename']; ?></td>
                            <td><?php echo $row['DoB']; ?></td>
                            <td><?php echo $row['Medals']; ?></td>
                            <td><?php echo $row['Date_of_Death']; ?></td>
                            <td><?php echo $row['Rank']; ?></td>
                            <td><?php echo $row['Service_Number']; ?></td>
                            <td><?php echo $row['Regiment']; ?></td>
                            <td><?php echo $row['Battalion']; ?></td>
                            <td><?php echo $row['Cemetery']; ?></td>
                            <td><?php echo $row['Grave_Reference']; ?></td>
                            <td><?php echo $row['Info']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bottom section with pagination -->
    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboardGuest.html">Back</a>
    </div>
</div>
<script>
    // Clear and search button functionality
    document.getElementById('clearBtn').addEventListener('click', () => {
        document.getElementById('forename').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('cemetery').value = '';
    });
    document.getElementById('searchBtn').addEventListener('click', () => {
        alert('Search functionality not implemented.');
    });

    // Pagination code (6 rows per page)
    let currentPage = 1;
    const rowsPerPage = 6;
    const tableBody = document.querySelector('#dataTable tbody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if(currentPage > totalPages) { currentPage = totalPages; }
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevBtn.disabled = (currentPage === 1);
        nextBtn.disabled = (currentPage === totalPages);
        document.getElementById('resultsCount').textContent = totalRows;
    }

    prevBtn.addEventListener('click', () => {
        if(currentPage > 1) { currentPage--; updateTablePagination(); }
    });
    nextBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if(currentPage < totalPages) { currentPage++; updateTablePagination(); }
    });
    updateTablePagination();
</script>
</body>
</html>
