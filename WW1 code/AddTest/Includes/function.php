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

    $query = "INSERT INTO Biography_Information (Surname, Forename, Regiment, Service_no, Biography) 
              VALUES ('$surname', '$forename', '$regiment', '$serviceNo', '$bioAttachment')";

    mysqli_query($connect, $query);
}
function add_Memorials() {
    global $connect;
    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $regiment = $_POST['Regiment'];
    $unit = $_POST['Battalion'];
    $memorial = $_POST['Memorial'];
    $memorialLocation = $_POST['MemorialLocation'];
    $memorialInfo = $_POST['MemorialInfo'];
    $memorialPostcode = $_POST['MemorialPostcode'];
    $district = $_POST['District'];
    $photoAvailable = $_POST['PhotoAvailable'];

    $query = "INSERT INTO Memorials (Surname, Forename, Regiment, Battalion, Memorial, MemorialLocation, MemorialInfo, MemorialPostcode, District, PhotoAvailable)
              VALUES ('$surname', '$forename', '$regiment', '$unit', '$memorial', '$memorialLocation', '$memorialInfo', '$memorialPostcode', '$district', '$photoAvailable')";

    mysqli_query($connect, $query);
}
function add_GWROH() {
    global $connect;

    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $address = $_POST['Address'];
    $electoralWard = $_POST['Electoral Ward'];
    $town = $_POST['Town'];
    $rank = $_POST['Rank'];
    $regiment = $_POST['Regiment'];
    $unit = $_POST['Battalion'];
    $company = $_POST['Company'];
    $age = $_POST['DoB'];
    $serviceNo = $_POST['Service no'];
    $otherRegiment = $_POST['Other Regiment'];
    $otherUnit = $_POST['Other Unit'];
    $otherServiceNo = $_POST['Other Service'];
    $medals = $_POST['Medals'];
    $enlistmentDate = $_POST['Enlistment Date'];
    $dischargeDate = $_POST['Discharge Date'];
    $deathDate = $_POST['Death (in service) Date'];
    $miscInfo = $_POST['Misc info (Norh)'];
    $cemeteryMemorial = $_POST['Cemetery/Memorial'];
    $cemeteryMemorialRef = $_POST['Cemetery/Memorial Ref'];
    $cemeteryMemorialCountry = $_POST['Cemetery/Memorial Country'];
    $additionalCWGC = $_POST['Misc info (cwgc)'];

    $query = "INSERT INTO gwroh (
        Surname, Forename, Address, Electoral_Ward, Town, Rank, Regiment, Battalion, Company, DoB,
        Service_no, Other_Regiment, Other_Unit, Other_Service_no, Medals, Enlistment_Date, Discharge_Date, Death_Date,
        Misc_Info_(Nroh), Cemetery/Memorial, Cemetery/Memorial_Ref, Cemetery/Memorial_Country, Misc_info_(cwgc)
    ) VALUES (
        '$surname', '$forename', '$address', '$electoralWard', '$town', '$rank', '$regiment', '$unit', '$company', '$age',
        '$serviceNo', '$otherRegiment', '$otherUnit', '$otherServiceNo', '$medals', '$enlistmentDate', '$dischargeDate', '$deathDate',
        '$miscInfo', '$cemeteryMemorial', '$cemeteryMemorialRef', '$cemeteryMemorialCountry', '$additionalCWGC'
    )";

    mysqli_query($connect, $query);
}
function add_NewsRefs() {
    global $connect;

    $surname = $_POST['Surname'];
    $forename = $_POST['Forename'];
    $rank = $_POST['Rank'];
    $address = $_POST['Address'];
    $regiment = $_POST['Regiment'];
    $unit = $_POST['Battalion'];
    $articleComment = $_POST['Article Comment'];
    $newspaperName = $_POST['Newspaper Name'];
    $newspaperDate = $_POST['Newspaper Date'];
    $pageCol = $_POST['PageCol'];
    $photoIncl = $_POST['PhotoIncl'];

    $query = "INSERT INTO Newspaper_ref (
        Surname, Forename, Rank, Address, Regiment, Unit, Article_Comment, Newspaper_Name, Newspaper_Date, Page_Col, Photo_Incl
    ) VALUES (
        '$surname', '$forename', '$rank', '$address', '$regiment', '$unit', '$articleComment', '$newspaperName', '$newspaperDate', '$pageCol', '$photoIncl'
    )";

    mysqli_query($connect, $query);
}


?>
