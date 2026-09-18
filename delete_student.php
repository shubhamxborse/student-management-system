<?php

session_start();

require_once "config/database.php";

$id = $_GET["id"] ?? "";

if (!ctype_digit($id)) {

    die("Invalid student ID.");

}

$sql = "DELETE FROM students WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$_SESSION["success"] = "Student deleted successfully!";

header("Location: students.php");

exit;