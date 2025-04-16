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
                <li><button type="button" id="addRowBtn" onclick="window.location.href='Add to Database - Bradford Memorials.php'">Add Row</button></li>
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

<script>
    // Pagination: display 6 rows per page.
 // Get references to the search inputs and buttons
 const forenameInput = document.getElementById('forename');
    const surnameInput = document.getElementById('surname');
    const clearFieldsBtn = document.getElementById('clearFieldsBtn');
    const searchBtn = document.getElementById('searchBtn');
    // Reference to the table body
    const tableBody = document.querySelector('#dataTable tbody');

</script>


    <script>
    // Side button functionality remains unchanged.
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;
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
        document.getElementById('prevPageBtn').disabled = currentPage === 1;
        document.getElementById('nextPageBtn').disabled = currentPage === totalPages;
    }

    deleteRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
    if (!selectedRadio) {
        alert('Please select a row to delete.');
        return;
    }
    
    if (!confirm("Are you sure you want to delete the selected record?")) {
        return;
    }
    
    const row = selectedRadio.closest('tr');
    // Extract the identifying fields.
    const surname = row.cells[1].textContent.trim();
    const memorial = row.cells[5].textContent.trim();
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "DeleteMemorials.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            if (xhr.responseText.indexOf("deleted successfully") !== -1) {
                row.remove();
                // Optionally, update pagination.
            }
        } else {
            alert("Error deleting record. Server returned status " + xhr.status);
        }
    };
    
    const params = "Surname=" + encodeURIComponent(surname) +
                   "&Memorial=" + encodeURIComponent(memorial);
    xhr.send(params);
    });

    editRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        
        const row = selectedRadio.closest('tr');
        const cells = row.querySelectorAll('td');
        
        // Get values from the selected row
        const surname = cells[1].textContent.trim();
        const forename = cells[2].textContent.trim();
        const regiment = cells[3].textContent.trim();
        const unit = cells[4].textContent.trim();
        const memorial = cells[5].textContent.trim();
        const memorial_location = cells[6].textContent.trim();
        const memorial_info = cells[7].textContent.trim();
        const memorial_postcode = cells[8].textContent.trim();
        const district = cells[9].textContent.trim();
        const photo_available = cells[10].textContent.trim();
        
        // Log the values for debugging
        console.log("Selected row values:", {
            surname, forename, regiment, unit, memorial, 
            memorial_location, memorial_info, memorial_postcode,
            district, photo_available
        });
        
        // Build the URL with parameters
        const params = new URLSearchParams();
        params.set('surname', surname);
        params.set('forename', forename);
        params.set('regiment', regiment);
        params.set('unit', unit);
        params.set('memorial', memorial);
        params.set('memorial_location', memorial_location);
        params.set('memorial_info', memorial_info);
        params.set('memorial_postcode', memorial_postcode);
        params.set('district', district);
        params.set('photo_available', photo_available);
        
        // Redirect to the Update-Memorials.php page in the edit folder
        window.location.href = 'Update-Memorials.php?' + params.toString();
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

    document.getElementById('prevPageBtn').addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; updateTablePagination(); }
    });

    document.getElementById('nextPageBtn').addEventListener('click', () => {
        const totalRows = tableBody.getElementsByTagName('tr').length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage < totalPages) { currentPage++; updateTablePagination(); }
    });

    updateTablePagination();

    // Process query parameters and add new row if present.
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
            // Updated fields array to match the Add to Database form
            const fields = ["surname", "forename", "regiment", "unit", "memorial", "memorialLocation", "memorialInfo", "memorialPostcode", "district", "photoAvailable"];
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
