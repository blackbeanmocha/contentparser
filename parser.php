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

# main function
$contentFactory = new ContentFactory();
$content = $contentFactory->initialize("testdata/input.xml");
$ret = ContentValidator::validate($content);
$contentHelper = new ContentHelper($content);
$contentHelper->matchCounters();
?>