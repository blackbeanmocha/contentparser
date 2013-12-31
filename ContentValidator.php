<?php
  
Class ContentValidator {
  
	public static function validate($content) {
		ContentValidator::verifyPlatform($content);
	}
  
	protected static function verifyPlatform($content) {
		if(ContentValidator::extractPlatform($content) == $content->platform) {
			return true;
		}
		return false;
	}
  
	private static function extractPlatform($content) {
	  
		$retVal = SystemUtil::executeCommand("find $content->tsExtractedPath/tmp/cli -name 'techsupport*' -print | 
			xargs egrep -ri '^cfg.platform.model:' ");
		$platform = $retVal[0];
		return substr($platform, -4);  
	}
} 
?>