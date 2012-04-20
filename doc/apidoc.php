<?
$xslDoc = new DOMDocument();
$xslDoc->load('inc/drpublish-apidoc.xsl');

$xmlDoc = new DOMDocument();
$xmlDoc->load('http://stefan.aptoma.no:9000');

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
header('Content-type: text/html; charset=utf-8');
echo $proc->transformToXML($xmlDoc);
