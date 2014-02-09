contentparser
=============
Please refer Parser.php to integrate with UI.

```php
$contentFactory = new ContentFactory();
// Read input in xml format and produce Content object which has list of parser profiles.
$content = $contentFactory->initialize("testdata/input.xml"); 
// Validate input
$ret = ContentValidator::validate($content);
$contentHelper = new ContentHelper($content);
// Match counters
$contentHelper->matchCounters();
```
