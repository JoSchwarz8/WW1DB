<?php
require_once 'DBconnect.php';
require_once 'function.php'; // where add_Bios() is defined

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_NewsRefs();
    echo "Record added successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add to Database - Newspaper Index</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Consistent theme styling */
        .form-section {
            background-color: #999;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-start;
        }
        .form-section .input-group {
            flex: 1 1 200px;
            display: flex;
            flex-direction: column;
        }
        .form-section label {
            color: #9b111e;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        .form-section input[type="text"],
        .form-section input[type="date"] {
            padding: 8px 12px;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
            width: 100%;
            margin-top: 10px;
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        .table-container thead {
            background-color: #9b111e;
            color: #fff;
        }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Add to Database - Newspaper Index</h1>
    <form id="addRecordForm" class="form-section" action="AddNews.php" method="post">
        <!-- Input groups for each field -->
        <div class="input-group">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="Surname" placeholder="Enter surname" required>
        </div>
        <div class="input-group">
            <label for="forename">Forename</label>
            <input type="text" id="forename" name="Forename" placeholder="Enter forename" required>
        </div>
        <div class="input-group">
            <label for="rank">Rank</label>
            <input type="text" id="rank" name="Rank" placeholder="Enter rank">
        </div>
        <div class="input-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="Address" placeholder="Enter address">
        </div>
        <div class="input-group">
            <label for="regiment">Regiment</label>
            <input type="text" id="regiment" name="Regiment" placeholder="Enter regiment">
        </div>
        <div class="input-group">
            <label for="unit">Unit</label>
            <input type="text" id="unit" name="Battalion" placeholder="Enter unit">
        </div>
        <div class="input-group">
            <label for="articleComment">Article Comment</label>
            <input type="text" id="articleComment" name="Article Comment" placeholder="Enter article comment">
        </div>
        <div class="input-group">
            <label for="newspaperName">Newspaper Name</label>
            <input type="text" id="newspaperName" name="Newspaper Name" placeholder="Enter newspaper name">
        </div>
        <div class="input-group">
            <label for="newspaperDate">Newspaper Date</label>
            <input type="date" id="newspaperDate" name="Newspaper Date">
        </div>
        <div class="input-group">
            <label for="pageCol">Page/Col</label>
            <input type="text" id="pageCol" name="PageCol" placeholder="Enter page/column">
        </div>
        <div class="input-group">
            <label for="photoIncl">Photo incl</label>
            <input type="text" id="photoIncl" name="PhotoIncl" placeholder="Enter photo inclusion status">
        </div>
        <div class="form-buttons">
            <button type="submit" id="submitBtn" class="btn btn-primary">Add Record</button>
            <button type="reset" id="clearFormBtn">Clear Fields</button>
        </div>
    </form>

    <div class="table-container">
        <table id="recordsTable">
            <thead>
            <tr>
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
                <th>Photo incl</th>
            </tr>
            </thead>
            <tbody>
            <!-- New rows will be added here if you choose not to redirect -->
            </tbody>
        </table>
    </div>

    <div class="bottom-section" style="margin-top:20px;">
        <a class="back-button" href="dashboard.html">Back</a>
    </div>
</div>
<script>
    document.getElementById('addRecordForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const recordValues = {
            surname: document.getElementById('surname').value,
            forename: document.getElementById('forename').value,
            rank: document.getElementById('rank').value,
            address: document.getElementById('address').value,
            regiment: document.getElementById('regiment').value,
            unit: document.getElementById('unit').value,
            articleComment: document.getElementById('articleComment').value,
            newspaperName: document.getElementById('newspaperName').value,
            newspaperDate: document.getElementById('newspaperDate').value,
            pageCol: document.getElementById('pageCol').value,
            photoIncl: document.getElementById('photoIncl').value
        };
        const params = new URLSearchParams();
        params.set("newRecord", "1");
        for (const key in recordValues) {
            params.set(key, recordValues[key]);
        }
        if (confirm("Record added successfully. Would you like to view the updated Newspaper Index table?")) {
            window.location.href = "NewsRefs.html?" + params.toString();
        } else {
            alert("Record added successfully. You can continue adding records.");
            this.reset();
        }
    });
</script>
</body>
</html>
