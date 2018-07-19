<?php
namespace App\my\example;

use Sunra\PhpSimple\HtmlDomParser;

class ParsePhoto
{
    static public function parse($id){
        $dom = HtmlDomParser::str_get_html( file_get_contents('http://uaz-upi.com/price?'.http_build_query(['filters'=>['catnum'=>$id]])) );

        if($dom->getElementsByTagName('table')!=null && $dom->find('table')[0]->children(1)->children(0)->children(3)->has_child()){
            if($dom->find('table')[0]->children(1)->children(0)->children(3)->firstChild()->hasAttribute('target')){
                unset($dom);
                return false;
            }
            $elems = $dom->find('table')[0]->children(1)->children(0)->children(3)->firstChild()->attr['href'];
            unset($dom);
            return 'http://uaz-upi.com'.$elems;
        } else {
            unset($dom);
            return false;
        }

    }
}