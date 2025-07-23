<?php
require_once __DIR__ . '/../App/Models/TaskModel.php';
session_start();

$timezone = date_default_timezone_get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$userId = $_SESSION['user']['id'] ?? null;
	$name = $_POST['name'] ?? '';
	$tag = $_POST['tag'] ?? '';
	$description = $_POST['description'] ?? '';
	$dateStart = $_POST['date_started'] ?? null;
	$dateTill = $_POST['date_till'] ?? null;
	$color = $_POST['color'] ?? '';
	$progress = $_POST['progress'] ?? 'upcoming';

	if (!$dateStart) {
		$dateStart = date('Y-m-d');
	}
	if (!$dateTill) {
		$dateTill = date('Y-m-d');
	}

	if (!$userId || !$name) {
		http_response_code(400);
		echo "Missing required fields.";
		exit;
	}

	$taskModel = new Task();
	$success = $taskModel->create($userId, $name, $tag, $description, $dateStart, $dateTill, $color, $progress);

	if ($success) {
		http_response_code(200);
		echo "Task created successfully";
	} else {
		http_response_code(500);
		echo "Failed to create task.";
	}
}
