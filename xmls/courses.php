<?php

$dom = new DOMDocument();
$arq = "./xmls/courses.xml";

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('courses', '', '../dtds/courses.dtd');
$dom = $imp->createDocument("", "", $dtd);
$dom->formatOutput = true;

$courses = $dom->createElement('courses');

$dom->appendChild($courses);

$dom->save($arq);