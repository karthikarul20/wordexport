<?php 
require_once __DIR__ . '/includes/PHPWord-0.12.1/src/PhpWord/Autoloader.php'; 

date_default_timezone_set('UTC');

/**
 * Header file
 */
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
 

Autoloader::register();
Settings::loadConfig();
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection(); 
// Add style definitions
$phpWord->addParagraphStyle('pStyle', array('spacing'=>100));  
$phpWord->addLinkStyle('NLink', array('color'=>'0000FF'));
//$textrun->addComment('but the browser ignores it','put it new','kumaran','2016-05-23','pStyle');
// $textrun->addRevision("spaces",'delete','kumaran','03-05-2016','pStyle');

// Add text elements
$section->addText('original paragraph:');
$section->addText('This paragraph contains a lot of spaces in the source code, but the browser ignores it '); 
$section->addText('This paragraph contains a lot of in the source code, but the browser ignores it.'); 
$section->addText('This paragraph contains a lot of spaces in source the code, but the browser ignores it.'); 
$section->addLink('http://www.example.com', null, 'NLink');
$section->addTextBreak(2);

$section->addText('modified paragraph:');
$textrun = $section->createTextRun('pStyle'); 
$textrun->addText('This paragraph contains a lot of spaces in the source code, but the browser ignores it ');
$textrun->addComment('source1.','Can see','kumaran','2016-05-23','pStyle');
$textrun->addText(' This paragraph contains a lot of ');
$textrun->addRevision("spaces",'delete','kumaran','03-05-2016','pStyle');
$textrun->addRevision("space ",'insert','kumaran','03-05-2016','pStyle'); 
$textrun->addRevision("in the source code",'delete','kumaran','03-05-2016','pStyle');
$textrun->addText('but the browser ignores it.');
$textrun->addText('This paragraph contains a lot of spaces in the ');
$textrun->addComment('source','Test2','muthu','2016-05-24','pStyle');
$textrun->addText(' code, but the browser ignores it.'); 
$textrun->addRevision("Now i go to ate",'insert','kumaran','03-05-2016','pStyle');
$textrun->addLink('http://www.example.com', null, 'NLink');   

$textrun->addTextBreak(2);
$textrun->addText('This paragraph contains a lot of spaces in the source code, ');
$textrun->addComment('but the browser ignores it','put it new','kumaran','2016-05-23','pStyle');
$textrun->addText(' This paragraph contains a lot of ');
$textrun->addRevision("spaces",'delete','kumaran','03-05-2016','pStyle');
$textrun->addRevision("space",'insert','kumaran','03-05-2016','pStyle');
$textrun->addText(' in the source code, but the browser ignores it.');
$textrun->addText('This ');
$textrun->addComment('paragraph contains a lot of spaces in the ','put it test','muthu','2016-05-24','pStyle');
$textrun->addText(' code, but the browser ignores it.');
$textrun->addRevision("Now i go to eat",'insert','kumaran','03-05-2016','pStyle');
$textrun->addLink('http://www.example.com', null, 'NLink');

echo date('H:i:s'), ' Create new PhpWord object';
$targetFile = __DIR__ . "/word/exportWord1.docx";
$phpWord->save($targetFile, "Word2007");  
 
?>