<?php

/* include_once all relevant classes */
$CLASSES_DIR = array(
  "domain/*.php",
  "util/*.php",
  "service/*.php"
);
foreach ($CLASSES_DIR as $dir) {
  foreach (glob($dir) as $filename) {
      include_once $filename;
  }    
}

$pappsRequestFactory = new PappsRequestFactory();
$inputFile  = "/var/www/parcs/parcs_papps/queue/papps_request-9-input.xml";
$pappsRequest = $pappsRequestFactory->initialize($inputFile);
$pappsRequestHandler = new PappsRequestHandler($pappsRequest);
$pappsRequestHandler->match();
//system('/bin/rm -f ' . escapeshellarg($inputFile));
?>