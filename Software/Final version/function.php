<?php
require_once 'DBconnect.php';
function display_Bios(){
    global $connect;
    $query = "SELECT * FROM Biography_Information"; //change 2: users to BI to see if it works woth the specific example. 
    $result = mysqli_query($connect, $query);
    return $result;
}

//made differently becuase it loads very slow. //fixed
function display_gwroh($offset = 0, $limit = 100) {
    global $connect;
    $query = "SELECT * FROM gwroh LIMIT ?, ?";
    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    } else {
        return false;
    }
}

function display_NewsRefs(){
    global $connect;
    $query = "SELECT * FROM Newspaper_ref"; // Selecting Data from NewsRefs table 
    $result = mysqli_query($connect, $query);
    return $result;
}

function display_Burials(){
    global $connect;
    $query = "SELECT * FROM Burials"; //Selecting Data from Burials table
    $result = mysqli_query($connect, $query);
    return $result;
}

function display_Memorials(){
    global $connect;
    $query = "SELECT * FROM Memorials";  //Selecting Data from Memorials table
    $result = mysqli_query($connect, $query);
    return $result;
}

function add_Burials() {
    global $connect;

    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $age = $_POST['DoB'];
    $medals = $_POST['Medals'];
    $dateOfDeath = $_POST['Date_of_Death'];
    $rank = $_POST['Rank'];
    $serviceNumber = $_POST['Service_Number'];
    $regiment = $_POST['Regiment'];
    $unit = $_POST['Battalion'];
    $cemetery = $_POST['Cemetery'];
    $graveReference = $_POST['Grave_Reference'];
    $info = $_POST['Info'];

    $query = "INSERT INTO Burials (Surname, Forename, DoB, Medals, Date_of_Death, Rank, Service_Number, Regiment, Battalion, Cemetery, Grave_Reference, Info) 
              VALUES ('$surname', '$forename', '$age', '$medals', '$dateOfDeath', '$rank', '$serviceNumber', '$regiment', '$unit', '$cemetery', '$graveReference', '$info')";

    mysqli_query($connect, $query);
}
function add_Bios() {
    global $connect;

    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $regiment = $_POST['Regiment'];
    $serviceNo = $_POST['ServiceNo'];
    $bioAttachment = $_POST['Biography'];

    $query = "INSERT INTO Biography_Information (Surname, Forename, Regiment, ServiceNo, Biography) 
              VALUES ('$surname', '$forename', '$regiment', '$serviceNo', '$bioAttachment')";

    mysqli_query($connect, $query);
}
function add_Memorials() {
    global $connect;
    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $regiment = $_POST['Regiment'];
    $battalion = $_POST['Battalion'];
    $memorial = $_POST['Memorial'];
    $memorialLocation = $_POST['MemorialLocation'];
    $memorialInfo = $_POST['MemorialInfo'];
    $memorialPostcode = $_POST['MemorialPostcode'];
    $district = $_POST['District'];
    $photoAvailable = $_POST['PhotoAvailable'];

    $query = "INSERT INTO Memorials (Surname, Forename, Regiment, Battalion, Memorial, MemorialLocation, MemorialInfo, MemorialPostcode, District, PhotoAvailable)
              VALUES ('$surname', '$forename', '$regiment', '$battalion', '$memorial', '$memorialLocation', '$memorialInfo', '$memorialPostcode', '$district', '$photoAvailable')";

    mysqli_query($connect, $query);
}
function add_GWROH() {
    global $connect;

    // collect values safely
    $surname = $_POST['Surname'] ?? '';
    $forename = $_POST['Forename'] ?? '';
    $address = $_POST['Address'] ?? '';
    $electoralWard = $_POST['Electoral Ward'] ?? '';
    $town = $_POST['Town'] ?? '';
    $rank = $_POST['Rank'] ?? '';
    $regiment = $_POST['Regiment'] ?? '';
    $battalion = $_POST['Battalion'] ?? '';
    $company = $_POST['Company'] ?? '';
    $age = $_POST['DoB'] ?? '';
    $serviceNo = $_POST['Service no'] ?? '';
    $otherRegiment = $_POST['Other Regiment'] ?? '';
    $otherUnit = $_POST['Other Unit'] ?? '';
    $otherServiceNo = $_POST['Other Service no'] ?? '';
    $medals = $_POST['Medals'] ?? '';
    $enlistmentDate = $_POST['enlistmentDategwroh'] ?? '';
    $dischargeDate = $_POST['dischargeDategwroh'] ?? '';
    $deathDate = $_POST['deathDategwroh'] ?? '';
    $miscInfo = $_POST['miscInfogwroh'] ?? '';
    $cemeteryMemorial = $_POST['cemeteryMemorialgwroh'] ?? '';
    $cemeteryMemorialRef = $_POST['cemeteryMemorialRefgwroh'] ?? '';
    $cemeteryMemorialCountry = $_POST['cemeteryMemorialCountrygwroh'] ?? '';
    $additionalCWGC = $_POST['additionalCWGCgwroh'] ?? '';

    $query = "INSERT INTO gwroh (
        Surname, Forename, Address, Electoral_Ward, Town, Rank, Regiment, Battalion, Company, DoB,
        `Service no`, `Other Regiment`, `Other Unit`, `Other Service no`, Medals, `Enlistment Date`, `Discharge Date`, `Death (in service) date`,
        `Misc info (Nroh)`, `Cemetery/Memorial`, `Cemetery/Memorial Ref`, `Cemetery/Memorial Country`, `Misc info (cwgc)`
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $connect->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }

    $stmt->bind_param("sssssssssssssssssssssss",
        $surname, $forename, $address, $electoralWard, $town, $rank, $regiment, $battalion, $company, $age,
        $serviceNo, $otherRegiment, $otherUnit, $otherServiceNo, $medals, $enlistmentDate, $dischargeDate, $deathDate,
        $miscInfo, $cemeteryMemorial, $cemeteryMemorialRef, $cemeteryMemorialCountry, $additionalCWGC
    );

    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }

    $stmt->close();
}

function add_NewsRefs() {
    global $connect;

    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $rank = $_POST['Rank'];
    $address = $_POST['Address'];
    $regiment = $_POST['Regiment'];
    $battalion = $_POST['Battalion'];
    $articleComment = $_POST['ArticleComment'];
    $newspaperName = $_POST['NewspaperName'];
    $newspaperDate = $_POST['NewspaperDate'];
    $pageCol = $_POST['PageCol'];
    $photoIncl = $_POST['PhotoIncl'];

    $query = "INSERT INTO Newspaper_ref (
        Surname, Forename, Rank, Address, Regiment, Battalion, ArticleComment, NewspaperName, NewspaperDate, PageCol, PhotoIncl
    ) VALUES (
        '$surname', '$forename', '$rank', '$address', '$regiment', '$battalion', '$articleComment', '$newspaperName', '$newspaperDate', '$pageCol', '$photoIncl'
    )";

    mysqli_query($connect, $query);
}


?>
