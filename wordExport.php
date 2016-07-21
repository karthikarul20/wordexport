<?php
require_once __DIR__ . '/includes/exportHTMLTOWord.class.php';
date_default_timezone_set ( 'UTC' );
ini_set ( 'display_errors', 0);
ini_set ( 'max_execution_time', 0 );
$name='Springer';
$file = __DIR__ . "/html/{$name}.html";
$content = file_get_contents ( $file );//get content

//create object form exportWord class
$html2Doc = new exportToWord ( $content );

echo "<pre>";
//call export function
$exportFile= __DIR__ . "/word/{$name}.docx";
$html2Doc->htmlToWord ($exportFile);
?>