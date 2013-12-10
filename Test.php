
<?php

class foo
{
    public function printItem($string)
    {
        echo 'Foo: ' . $string . PHP_EOL;
        $is_valid = false;
        $op = "<";
        $is_valid = (10 $op 20);
        echo "\n is Valid:  $is_valid \n";
    }
    
    public function printPHP()
    {
        echo 'PHP is great.' . PHP_EOL;
    }
}

class bar extends foo
{
    public function printItem($string)
    {
        echo 'Bar: ' . $string . PHP_EOL;
    }
}

class zam extends foo
{
    public function printItem($string)
    {
        echo 'Zam: ' . $string . PHP_EOL;
    }
}

$foo = new foo();
$bar = new bar();
$foo->printItem('baz'); // Output: 'Foo: baz'
$foo->printPHP();       // Output: 'PHP is great' 
$bar->printItem('baz'); // Output: 'Bar: baz'
$bar->printPHP();       // Output: 'PHP is great'

?>
