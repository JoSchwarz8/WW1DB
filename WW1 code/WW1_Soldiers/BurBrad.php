<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
<!-- JavaScript for Search and Clear Fields -->
<script>
    // Get references to the search inputs and buttons
    const forenameInput = document.getElementById('forename');
    const surnameInput = document.getElementById('surname');
    const cemeteryInput = document.getElementById('cemetery');
    const clearFieldsBtn = document.getElementById('clearFieldsBtn');
    const searchBtn = document.getElementById('searchBtn');
    // Reference to the table body
    const tableBody = document.querySelector('#dataTable tbody');

    // Clear Fields: Empties search inputs and resets table row visibility
    clearFieldsBtn.addEventListener('click', function() {
        forenameInput.value = "";
        surnameInput.value = "";
        cemeteryInput.value = "";
        const rows = tableBody.getElementsByTagName('tr');
        for (let row of rows) {
            row.style.display = "";
        }
        document.getElementById('searchResults').textContent = rows.length;
    });

    // Search functionality: Filters rows based on forename, surname, and cemetery
    searchBtn.addEventListener('click', function() {
        const forenameSearch = forenameInput.value.trim().toLowerCase();
        const surnameSearch = surnameInput.value.trim().toLowerCase();
        const cemeterySearch = cemeteryInput.value.trim().toLowerCase();
        const rows = tableBody.getElementsByTagName('tr');
        let visibleCount = 0;
        for (let row of rows) {
            const surnameCell = row.cells[1].textContent.toLowerCase();
            const forenameCell = row.cells[2].textContent.toLowerCase();
            const cemeteryCell = row.cells[10].textContent.toLowerCase();
            if ((surnameSearch === "" || surnameCell.includes(surnameSearch)) &&
                (forenameSearch === "" || forenameCell.includes(forenameSearch)) &&
                (cemeterySearch === "" || cemeteryCell.includes(cemeterySearch))) {
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
    // Pagination functionality
    let currentPage = 1;
    const rowsPerPage = 6;
    //const tableBody = document.querySelector('#dataTable tbody'); //commented because it was causing the buttons malfunction
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateTablePagination() {
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) {currentPage = totalPages;}
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

    addRowBtn.addEventListener('click', function() {
        window.location.href = 'http://localhost/WW1_Soldiers/Add-Burials.php';
    });
   // ❌ Hook into Delete Row and send surname to delete_burial.php


    deleteRowBtn.addEventListener('click', function() {
        //alert('Delete button clicked');
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
    const service_Number = row.cells[7].textContent.trim();
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "DeleteBurials.php", true);
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
                   "&Service_Number=" + encodeURIComponent(service_Number);
    xhr.send(params);
    });



    editRowBtn.addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        
        const row = selectedRadio.closest('tr');
        
        // Get data from the selected row to pass to Update-Burials.php
        const serviceNumber = row.cells[7].textContent.trim();
        const surname = row.cells[1].textContent.trim();
        const forename = row.cells[2].textContent.trim();
        const dob = row.cells[3].textContent.trim();
        const medals = row.cells[4].textContent.trim();
        const date_of_death = row.cells[5].textContent.trim();
        const rank = row.cells[6].textContent.trim();
        const regiment = row.cells[8].textContent.trim();
        const battalion = row.cells[9].textContent.trim();
        const cemetery = row.cells[10].textContent.trim();
        const grave_reference = row.cells[11].textContent.trim();
        const info = row.cells[12].textContent.trim();
        
        // Navigate to Update-Burials.php with the data as URL parameters
        window.location.href = `Update-Burials.php?service_number=${encodeURIComponent(serviceNumber)}&surname=${encodeURIComponent(surname)}&forename=${encodeURIComponent(forename)}&original_service_number=${encodeURIComponent(serviceNumber)}`;
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

    // Add button to navigate to Update-Burials.php
    document.getElementById('goToUpdateBtn').addEventListener('click', () => {
        const selectedRadio = document.querySelector('input[type="radio"][name="recordSelect"]:checked');
        if (!selectedRadio) {
            alert('Please select a row to edit.');
            return;
        }
        
        const row = selectedRadio.closest('tr');
        
        // Get data from the selected row
        const serviceNumber = row.cells[7].textContent.trim();
        const surname = row.cells[1].textContent.trim();
        const forename = row.cells[2].textContent.trim();
        
        // Create a form to submit the data
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = 'Update-Burials.php';
        
        // Add service number as a parameter
        const serviceField = document.createElement('input');
        serviceField.type = 'hidden';
        serviceField.name = 'service_number';
        serviceField.value = serviceNumber;
        form.appendChild(serviceField);
        
        // Add surname as a parameter
        const surnameField = document.createElement('input');
        surnameField.type = 'hidden';
        surnameField.name = 'surname';
        surnameField.value = surname;
        form.appendChild(surnameField);
        
        // Add forename as a parameter
        const forenameField = document.createElement('input');
        forenameField.type = 'hidden';
        forenameField.name = 'forename';
        forenameField.value = forename;
        form.appendChild(forenameField);
        
        // Append form to body, submit it, and remove it
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });
</script>
</body>
</html>
