<?php

/* include_once all relevant classes */
include_once "Content.php";
include_once "ContentFactory.php";
include_once "ContentHelper.php";
include_once "ContentValidator.php";
include_once "Object.php";
include_once "ObjectType.php";
include_once "Counter.php";
include_once "ParserProfile.php";
include_once "ParserConstants.php";
include_once "SystemUtil.php";

# main function
$contentFactory = new ContentFactory();
$content = $contentFactory->initialize("example.xml");
$ret = ContentValidator::validate($content);
$contentHelper = new ContentHelper($content);
$contentHelper->matchCounters();
?>