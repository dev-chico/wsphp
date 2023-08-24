<?php
header('content-type: application/json');
require_once "Database.php";
require_once './utils/createAndAppendElement.php';
require_once './utils/createAndAppendAttribute.php';

$db = new Database();
$connection = $db->connect();

$sql = "select * from professor";
$stmt = $connection->query($sql);
$teachersList = $stmt->fetchAll(PDO::FETCH_OBJ);

$dom = new DOMDocument();
$arq = "./xmls/teachers.xml";

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('teachers', '', '../dtds/teachers.dtd');
$dom = $imp->createDocument("", "", $dtd);
$dom->formatOutput = true;

$teachers = $dom->createElement('teachers');

foreach($teachersList as $t) {
    $teacher = $dom->createElement('teacher');

    // create teacher id
    createAndAppendAttribute('id', $t->id, $teacher, $dom);

    // create teacher name
    createAndAppendElement('name', $t->nome, $teacher, $dom);
    // create teacher email
    createAndAppendElement('semesters', $t->email, $teacher, $dom);

    $teachers->appendChild($teacher);
}

$dom->appendChild($teachers);
$dom->save($arq);