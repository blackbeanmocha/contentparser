<?php

/* include_once all relevant classes */
$CLASSES_DIR = array(
  "domain/*.php",
  "util/*php"
);
foreach ($CLASSES_DIR as $dir) {
  foreach (glob($dir) as $filename) {
      include_once $filename;
  }    
}
include_once "ContentFactory.php";
include_once "ContentHelper.php";
include_once "ContentValidator.php";


# main function
$contentFactory = new ContentFactory();
$content = $contentFactory->initialize("example.xml");
$ret = ContentValidator::validate($content);
$contentHelper = new ContentHelper($content);
$contentHelper->matchCounters();
?>