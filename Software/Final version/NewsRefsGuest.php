<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';  // Database connection
require_once 'function.php';     // Function file
$result = display_NewsRefs();    // Calls on function to fill rows
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Newspaper index</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container {
            flex: 1;
            min-width: 0;
        }
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Newspaper index</h1>
    <!-- Search Row -->
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
            <button type="button" id="clearBtn">Clear fields</button>
            <button type="button" id="searchBtn">Search</button>
        </div>
    </div>
    <!-- Main Content: Table -->
    <div class="main-content">
        <div class="table-container">
            <div class="table-wrapper">
                <table id="dataTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Rank</th>
                        <th>Address</th>
                        <th>Regiment</th>
                        <th>Unit</th>
                        <th>Article Comment</th>
                        <th>Newspaper Name</th>
                        <th>Newspaper Date</th>
                        <th>Page/Col</th>
                        <th>Photo incl</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td class="radio-cell"><input type="radio" name="recordSelect"></td>';
                        echo '<td>' . $row['Surname'] . '</td>';
                        echo '<td>' . $row['Forename'] . '</td>';
                        echo '<td>' . $row['Rank'] . '</td>';
                        echo '<td>' . $row['Address'] . '</td>';
                        echo '<td>' . $row['Regiment'] . '</td>';
                        echo '<td>' . $row['Battalion'] . '</td>';
                        echo '<td>' . $row['ArticleComment'] . '</td>';
                        echo '<td>' . $row['NewspaperName'] . '</td>';
                        echo '<td>' . $row['NewspaperDate'] . '</td>';
                        echo '<td>' . $row['PageCol'] . '</td>';
                        echo '<td>' . $row['PhotoIncl'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bottom Section: Pagination and Back Button -->
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
    // Clear and Search functionality
    document.getElementById('clearBtn').addEventListener('click', () => {
        document.getElementById('forename').value = '';
        document.getElementById('surname').value = '';
    });
    document.getElementById('searchBtn').addEventListener('click', () => {
        alert('Search functionality not implemented.');
    });

    // Pagination: Display 6 rows per page.
    let currentPage = 1, rowsPerPage = 6;
    const tableBody = document.querySelector('#dataTable tbody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
        document.getElementById('resultsCount').textContent = totalRows;
    }
    prevBtn.addEventListener('click', () => {
        if(currentPage > 1){
            currentPage--;
            updateTablePagination();
        }
    });
    nextBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if(currentPage < totalPages){
            currentPage++;
            updateTablePagination();
        }
    });
    updateTablePagination();

    // Process query parameters and add a new record if present.
    function getQueryParams() {
        const params = {};
        window.location.search.substring(1).split("&").forEach(pair => {
            const [key, value] = pair.split("=");
            if (key) params[decodeURIComponent(key)] = decodeURIComponent(value || '');
        });
        return params;
    }
    window.addEventListener("DOMContentLoaded", () => {
        const params = getQueryParams();
        if (params.newRecord === "1") {
            const newRow = document.createElement('tr');
            const radioCell = document.createElement('td');
            radioCell.innerHTML = '<input type="radio" name="recordSelect">';
            newRow.appendChild(radioCell);
            const fields = ["surname", "forename", "rank", "address", "regiment", "unit", "articleComment", "newspaperName", "newspaperDate", "pageCol", "photoIncl"];
            fields.forEach(field => {
                const cell = document.createElement('td');
                cell.textContent = params[field] || "";
                newRow.appendChild(cell);
            });
            tableBody.appendChild(newRow);
            window.history.replaceState({}, document.title, window.location.pathname);
            updateTablePagination();
        }
    });
</script>
</body>
</html>
