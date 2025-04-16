<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';
require_once 'function.php';
$result = display_gwroh();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GWROH - Bradford and Surrounding Townships</title>
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
    <h1>GWROH - Bradford and Surrounding Townships</h1>
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
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
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

    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');

    deleteRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to delete.');
            return;
        }
        const row = selectedRadio.closest('tr');
        const surname = row.cells[1].textContent.trim();
        const serviceNo = row.cells[4].textContent.trim();

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Delete-gwroh.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            alert(xhr.responseText);
            if (xhr.status === 200 && xhr.responseText.includes("successfully")) {
                row.remove();
                updateTablePagination();
            }
        };
        const params = `Surname=${encodeURIComponent(surname)}&ServiceNo=${encodeURIComponent(serviceNo)}`;
        xhr.send(params);
    });

    editRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        const row = selectedRadio.closest('tr');
        const surname = row.cells[1].textContent.trim();
        const forename = row.cells[2].textContent.trim();
        const regiment = row.cells[3].textContent.trim();
        const serviceNo = row.cells[4].textContent.trim();

        const params = new URLSearchParams();
        params.set('surname', surname);
        params.set('forename', forename);
        params.set('regiment', regiment);
        params.set('service_no', serviceNo);

        window.location.href = `Update-gwroh.php?${params.toString()}`;
    });

    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    let currentPage = 1;
    const rowsPerPage = 6;

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });
        document.getElementById('searchResults').textContent = totalRows;
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
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
</script>
</body>
</html>