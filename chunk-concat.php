<?php

require_once('return_response.php');
// get variables
$fileId = $_GET['dzuuid'];
$chunkTotal = $_GET['dztotalchunkcount'];

// file path variables
$ds = DIRECTORY_SEPARATOR;
$targetPath = dirname( __FILE__ ) . "{$ds}uploads{$ds}";
$fileType = $_GET['fileName'];

// loop through temp files and grab the content
for ($i = 1; $i <= $chunkTotal; $i++) {

  // target temp file
  $temp_file_path = realpath("{$targetPath}{$fileId}-{$i}.{$fileType}") or returnResponse("Your chunk was lost mid-upload.", $fileId, "error", 500);

  // copy chunk
  $chunk = file_get_contents($temp_file_path);
  if ( empty($chunk) ) returnResponse("Chunks are uploading as empty strings.", $temp_file_path, "error", 500);

  // add chunk to main file
  file_put_contents("{$targetPath}{$fileId}.{$fileType}", $chunk, FILE_APPEND | LOCK_EX);

  // delete chunk
  unlink($temp_file_path);
  if ( file_exists($temp_file_path) ) returnResponse("Your temp files could not be deleted.", $temp_file_path, "error", 500);

}

returnResponse("Successfully concated {$targetPath}{$fileId}.{$fileType}");
