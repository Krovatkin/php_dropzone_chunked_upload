<?php

require_once('return_response.php');

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




move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
$tmp_file_exsits = file_exists($_FILES['file']['tmp_name']);
// Be sure that the file has been uploaded
if ( !file_exists($targetFile) ) returnResponse("An error occurred and we couldn't upload the requested file. {$_FILES['file']['tmp_name']} to {$targetFile} {$tmp_file_exsits}", $targetFile, "error", 500);
chmod($targetFile, 0777) or returnResponse("Could not reset permissions on uploaded chunk.", $targetFile, "error", 500);

returnResponse(null, null, "success. The original filename {$_FILES['file']['name']}");