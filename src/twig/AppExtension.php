<?php 
/*
require_once 'BaseController.php';

class AppExtension extends BaseController
{
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('number_word', [$this,'number_words']),
        ];
    }

    public function number_words($string, $limit = 25, $fin = ' ...')
    {
    preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
    
    if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
        return $string;
        }
    return rtrim($matches[0]).$fin;
    }
}
*/

?>