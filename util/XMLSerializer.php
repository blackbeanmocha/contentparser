<?php
class XMLSerializer {

    // functions adopted from http://www.sean-barton.co.uk/2009/03/turning-an-array-or-object-into-xml-using-php/
    
    public static function generateValidXmlFromArray($array, $node_block='object', $node_name='objectString') {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $xml .= '<' . $node_block . '>';
        $xml .= self::generateXmlFromArray($array, $node_name);
        $xml .= '</' . $node_block . '>';

        return $xml;
    }

    private static function generateXmlFromArray($array, $node_name) {
        $xml = '';
        if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                if (is_numeric($key)) {
                    $xml .= '<' . $node_name . '>' . self::generateXmlFromArray($value, $node_name) . '</' . $node_name . '>';
                } else if(!is_numeric($key) && is_array($value)) {
                    $xml .= self::generateXmlFromArray($value, $node_name);
                } else {
                    $xml .= '<' . $key . '>' . self::generateXmlFromArray($value, $node_name) . '</' . $key . '>';
                }
                
            }
        } else {
            $xml = htmlspecialchars($array, ENT_QUOTES);
        }

        return $xml;
    }
}
?>