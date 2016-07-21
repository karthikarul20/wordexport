<?php
require_once __DIR__ . '/includes/JSLikeHTMLElement.php';
require_once __DIR__ . '/includes/PHPWord-0.12.1/src/PhpWord/Autoloader.php'; 
/**
 * Header file
 */
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Image as Image;
use PhpOffice\PhpWord\Media;

Autoloader::register();
Settings::loadConfig();

date_default_timezone_set ( 'UTC' );
ini_set ( 'display_errors', 1);
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


$phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
$section->addText('Sample List Conversion');



function processLi($child){
		
    if (strtolower ( $child->nodeName ) == 'ol' || strtolower ( $child->nodeName ) == 'ul')
    {
        // $section->addText('list - '.$child->nodeName);
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
                        processLi($liChild);
                    }
                }
                else if (strtolower ( $li->nodeName ) == 'li')
                {
                    //$section->addListItem($li->nodeName);
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


foreach ( $results as $resultNode ) {
    if (strtolower ( $resultNode->nodeName ) == 'div') {
        
        if($resultNode->hasChildNodes()) {
            $children = $resultNode->childNodes;
            print_r($children);
            foreach ( $children as $child ) {
                // create recursive for html element childs
                echo "\r\n";
                print_r($child->nodeName);
                processLi($child);
               
            }
        } 
        
    }
}


$exportFile= __DIR__ . "/word/{$name}.docx";


echo 'before creating......';
// Saving the document as OOXML file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

// $objWriter->save($exportFile);
// $phpWord->save( $exportFile, 'Word2007' ); //save as Document

$count=0;
echo "\r";
echo "\r";
echo '**************************';
echo "\r";



?>