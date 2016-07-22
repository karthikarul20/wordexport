<?php
require_once __DIR__ . '/includes/JSLikeHTMLElement.php';
require_once __DIR__ . '/includes/PHPWord-master/src/PhpWord/Autoloader.php'; 
/**
 * Header file
 */
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Image as Image;
use PhpOffice\PhpWord\Media;

Autoloader::register();

date_default_timezone_set ( 'UTC' );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set ( 'max_execution_time', 0 );
$name='list';
$file = __DIR__ . "/html/{$name}.html";
$content = file_get_contents ( $file );//get content

// set error level
// $internalErrors = libxml_use_internal_errors(true);


// HTML dom config
$dom = new DOMDocument( '1.0', 'UTF-8' );
$dom->registerNodeClass( 'DOMElement', 'JSLikeHTMLElement' );
$htmlContent = mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );
$dom->loadHTML( $htmlContent );

// Restore error level
// libxml_use_internal_errors($internalErrors);


// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
$section->addText(
    htmlspecialchars('Test Sample List')
);


function processLi($child, $section){
		
    if (strtolower ( $child->nodeName ) == 'ol' || strtolower ( $child->nodeName ) == 'ul')
    {
        $section->addText('list - '.$child->nodeName);
        print_r('*');
        echo "\r\n";
        if($child->hasChildNodes()) {
            $lis = $child->childNodes;
            foreach ( $lis as $li ) {
                echo "\r\n";
                echo "\t";
                print_r($li->nodeName);
                
                if (strtolower ( $li->firstChild->nodeName ) == 'ol' || strtolower ( $li->firstChild->nodeName ) == 'ul')
                {
                    echo "\r\n";
                    echo 'Going to be recursive';
                    
                    foreach ($li->childNodes  as $liChild  ) {
                        echo "\t";
                        print_r($li->firstChild->nodeName);
                        processLi($liChild, $section);
                    }
                }
                else if (strtolower ( $li->nodeName ) == 'li')
                {
                    $section->addListItem($li->nodeName.' - '.$li->textContent);
                    echo ' --- ';
                    print_r($li->textContent); 
                }                            
            }
        }
        
    } 
}


$xpath = new DOMXPath( $dom );
$xpath->registerNamespace( 'php', 'http://php.net/xpath' );
$xpath->registerPhpFunctions( array( 'preg_match', 'preg_split','preg_replace', 'sizeof', 'str_word_count' ) );

$results = $xpath->query ( '//div[contains(@class,"body")]' );
echo 'before creating......';

foreach ( $results as $resultNode ) {
    if (strtolower ( $resultNode->nodeName ) == 'div') {
        
        if($resultNode->hasChildNodes()) {
            $children = $resultNode->childNodes;
            foreach ( $children as $child ) {
                // create recursive for html element childs
                echo "\r\n";
                print_r($child->nodeName);
                processLi($child, $section);
               
            }
        } 
        
    }
}


$exportFile=  __DIR__ ."/word/{$name}.docx";
$exportFile=  "{$name}.docx";
// print_r($section);




// Saving the document as OOXML file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$phpWord->save($exportFile, 'Word2007');


// $count=1/0;
echo "\r";
echo "\r";
echo '**************************';
echo "\r";



?>