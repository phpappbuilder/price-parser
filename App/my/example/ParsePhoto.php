<?php
namespace App\my\example;

use Sunra\PhpSimple\HtmlDomParser;

class ParsePhoto
{
    static public function parse($id){
        $dom = HtmlDomParser::str_get_html( file_get_contents('http://uaz-upi.com/price?filters[catnum]='.$id) );

        if($dom->getElementsByTagName('table')!=null && $dom->find('table')[0]->children(1)->children(0)->children(3)->has_child()){
            $elems = $dom->find('table')[0]->children(1)->children(0)->children(3)->lastChild()->attr['href'];
            return 'http://uaz-upi.com'.$elems;
        } else {
            return false;
        }

    }
}