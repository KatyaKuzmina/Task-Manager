<?php
require_once __DIR__ . '/../App/Models/TaskModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tag = $_POST['tag'];
    $description = $_POST['description'];
	$dateStart = $_POST['date_started'];
    $dateTill = $_POST['date_till'];
    $color = $_POST['color'];


    $taskModel = new Task();
    $success = $taskModel->update($id, $name, $tag, $description, $dateStart, $dateTill, $color);

    if ($success) {
        http_response_code(200);
        echo "ok";
    } else {
        http_response_code(500);
        echo "error.";
    }
}
