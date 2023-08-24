<?php
header('Content-Type: text/xml; charset=utf-8');
require_once "Database.php";
require_once './utils/createAndAppendElement.php';
require_once './utils/createAndAppendAttribute.php';

$db = new Database();
$connection = $db->connect();

$sql = "SELECT * FROM curso";
$stmt = $connection->query($sql);
$coursesList = $stmt->fetchAll(PDO::FETCH_OBJ);

$dom = new DOMDocument();
$arq = "./xmls/courses.xml";

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('courses', '', '../dtds/courses.dtd');
$dom = $imp->createDocument("", "", $dtd);
$dom->formatOutput = true;

$courses = $dom->createElement('courses');

foreach($coursesList as $c) {
    $course = $dom->createElement('course');

    // create course id
    createAndAppendAttribute('id', $c->id, $course, $dom);

    // create course name
    createAndAppendElement('name', $c->nome, $course, $dom);
    // create course semesters
    createAndAppendElement('semesters', $c->semestres, $course, $dom);

    $sql = "SELECT * FROM professor WHERE id =" . $c->id_coordenador;
    $stmt = $connection->query($sql);
    $coordinator = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach($coordinator as $coord) {
        // create course coordinatorsName
        createAndAppendElement('coordinatorsName', $coord->nome, $course, $dom);   
    }

    $courses->appendChild($course);
}

$dom->appendChild($courses);
$dom->save($arq);