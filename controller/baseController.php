<?php

class baseController 
{
    public function number_words($string, $limit = 25, $fin = ' ...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
        
        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
            }
        echo rtrim($matches[0]).$fin;
    }

}

?>