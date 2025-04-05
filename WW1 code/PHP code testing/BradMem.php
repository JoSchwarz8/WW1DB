<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';  // Database connection
require_once 'function.php';     // Function file
$result = display_Memorials();   // Calls function to retrieve memorial records
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bradford Memorials</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
            <div class="scrollable-table">
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
        <!-- Side buttons -->
        <div class="list-container">
            <ul>
                <li><button type="button" id="addRowBtn">Add Row</button></li>
                <li><button type="button" id="deleteRowBtn">Delete Row</button></li>
                <li><button type="button" id="editRowBtn">Edit Row</button></li>
                <li><button type="button" id="importBtn">Import</button></li>
                <li><button type="button" id="exportBtn">Export</button></li>
            </ul>
        </div>
    </div>

    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="searchResults">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevPageBtn">&larr;</button>
            <button type="button" id="nextPageBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>

<script>
    // Pagination: display 6 rows per page.
    let currentPage = 1;
    const rowsPerPage = 6;
    const tableBody = document.querySelector('#dataTable tbody');
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

    // Side button functionality remains unchanged.
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;

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
</script>
</body>
</html>
