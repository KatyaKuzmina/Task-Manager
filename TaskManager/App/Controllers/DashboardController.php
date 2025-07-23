<?php
require_once __DIR__ . '/../Core/BaseController.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TaskModel.php';

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new User();
        $taskModel = new Task();

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('Location: /TaskManager/public/login');
            exit;
        }

        $userData = $userModel->findById($userId);
        $tasks = $taskModel->getAllByUserId($userId);

        $this->render('dashboard/index', [
            'title' => 'Task Manager',
            'user' => $userData,
            'tasks' => $tasks
        ]);
    }
}
