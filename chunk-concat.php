<?php

// get variables
$fileId = $_GET['dzuuid'];
$chunkTotal = $_GET['dztotalchunkcount'];

// file path variables
$ds = DIRECTORY_SEPARATOR;
$targetPath = dirname( __FILE__ ) . "{$ds}uploads{$ds}";
$fileType = $_GET['fileName'];

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

/* ========================================
  CONCATENATE UPLOADED FILES
======================================== */

// loop through temp files and grab the content
for ($i = 1; $i <= $chunkTotal; $i++) {

  // target temp file
  $temp_file_path = realpath("{$targetPath}{$fileId}-{$i}.{$fileType}") or $returnResponse("Your chunk was lost mid-upload.");

  // copy chunk
  $chunk = file_get_contents($temp_file_path);
  if ( empty($chunk) ) $returnResponse("Chunks are uploading as empty strings.");

  // add chunk to main file
  file_put_contents("{$targetPath}{$fileId}.{$fileType}", $chunk, FILE_APPEND | LOCK_EX);

  // delete chunk
  unlink($temp_file_path);
  if ( file_exists($temp_file_path) ) $returnResponse("Your temp files could not be deleted.");

}

/* ========== a bunch of steps I removed below here because they're irrelevant, but I described them anyway ========== */
// create FileMaker record
// run FileMaker script to populate container field with newly-created file
// unlink newly created file
// return success