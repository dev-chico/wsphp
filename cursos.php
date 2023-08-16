<?php
header('content-type: application/json');
require_once "Database.php";

$db = new Database();
$conexao = $db->connect();

var_dump($conexao);

$sql = "select * from curso";

$stmt = $conexao->query($sql);

$cursos = $stmt->fetchAll(PDO::FETCH_OBJ);

echo(json_encode($cursos));