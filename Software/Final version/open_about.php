<?php

// 1. Mapping doc keys -> actual docx filenames
$validDocs = [
    'BradSurrTowns' => 'BradSurrTowns.docx',
    'BradMem'       => 'BradMem.docx',
    'BurBrad'       => 'BurBrad.docx',
    'NewsRefs'      => 'NewsRefs.docx',
    'Bios'          => 'Bios.docx'
];

// 2. Check the ?doc= param
$docKey = isset($_GET['doc']) ? $_GET['doc'] : '';
if (!array_key_exists($docKey, $validDocs)) {
    die("Invalid doc parameter or doc not found in map.");
}

$docFile  = $validDocs[$docKey];               // e.g. "BradSurrTowns.docx"
$fullPath = __DIR__ . '/' . $docFile;          // c:\xampp\htdocs\BradSurrTowns.docx
$httpUrl  = "http://localhost:8083/" . rawurlencode($docFile);
// This is used in the ms-word link: ms-word:ofe|u|http://localhost:8083/BradSurrTowns.docx

if (!file_exists($fullPath)) {
    die("File $docFile not found on server.");
}

// 3. Check if reuploading (POST)
if (isset($_POST['upload'])) {
    // The user is re-uploading an updated doc
    if (!isset($_FILES['updated_doc']) || $_FILES['updated_doc']['error'] !== UPLOAD_ERR_OK) {
        die("No updated file uploaded or an error occurred.");
    }
    $tmpPath = $_FILES['updated_doc']['tmp_name'];

    // Overwrite the existing doc in htdocs
    if (!move_uploaded_file($tmpPath, $fullPath)) {
        die("Failed to overwrite $docFile on the server.");
    }

    echo "<p>Successfully updated <strong>$docFile</strong> on the server.</p>";
    echo "<p><a href=\"open_about.php?doc=$docKey\">Back</a></p>";
    exit;
}

// 4. If not a POST, display the admin page (ms-word link, download, upload form)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin: <?php echo htmlspecialchars($docFile); ?></title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .btn {
      background: #800000; color: #fff; border: none; padding: 8px 16px;
      border-radius: 4px; cursor: pointer; margin: 5px 0;
    }
    .btn:hover { background: #333; }
  </style>
</head>
<body>
<h1>Admin - Edit Document: <?php echo htmlspecialchars($docFile); ?></h1>

<ol>
  <li>
    <strong>Open in Word (ms-word link):</strong><br>
    <!-- This tries to launch Word for direct editing -->
    <a href="ms-word:ofe|u|<?php echo $httpUrl; ?>">
      <button class="btn">Open in Word</button>
    </a>
    <p>
      If your browser or system supports this, clicking will open
      Microsoft Word. Changes might or might not be saved back automatically
      without WebDAV. If not, proceed with download and re-upload.
    </p>
  </li>
  
  <li>
    <strong>Download the Document:</strong><br>
    <a href="<?php echo htmlspecialchars($docFile); ?>" download>
      <button class="btn">Download .docx</button>
    </a>
    <p>
      Save locally, edit offline, then come back here to re-upload your changes.
    </p>
  </li>

  <li>
    <strong>Re-upload Updated Document:</strong><br>
    <form action="open_about.php?doc=<?php echo urlencode($docKey); ?>" method="POST" enctype="multipart/form-data">
      <input type="file" name="updated_doc" accept=".docx" required>
      <br><br>
      <button type="submit" name="upload" class="btn">Upload Updated File</button>
    </form>
    <p>This will overwrite <strong><?php echo htmlspecialchars($docFile); ?></strong> on the server.</p>
  </li>
</ol>

</body>
</html>
