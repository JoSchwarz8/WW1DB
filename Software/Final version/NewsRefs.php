<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';
require_once 'function.php';
$result = display_NewsRefs();
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
                        <th>Battalion</th>
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
                            <td><?php echo $row['ArticleComment']; ?></td>
                            <td><?php echo $row['NewspaperName']; ?></td>
                            <td><?php echo $row['NewspaperDate']; ?></td>
                            <td><?php echo $row['PageCol']; ?></td>
                            <td><?php echo $row['PhotoIncl']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
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
        <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>
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

    const addRowBtn = document.getElementById('addRowBtn');
    const deleteRowBtn = document.getElementById('deleteRowBtn');
    const editRowBtn = document.getElementById('editRowBtn');
    const importBtn = document.getElementById('importBtn');
    const exportBtn = document.getElementById('exportBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    addRowBtn.addEventListener('click', () => {
        window.location.href = 'Add to Database - Newspaper Index.php';
    });

    deleteRowBtn.addEventListener('click', () => {
        const selected = document.querySelector('input[name="recordSelect"]:checked');
        if (!selected) return alert("Select a record to delete.");
        if (!confirm("Are you sure you want to delete this record?")) return;
        const row = selected.closest('tr');
        const surname = row.cells[1].textContent;
        const forename = row.cells[2].textContent;
        const newspaperDate = row.cells[9].textContent;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "DeleteNewsRefs.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = () => {
            alert(xhr.responseText);
            if (xhr.responseText.includes("deleted successfully")) {
                row.remove();
                updateTablePagination();
            }
        };
        xhr.send(`Surname=${encodeURIComponent(surname)}&Forename=${encodeURIComponent(forename)}&Newspaper_Date=${encodeURIComponent(newspaperDate)}`);
    });

    editRowBtn.addEventListener('click', () => {
        const selected = document.querySelector('input[name="recordSelect"]:checked');
        if (!selected) return alert("Select a record to edit.");
        const row = selected.closest('tr');
        const cells = row.querySelectorAll('td');
        const params = new URLSearchParams({
            surname: cells[1].textContent,
            forename: cells[2].textContent,
            rank: cells[3].textContent,
            address: cells[4].textContent,
            regiment: cells[5].textContent,
            unit: cells[6].textContent,
            article_comment: cells[7].textContent,
            newspaper_name: cells[8].textContent,
            newspaper_date: cells[9].textContent,
            page_column: cells[10].textContent,
            photo_incl: cells[11].textContent
        });
        window.location.href = `Update-NewsRefs.php?${params.toString()}`;
    });

    importBtn.addEventListener('click', () => {
        alert("Import functionality not yet implemented.");
    });

    exportBtn.addEventListener('click', () => {
        let csv = '';
        const rows = document.querySelectorAll("#dataTable tr");
        rows.forEach(row => {
            const cells = row.querySelectorAll("th, td");
            const rowData = Array.from(cells).map(cell => '"' + cell.textContent.trim().replace(/"/g, '""') + '"').join(',');
            csv += rowData + "\n";
        });
        const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", "newspaper_index.csv");
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

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
</script>
</body>
</html>
