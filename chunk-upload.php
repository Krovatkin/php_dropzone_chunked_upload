<?php

/* ========================================
  VARIABLES
======================================== */

// chunk variables
$fileId = $_POST['dzuuid'];
$chunkIndex = $_POST['dzchunkindex'] + 1;
$chunkTotal = $_POST['dztotalchunkcount'];

// file path variables
$ds = DIRECTORY_SEPARATOR;
$targetPath = dirname( __FILE__ ) . "{$ds}uploads{$ds}";
$fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
$fileSize = $_FILES["file"]["size"];
$filename = "{$fileId}-{$chunkIndex}.{$fileType}";
$targetFile = $targetPath . $filename;


/* ========================================
  DEPENDENCY FUNCTIONS
======================================== */

$returnResponse = function ($info = null, $filelink = null, $status = "error") {
  die (json_encode( array(
    "status" => $status,
    "info" => $info,
    "file_link" => $filelink
  )));
};

move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
$tmp_file_exsits = file_exists($_FILES['file']['tmp_name']);
// Be sure that the file has been uploaded
if ( !file_exists($targetFile) ) $returnResponse("An error occurred and we couldn't upload the requested file. {$_FILES['file']['tmp_name']} to {$targetFile} {$tmp_file_exsits}");
chmod($targetFile, 0777) or $returnResponse("Could not reset permissions on uploaded chunk.");

$returnResponse(null, null, "success. The original filename {$_FILES['file']['name']}");