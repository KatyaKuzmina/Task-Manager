<?php

require_once __DIR__ . '/../Models/UserModel.php';

class BaseController
{
    protected $userName = '';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['user']['id'])) {
            $userModel = new User();
            $userData = $userModel->findById($_SESSION['user']['id']);
            $this->userName = $userData['name'] ?? '';
        }
    }

    protected function render(string $view, array $data = []): void
    {
        $data['name'] = $this->userName;
        $data['user'] = $_SESSION['user'] ?? null;

		extract($data);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View '$viewPath' not found.");
        }

        ob_start();
        require_once $viewPath;
        $content = ob_get_clean();

        if (!empty($_SESSION['user'])) {
            $layoutPath = __DIR__ . '/../Views/layouts/userLayout.php';
        } else {
            $layoutPath = __DIR__ . '/../Views/layouts/main.php';
        }

        if (!file_exists($layoutPath)) {
            die("Layout '$layoutPath' not found.");
        }

        require_once $layoutPath;
    }
}



