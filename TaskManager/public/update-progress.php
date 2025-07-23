<?php
require_once __DIR__ . '/../App/Models/TaskModel.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id'], $input['progress'])) {
    $id = $input['id'];
    $progress = $input['progress'];

    $taskModel = new Task();
    $success = $taskModel->updateProgress($id, $progress);

    if ($success) {
        http_response_code(200);
        echo 'ok';
    } else {
        http_response_code(500);
        echo 'error';
    }
} else {
    http_response_code(400);
    echo 'error';
}
