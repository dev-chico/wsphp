<?php
header('content-type: application/json');
require_once "Database.php";
require_once './utils/createAndAppendElement.php';
require_once './utils/createAndAppendAttribute.php';

$db = new Database();
$conexao = $db->connect();

$sql = "select * from curso";
$stmt = $conexao->query($sql);
$cursosList = $stmt->fetchAll(PDO::FETCH_OBJ);

$dom = new DOMDocument();
$arq = "./xmls/courses.xml";

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('courses', '', '../dtds/courses.dtd');
$dom = $imp->createDocument("", "", $dtd);
$dom->formatOutput = true;

$courses = $dom->createElement('courses');

foreach($cursosList as $c) {
    $course = $dom->createElement('course');

    // create course id
    createAndAppendAttribute('id', $c->id, $course, $dom);

    // create course name
    createAndAppendElement('name', $c->nome, $course, $dom);
    // create course semesters
    createAndAppendElement('semesters', $c->semestres, $course, $dom);
    // create coordinator id
    createAndAppendElement('coordinatorId', $c->id_coordenador, $course, $dom);

    $courses->appendChild($course);
}

$dom->appendChild($courses);
$dom->save($arq);