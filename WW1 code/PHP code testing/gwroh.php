<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'config/DBconnect.php';  // Database connection
require_once 'config/function.php'; // Function file
$result = display_gwroh(); // Calls on function to fill rows
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
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Address</th>
                        <th>Electoral Ward</th>
                        <th>Town</th>
                        <th>Rank</th>
                        <th>Regiment</th>
                        <th>Unit</th>
                        <th>Company</th>
                        <th>Age</th>
                        <th>Service No.</th>
                        <th>Other Regiment</th>
                        <th>Other Unit</th>
                        <th>Other Service No.</th>
                        <th>Medals</th>
                        <th>Enlistment date</th>
                        <th>Discharge date</th>
                        <th>Death (in service) date</th>
                        <th>Misc Info Nroh</th>
                        <th>Cemetery/Memorial</th>
                        <th>Cemetery/Memorial Ref</th>
                        <th>Cemetery/Memorial Country</th>
                        <th>Additional CWGC info</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="radio" name="recordSelect"></td>
                            <td><?php echo $row['Surname']; ?></td>
                            <td><?php echo $row['Forename']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['Electoral Ward']; ?></td>
                            <td><?php echo $row['Town']; ?></td>
                            <td><?php echo $row['Rank']; ?></td>
                            <td><?php echo $row['Regiment']; ?></td>
                            <td><?php echo $row['Battalion']; ?></td>
                            <td><?php echo $row['Company']; ?></td>
                            <td><?php echo $row['DoB']; ?></td>
                            <td><?php echo $row['Service No.']; ?></td>
                            <td><?php echo $row['Other Regiment']; ?></td>
                            <td><?php echo $row['Other Unit']; ?></td>
                            <td><?php echo $row['Other Service No.']; ?></td>
                            <td><?php echo $row['Medals']; ?></td>
                            <td><?php echo $row['Enlistment date']; ?></td>
                            <td><?php echo $row['Discharge date']; ?></td>
                            <td><?php echo $row['Death (in service) date']; ?></td>
                            <td><?php echo $row['Misc Info Nroh']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial Ref']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial Country']; ?></td>
                            <td><?php echo $row['Additional CWGC info']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Side Buttons -->
        <div class="list-container">
            <ul>
                <li>
                    <button type="button" id="addRowBtn" onclick="window.location.href='Add to Database - Bradford and Surrounding Townships.html'">
                        Add Row
                    </button>
                </li>
                <li><button type="button" id="deleteRowBtn">Delete Row</button></li>
                <li><button type="button" id="editRowBtn">Edit Row</button></li>
                <li><button type="button" id="importBtn">Import</button></li>
                <li><button type="button" id="exportBtn">Export</button></li>
            </ul>
        </div>
    </div>
    <!-- Bottom Section -->
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

<script>
    // Side button functionality and pagination
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');

    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;

    // Add Row functionality (for client-side addition)
    const addRowBtn = document.getElementById('addRowBtn');
    addRowBtn.addEventListener('click', () => {
        const newRow = document.createElement('tr');
        const radioCell = document.createElement('td');
        radioCell.innerHTML = '<input type="radio" name="recordSelect">';
        newRow.appendChild(radioCell);
        for (let i = 0; i < columnCount; i++) {
            const cell = document.createElement('td');
            cell.textContent = '';
            newRow.appendChild(cell);
        }
        tableBody.appendChild(newRow);
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        currentPage = totalPages;
        updateTablePagination();
    });

    deleteRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (selectedRadio) {
            const row = selectedRadio.closest('tr');
            if (currentEditingRow === row) {
                currentEditingRow = null;
                editRowBtn.textContent = "Edit Row";
            }
            row.remove();
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

    // PAGINATION CODE – display 6 rows per page.
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
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
        document.getElementById('searchResults').textContent = totalRows;
    }

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; updateTablePagination(); }
    });

    nextPageBtn.addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage < totalPages) { currentPage++; updateTablePagination(); }
    });

    updateTablePagination();

    // Process query parameters from the Add to Database form.
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
            // Use the updated field names from the Add to Database form.
            const fields = ["surname", "forename", "address", "electoralWard", "town", "rank", "regiment", "unit", "company", "age", "serviceNo", "otherRegiment", "otherUnit", "otherServiceNo", "medals", "enlistmentDate", "dischargeDate", "deathDate", "miscInfoNroh", "cemeteryMemorial", "cemeteryMemorialRef", "cemeteryMemorialCountry", "additionalCWGC"];
            fields.forEach(field => {
                const cell = document.createElement('td');
                cell.textContent = params[field] || "";
                newRow.appendChild(cell);
            });
            tableBody.appendChild(newRow);
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
            currentPage = totalPages;
            updateTablePagination();
            // Clear the query string to prevent duplicate additions on refresh.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
</body>
</html>