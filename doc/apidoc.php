<?php
$xslDoc = new DOMDocument();
$xslDoc->load('inc/drpublish-apidoc.xsl');
$xmlDoc = new DOMDocument();
$xmlDoc->load('inc/drpublish-apidoc.xml');
$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
header('Content-type: text/html; charset=utf-8');
print($proc->transformToXML($xmlDoc));