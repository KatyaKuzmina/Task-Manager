<?php
require_once __DIR__ . '/../App/Models/TaskModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];

	if ($id) {
		$taskModel = new Task();
		$success = $taskModel->delete($id);

		if ($success) {
			http_response_code(200);
			echo "Task deleted successfully.";
		} else {
			http_response_code(500);
			echo "Error deleting task.";
		}
	} else {
		http_response_code(400);
		echo "Invalid ID.";
	}
}
