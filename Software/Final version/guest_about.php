<?php

$validDocs = [
    'BradSurrTowns' => 'BradSurrTowns.docx',
    'BradMem'       => 'BradMem.docx',
    'BurBrad'       => 'BurBrad.docx',
    'NewsRefs'      => 'NewsRefs.docx',
    'Bios'          => 'Bios.docx'
];

$docKey = isset($_GET['doc']) ? $_GET['doc'] : '';
if (!array_key_exists($docKey, $validDocs)) {
    die("Invalid doc parameter.");
}

$docFile  = $validDocs[$docKey]; // e.g. "BradSurrTowns.docx"
$fullPath = __DIR__ . '/' . $docFile;
$httpUrl  = "http://localhost:8083/" . rawurlencode($docFile);

if (!file_exists($fullPath)) {
    die("File $docFile not found on server.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guest View: <?php echo htmlspecialchars($docFile); ?></title>
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
<h1>Guest - View-Only: <?php echo htmlspecialchars($docFile); ?></h1>

<ol>
  <li>
    <strong>Open in Word (ms-word link):</strong><br>
    <a href="ms-word:ofe|u|<?php echo $httpUrl; ?>">
      <button class="btn">Open in Word</button>
    </a>
    <p>
      This attempts to launch Microsoft Word. Guests cannot upload changes, so
      any edits remain local. The server copy remains untouched.
    </p>
  </li>
  
  <li>
    <strong>Download the Document:</strong><br>
    <a href="<?php echo htmlspecialchars($docFile); ?>" download>
      <button class="btn">Download .docx</button>
    </a>
    <p>Feel free to save a local copy, but you cannot overwrite the server file.</p>
  </li>
</ol>

</body>
</html>
