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
    <!-- Main Content: Table and Side Buttons -->
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
                        <th>Photo incl.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="radio-cell"><input type="radio" name="recordSelect"></td>
                            <td><?php echo $row['Surname']; ?></td>
                            <td><?php echo $row['Forename']; ?></td>
                            <td><?php echo $row['Rank']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['Regiment']; ?></td>
                            <td><?php echo $row['Battalion']; ?></td>
                            <td><?php echo $row['Article Comment']; ?></td>
                            <td><?php echo $row['Newspaper Name']; ?></td>
                            <td><?php echo $row['Newspaper Date']; ?></td>
                            <td><?php echo $row['PageCol']; ?></td>
                            <td><?php echo $row['PhotoIncl']; ?></td>
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
                    <button type="button" id="addRowBtn" onclick="window.location.href='Add-gwroh.php'">
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
    <!-- Bottom Section: Pagination and Back Button -->
    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>
<!-- JavaScript for Search and Clear Fields -->
<script>
    const forenameInput = document.getElementById('forename');
    const surnameInput = document.getElementById('surname');
    const clearBtn = document.getElementById('clearBtn');
    const searchBtn = document.getElementById('searchBtn');
    const tableBody = document.querySelector('#dataTable tbody');

    clearBtn.addEventListener('click', function() {
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
    //const tableBody = document.querySelector('#dataTable tbody');
    const addRowBtn = document.getElementById('addRowBtn');
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    let currentEditingRow = null;
    const columnCount = document.querySelectorAll("#dataTable thead th").length - 1;

    addRowBtn.addEventListener('click', () => {
        window.location.href = 'Update-NewsRefs.php';
    });

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
    const forename = row.cells[2].textContent.trim();
    // Assuming Newspaper Date is in cell index 9 – adjust if needed.
    const newspaperDate = row.cells[9].textContent.trim();
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "DeleteNewsRefs.php", true);
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
                   "&Forename=" + encodeURIComponent(forename) +
                   "&Newspaper_Date=" + encodeURIComponent(newspaperDate);
    xhr.send(params);
    });

    editRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        const row = selectedRadio.closest('tr');
        
        // Get data from the row cells
        const cells = row.cells;
        const surname = cells[1].textContent.trim();
        const forename = cells[2].textContent.trim();
        const rank = cells[3].textContent.trim();
        const address = cells[4].textContent.trim();
        const regiment = cells[5].textContent.trim();
        const unit = cells[6].textContent.trim();
        const article_comment = cells[7].textContent.trim();
        const newspaper_name = cells[8].textContent.trim();
        const newspaper_date = cells[9].textContent.trim();
        const page_column = cells[10].textContent.trim();
        const photo_incl = cells[11].textContent.trim();
        
        // Redirect to the update page with the row data as URL parameters
        window.location.href = `Update-NewsRefs.php?surname=${encodeURIComponent(surname)}&forename=${encodeURIComponent(forename)}&rank=${encodeURIComponent(rank)}&address=${encodeURIComponent(address)}&regiment=${encodeURIComponent(regiment)}&unit=${encodeURIComponent(unit)}&article_comment=${encodeURIComponent(article_comment)}&newspaper_name=${encodeURIComponent(newspaper_name)}&newspaper_date=${encodeURIComponent(newspaper_date)}&page_column=${encodeURIComponent(page_column)}&photo_incl=${encodeURIComponent(photo_incl)}`;
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

    document.getElementById('clearBtn').addEventListener('click', () => {
        document.getElementById('forename').value = '';
        document.getElementById('surname').value = '';
    });

    document.getElementById('searchBtn').addEventListener('click', () => {
        alert('Search functionality not implemented.');
    });

    /*
    document.getElementById('prevBtn').addEventListener('click', () => {
        alert('Previous page not implemented.');
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        alert('Next page not implemented.');
    });
    */

    // Pagination: display 6 rows per page.
    let currentPage = 1;
    const rowsPerPage = 6;
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

    // Process query parameters and add a new row if present.
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
            // Set to last page so the new record is visible.
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const totalPages = Math.ceil(rows.length / rowsPerPage) || 1;
            currentPage = totalPages;
            updateTablePagination();
        }
    });
</script>
</body>
</html>
