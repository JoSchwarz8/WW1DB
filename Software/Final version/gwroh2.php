<?php
// gwroh.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'DBconnect.php';
require_once 'function.php';

// Check if this is an AJAX request for a batch of rows.
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;

    $result = display_gwroh($offset, $limit);
    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($rows);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bradford and surrounding townships</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container { flex: 1; min-width: 0; }
        .scrollable-table { overflow-x: auto; }
        .list-container { width: 220px; }
        .list-container ul { list-style: none; padding: 0; margin: 0; }
        .list-container li { margin-bottom: 15px; }
        .list-container button { width: 100%; padding: 10px; font-size: 1rem; }
        .nav-buttons button { padding: 5px 10px; font-size: 1rem; }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Bradford and surrounding townships</h1>
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
            <button type="button" id="clearFieldsBtn">Clear fields</button>
            <button type="button" id="searchBtn">Search</button>
        </div>
    </div>
    <!-- Main Content: Table and Side Buttons -->
    <div class="main-content">
        <div class="table-container">
            <div class="scrollable-table">
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <!-- Adjust column headers as necessary -->
                            <th>Surname</th>
                            <th>Forename</th>
                            <th>Address</th>
                            <th>Electoral Ward</th>
                            <th>Town</th>
                            <th>Rank</th>
                            <th>Regiment</th>
                            <th>Battalion</th>
                            <th>Company</th>
                            <th>DoB</th>
                            <th>Service no</th>
                            <th>Other Regiment</th>
                            <th>Other Unit</th>
                            <th>Other Service no</th>
                            <th>Medals</th>
                            <th>Enlistment Date</th>
                            <th>Discharge Date</th>
                            <th>Death (in service) Date</th>
                            <th>Misc info (Nroh)</th>
                            <th>Cemetery/Memorial</th>
                            <th>Cemetery/Memorial Ref</th>
                            <th>Cemetery/Memorial Country</th>
                            <th>Misc info (cwgc)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Initially empty; rows will be appended by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Side Buttons (if needed) -->
        <div class="list-container">
            <ul>
                <li><button type="button" id="addRowBtn" onclick="window.location.href='Add-gwroh.php'">Add Row</button></li>
                <li><button type="button" id="deleteRowBtn">Delete Row</button></li>
                <li><button type="button" id="editRowBtn">Edit Row</button></li>
                <li><button type="button" id="importBtn">Import</button></li>
                <li><button type="button" id="exportBtn">Export</button></li>
            </ul>
        </div>
    </div>
    <!-- Bottom Section: Pagination and Load More -->
    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevPageBtn">&larr;</button>
            <button type="button" id="nextPageBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
        <!-- Optional: a "Load More" button -->
        <button type="button" id="loadMoreBtn">Load More</button>
    </div>
</div>

<!-- JavaScript for Search and Clear Fields -->
<script>
    const forenameInput = document.getElementById('forename');
    const surnameInput = document.getElementById('surname');
    const clearFieldsBtn = document.getElementById('clearFieldsBtn');
    const searchBtn = document.getElementById('searchBtn');
    const tableBody = document.querySelector('#dataTable tbody');

    clearFieldsBtn.addEventListener('click', function() {
        forenameInput.value = "";
        surnameInput.value = "";
        const rows = tableBody.getElementsByTagName('tr');
        for (let row of rows) {
            row.style.display = "";
        }
        document.getElementById('resultsCount').textContent = rows.length;
    });

    searchBtn.addEventListener('click', function() {
        const forenameSearch = forenameInput.value.trim().toLowerCase();
        const surnameSearch = surnameInput.value.trim().toLowerCase();
        const rows = tableBody.getElementsByTagName('tr');
        let visibleCount = 0;
        for (let row of rows) {
            const surnameCell = row.cells[1].textContent.toLowerCase();
            const forenameCell = row.cells[2].textContent.toLowerCase();
            if ((surnameSearch === "" || surnameCell.includes(surnameSearch)) &&
                (forenameSearch === "" || forenameCell.includes(forenameSearch))) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        }
        document.getElementById('resultsCount').textContent = visibleCount;
    });
</script>

<script>
    // Pagination and Batch Loading
    
    // Variables for manual batch loading
    let offset = 0;
    const batchSize = 100; // Adjust as needed
    let loading = false;
    
    // Function to load a batch of rows via AJAX
    function loadBatch() {
        if (loading) return;
        loading = true;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "gwroh.php?ajax=1&offset=" + offset + "&limit=" + batchSize, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const rows = JSON.parse(xhr.responseText);
                if (rows.length > 0) {
                    rows.forEach(function(row) {
                        const tr = document.createElement("tr");
                        // Insert a radio button cell for selection.
                        const radioCell = document.createElement("td");
                        radioCell.innerHTML = '<input type="radio" name="recordSelect">';
                        tr.appendChild(radioCell);
                        
                        // Define the fields in the correct order.
                        const fields = [
                            'Surname', 'Forename', 'Address', 'Electoral Ward', 'Town',
                            'Rank', 'Regiment', 'Battalion', 'Company', 'DoB', 'Service no',
                            'Other Regiment', 'Other Unit', 'Other Service no', 'Medals',
                            'Enlistment Date', 'Discharge Date', 'Death (in service) Date',
                            'Misc info (Nroh)', 'Cemetery/Memorial', 'Cemetery/Memorial Ref',
                            'Cemetery/Memorial Country', 'Misc info (cwgc)'
                        ];
                        
                        // Create a cell for each field.
                        fields.forEach(function(field) {
                            const td = document.createElement("td");
                            td.textContent = row[field] || "";
                            tr.appendChild(td);
                        });
                        
                        tableBody.appendChild(tr);
                    });
                    
                    offset += batchSize;
                    // Update the results count (total rows loaded so far)
                    document.getElementById('resultsCount').textContent = tableBody.getElementsByTagName('tr').length;
                } else {
                    // No more rows to load
                    document.getElementById('loadMoreBtn').disabled = true;
                    document.getElementById('loadMoreBtn').innerText = "No More Records";
                }
            } else {
                console.error("Error loading batch. Status:", xhr.status);
            }
            loading = false;
        };
        xhr.send();
    }
    
    // Initially load the first batch.
    loadBatch();
    
    // Bind the "Load More" button.
    document.getElementById('loadMoreBtn').addEventListener('click', loadBatch);
    
    // OPTIONAL: Infinite scrolling loading. Uncomment if desired.
    /*
    window.addEventListener("scroll", function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
            loadBatch();
        }
    });
    */
    
    // Pagination Controls for already loaded rows (if you wish to paginate the display among loaded rows):
    let currentPage = 1;
    const rowsPerPage = 6;
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) { currentPage = totalPages; }
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevPageBtn.disabled = (currentPage === 1);
        nextPageBtn.disabled = (currentPage === totalPages);
        document.getElementById('resultsCount').textContent = totalRows;
    }

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; updateTablePagination(); }
    });

    nextPageBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage < totalPages) { currentPage++; updateTablePagination(); }
    });
    
    // Update pagination after each batch load.
    // You can call updateTablePagination() inside loadBatch() after appending rows if necessary.
</script>
</body>
</html>
