<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
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
        /* Using styles from BurBrad.html */
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
            <button type="button" id="clearFieldsBtn">Clear Fields</button>
            <button type="button" id="searchBtn">Search</button>
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
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><input type="radio" name="recordSelect"></td>
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
        <!-- Side buttons remain (Add/Delete/Edit/Import/Export) -->
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
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>
<script>
    // Clear and search functionality
    document.getElementById('clearFieldsBtn').addEventListener('click', () => {
        document.getElementById('forename').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('cemetery').value = '';
    });
    document.getElementById('searchBtn').addEventListener('click', () => {
        alert('Search functionality not implemented.');
    });

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
        if (currentPage > totalPages) currentPage = totalPages;
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
        document.getElementById('searchResults').textContent = totalRows;
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

    // Optionally, add side button functionality (Delete, Edit, Import, Export) if needed.
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;

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
