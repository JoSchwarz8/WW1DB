<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'DBconnect.php'; // Asegúrate de que este archivo inicialice $connect (de tipo mysqli)

// Si se envía el formulario de importación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que se haya subido un archivo y que no haya errores
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];
        $fileSize = $_FILES['csvFile']['size'];
        $fileType = $_FILES['csvFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Verifica si es un CSV (puedes ampliar la lista de extensiones permitidas si lo requieres)
        if ($fileExtension !== 'csv') {
            echo "El archivo debe tener la extensión .csv";
            exit;
        }
        
        // Abre el archivo para leerlo
        if (($handle = fopen($fileTmpPath, "r")) !== false) {
            // Primero, vaciamos la tabla Newspaper_ref para sobrescribir lo existente
            $truncateQuery = "TRUNCATE TABLE Newspaper_ref";
            if (!mysqli_query($connect, $truncateQuery)) {
                echo "Error al vaciar la tabla: " . mysqli_error($connect);
                exit;
            }
            
            // Prepara la consulta de inserción (usaremos placeholders para mayor seguridad)
            $insertQuery = "INSERT INTO Newspaper_ref (Surname, Forename, Rank, Address, Regiment, Unit, `Article Comment`, `Newspaper Name`, `Newspaper Date`, PageCol, PhotoIncl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $connect->prepare($insertQuery)) {
                // Si el CSV contiene encabezados, saltamos la primera línea.
                $firstLine = fgetcsv($handle, 1000, ",");
                // Comprobar si la primera línea contiene encabezados conocidos (opcional)
                // Por ejemplo, podrías validar si en $firstLine[0] se encuentra la palabra "Surname".
                if (isset($firstLine[0]) && strtolower($firstLine[0]) === 'surname') {
                    // Se asume que es encabezado, no lo insertamos
                } else {
                    // Si no hay encabezado, retrocedemos al inicio
                    rewind($handle);
                }
                
                // Lee línea por línea el archivo CSV e inserta en la tabla.
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    // Asegúrate de que el CSV tenga 11 columnas; puedes agregar validación.
                    if (count($data) < 11) {
                        continue; // Si la línea tiene menos columnas de las esperadas, saltarla.
                    }
                    
                    // Mapear los datos a cada columna (ajusta si el orden es diferente)
                    $surname         = $data[0];
                    $forename        = $data[1];
                    $rank            = $data[2];
                    $address         = $data[3];
                    $regiment        = $data[4];
                    $unit            = $data[5];  // Se corresponde con 'Battalion'
                    $articleComment  = $data[6];
                    $newspaperName   = $data[7];
                    $newspaperDate   = $data[8];
                    $pageCol         = $data[9];
                    $photoIncl       = $data[10];
                    
                    // Vincula los parámetros a la consulta preparada
                    $stmt->bind_param("sssssssssss", 
                        $surname, 
                        $forename, 
                        $rank, 
                        $address, 
                        $regiment, 
                        $unit, 
                        $articleComment, 
                        $newspaperName, 
                        $newspaperDate, 
                        $pageCol, 
                        $photoIncl
                    );
                    $stmt->execute();
                }
                fclose($handle);
                $stmt->close();
                
                echo "Archivo CSV importado correctamente y la tabla ha sido sobrescrita.";
            } else {
                echo "Error al preparar la consulta: " . mysqli_error($connect);
            }
        } else {
            echo "Error al abrir el archivo CSV.";
        }
    } else {
        echo "No se ha subido ningún archivo o se produjo un error durante la subida.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Importar CSV a Newspaper_ref</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Agrega estilos básicos para el formulario */
        .import-form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .import-form input[type="file"] {
            margin-bottom: 10px;
        }
        .import-form button {
            padding: 10px 20px;
            background-color: #9b111e;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .import-form button:hover {
            background-color: #7a0c17;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Importar CSV a Newspaper_ref</h1>
    <form class="import-form" action="Import.php" method="post" enctype="multipart/form-data">
        <label for="csvFile">Seleccione el archivo CSV:</label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
        <br>
        <button type="submit">Importar Archivo</button>
    </form>
    <a href="NewsRefs.php">Volver a la tabla</a>
</div>
</body>
</html>
