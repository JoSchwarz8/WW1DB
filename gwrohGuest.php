<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'DBconnect.php';  // Database connection
require_once 'function.php';   // Function file
$result = display_gwroh();     // Calls on function to fill rows
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Bradford and surrounding townships</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container {
            flex: 1;
            min-width: 0;
        }
        /* Use a wrapper class as in the guest version to enable horizontal scrolling */
        .table-wrapper {
            overflow-x: auto;
        }
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
                            <td class="radio-cell"><input type="radio" name="recordSelect"></td>
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
                            <td><?php echo $row['Service no']; ?></td>
                            <td><?php echo $row['Other Regiment']; ?></td>
                            <td><?php echo $row['Other Unit']; ?></td>
                            <td><?php echo $row['Other Service no']; ?></td>
                            <td><?php echo $row['Medals']; ?></td>
                            <td><?php echo $row['Enlistment Date']; ?></td>
                            <td><?php echo $row['Discharge Date']; ?></td>
                            <td><?php echo $row['Death (in service) Date']; ?></td>
                            <td><?php echo $row['Misc info (Nroh)']; ?></td>
                            <td><?php echo $row['Misc info (cwgc)']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial Ref']; ?></td>
                            <td><?php echo $row['Cemetery/Memorial Country']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bottom Section: Pagination and Back Button -->
    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
        <div class="nav-buttons">
            <button type="button" id="prevBtn">&larr;</button>
            <button type="button" id="nextBtn">&rarr;</button>
        </div>
        <a class="back-button" href="dashboardGuest.html">Back</a>
    </div>
</div>
<script>
    // Clear and Search button functionality
    document.getElementById('clearBtn').addEventListener('click', () => {
        document.getElementById('forename').value = '';
        document.getElementById('surname').value = '';
    });
    document.getElementById('searchBtn').addEventListener('click', () => {
        alert('Search functionality not implemented.');
    });

    // PAGINATION CODE – display 6 rows per page.
    let currentPage = 1;
    const rowsPerPage = 6;
    const tableBody = document.querySelector('#dataTable tbody');
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

    // Process query parameters and add new record if present.
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
            // Expected fields in order.
            const fields = ["surname", "forename", "address", "electoralWard", "town", "rank", "regiment", "unit", "company", "age", "serviceNo", "otherRegiment", "otherUnit", "otherServiceNo", "medals", "enlistmentDate", "dischargeDate", "deathDate", "miscInfoNroh", "cemeteryMemorial", "cemeteryMemorialRef", "cemeteryMemorialCountry", "additionalCWGC"];
            fields.forEach(field => {
                const cell = document.createElement('td');
                cell.textContent = params[field] || "";
                newRow.appendChild(cell);
            });
            tableBody.appendChild(newRow);
            // Clear the query string so the record isn't added again on refresh.
            window.history.replaceState({}, document.title, window.location.pathname);
            // Update pagination and show the new record on the last page.
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const totalPages = Math.ceil(rows.length / rowsPerPage) || 1;
            currentPage = totalPages;
            updateTablePagination();
        }
    });
</script>
</body>
</html>
