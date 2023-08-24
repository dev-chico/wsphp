<?php
header('content-type: application/json');
require_once "Database.php";
require_once './utils/createAndAppendElement.php';
require_once './utils/createAndAppendAttribute.php';

$db = new Database();
$connection = $db->connect();

$sql = "SELECT * FROM disciplina";
$stmt = $connection->query($sql);
$disciplinesList = $stmt->fetchAll(PDO::FETCH_OBJ);

$dom = new DOMDocument();
$arq = "./xmls/disciplines.xml";

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('disciplines', '', '../dtds/disciplines.dtd');
$dom = $imp->createDocument("", "", $dtd);
$dom->formatOutput = true;

$disciplines = $dom->createElement('disciplines');

foreach($disciplinesList as $d) {
    $discipline = $dom->createElement('discipline');

    // create discipline id
    createAndAppendAttribute('id', $d->id, $discipline, $dom);

    // create discipline name
    createAndAppendElement('name', $d->nome, $discipline, $dom);
    // create discipline code
    createAndAppendElement('code', $d->codigo, $discipline, $dom);
    // create discipline workload
    createAndAppendElement('workload', $d->carga, $discipline, $dom);
    // create discipline semester
    createAndAppendElement('semester', $d->semestre, $discipline, $dom);
    // create discipline courseProgram
    createAndAppendElement('courseProgram', $d->ementa, $discipline, $dom);

    $sql = "SELECT * FROM curso WHERE id =" . $d->id_curso;
    $stmt = $connection->query($sql);
    $course = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach($course as $c) {
        // create discipline courseName
        createAndAppendElement('courseName', $c->nome, $discipline, $dom);
    }

    $disciplines->appendChild($discipline);
}

$dom->appendChild($disciplines);
$dom->save($arq);