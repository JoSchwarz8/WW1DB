<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result = display_Bios(); // Calls function to retrieve the rows
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biographies</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing styles */
        .table-container {
            flex: 1;
            min-width: 0;
        }
        .scrollable-table {
            overflow-x: auto;
        }
        .list-container {
            width: 220px;
        }
        .list-container ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .list-container li {
            margin-bottom: 15px;
        }
        .list-container button {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
        }
        .nav-buttons button {
            padding: 5px 10px;
            font-size: 1rem;
        }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Biographies</h1>

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
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Regiment</th>
                        <th>Service No</th>
                        <th>Biography attachment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="radio" name="recordSelect"></td>
                            <td><?php echo $row['Surname']; ?></td>
                            <td><?php echo $row['Forename']; ?></td>
                            <td><?php echo $row['Regiment']; ?></td>
                            <td><?php echo $row['Service no']; ?></td>
                            <td><?php echo $row['Biography']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Side buttons; note the Add Row button now redirects to the form page -->
        <div class="list-container">
            <ul>
                <li><button type="button" id="addRowBtn" onclick="window.location.href='Add to Database - Biographies.html'">Add Row</button></li>
                <li><button type="button" id="deleteRowBtn">Delete Row</button></li>
                <li><button type="button" id="editRowBtn">Edit Row</button></li>
                <li><button type="button" id="importBtn">Import</button></li>
                <li><button type="button" id="exportBtn">Export</button></li>
            </ul>
        </div>
    </div>

    <!-- Bottom Section: Pagination and Back Button -->
    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="searchResults">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevPageBtn">&larr;</button>
            <button type="button" id="nextPageBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>

<!-- JavaScript for Search and Clear Fields -->
<script>
    // Get references to the search inputs and buttons
    const forenameInput = document.getElementById('forename');
    const surnameInput = document.getElementById('surname');
    const clearFieldsBtn = document.getElementById('clearFieldsBtn');
    const searchBtn = document.getElementById('searchBtn');
    // Reference to the table body
    const tableBody = document.querySelector('#dataTable tbody');

    // Clear Fields: Empties search inputs and shows all rows without reloading the page
    clearFieldsBtn.addEventListener('click', function() {
        forenameInput.value = "";
        surnameInput.value = "";
        const rows = tableBody.getElementsByTagName('tr');
        for (let row of rows) {
            row.style.display = "";
        }
        document.getElementById('searchResults').textContent = rows.length;
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
        document.getElementById('searchResults').textContent = visibleCount;
    });
</script>

<!-- Existing functionality for Delete, Edit, Import, Export, and Pagination -->
<script>
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;
    let currentPage = 1;
    const rowsPerPage = 6;

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) { currentPage = totalPages; }
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
        document.getElementById('searchResults').textContent = totalRows;
    }

    deleteRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (selectedRadio) {
            const row = selectedRadio.closest('tr');
            if (currentEditingRow === row) {
                currentEditingRow = null;
                editRowBtn.textContent = "Edit Row";
            }
            row.remove();
            const totalRows = tableBody.getElementsByTagName('tr').length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
            if ((currentPage - 1) * rowsPerPage >= totalRows) { currentPage = totalPages; }
            updateTablePagination();
        } else {
            alert('Please select a row to delete.');
        }
    });

    editRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        const row = selectedRadio.closest('tr');
        if (currentEditingRow === row) {
            Array.from(row.cells).forEach((cell, index) => {
                if (index > 0) {
                    cell.contentEditable = false;
                    cell.style.backgroundColor = "";
                }
            });
            editRowBtn.textContent = "Edit Row";
            currentEditingRow = null;
        } else {
            if (currentEditingRow) {
                Array.from(currentEditingRow.cells).forEach((cell, index) => {
                    if (index > 0) {
                        cell.contentEditable = false;
                        cell.style.backgroundColor = "";
                    }
                });
            }
            Array.from(row.cells).forEach((cell, index) => {
                if (index > 0) {
                    cell.contentEditable = true;
                    cell.style.backgroundColor = "#ffffe0";
                }
            });
            editRowBtn.textContent = "Save Row";
            currentEditingRow = row;
        }
    });

    importBtn.addEventListener('click', () => {
        alert('Import functionality not implemented.');
    });

    exportBtn.addEventListener('click', () => {
        let csvContent = "";
        const rows = document.querySelectorAll("#dataTable tr");
        rows.forEach((row) => {
            const cells = row.querySelectorAll("th, td");
            let rowData = [];
            cells.forEach((cell) => {
                rowData.push(cell.textContent.trim());
            });
            csvContent += rowData.join(",") + "\n";
        });
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", "table_data.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updateTablePagination();
        }
    });

    nextPageBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage < totalPages) {
            currentPage++;
            updateTablePagination();
        }
    });

    updateTablePagination();

    // Process query parameters from the Add to Database form
    function getQueryParams() {
        const params = {};
        window.location.search.substring(1).split("&").forEach(pair => {
            const [key, value] = pair.split("=");
            if (key) params[decodeURIComponent(key)] = decodeURIComponent(value || "");
        });
        return params;
    }

    window.addEventListener("DOMContentLoaded", () => {
        const params = getQueryParams();
        if (params.newRecord === "1") {
            const newRow = document.createElement("tr");
            const radioCell = document.createElement("td");
            radioCell.innerHTML = '<input type="radio" name="recordSelect">';
            newRow.appendChild(radioCell);
            const fields = ["surname", "forename", "regiment", "serviceNo", "bioAttachment"];
            fields.forEach(field => {
                const cell = document.createElement("td");
                cell.textContent = params[field] || "";
                newRow.appendChild(cell);
            });
            tableBody.appendChild(newRow);
            // Clear the query string so the record is not added again on refresh
            window.history.replaceState({}, document.title, window.location.pathname);
            updateTablePagination();
        }
    });
</script>
</body>
</html>