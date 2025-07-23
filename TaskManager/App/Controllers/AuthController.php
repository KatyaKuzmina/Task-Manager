<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/BaseController.php';

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        ob_start();
        require_once __DIR__ . '/../Views/auth/login.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/main.php';
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../Models/UserModel.php';
        $userModel = new User();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            header('Location: /TaskManager/public/dashboard');
            exit;
        } else {
            $error = 'Wrong email or password';

            ob_start();
            require_once __DIR__ . '/../Views/auth/login.php';
            $content = ob_get_clean();

            require_once __DIR__ . '/../Views/layouts/main.php';
        }
    }


    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: /TaskManager/public/home');
        exit;
    }

    public function showRegisterForm()
    {
        ob_start();
        require_once __DIR__ . '/../Views/auth/register.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/main.php';
    }

    public function register()
    {
        header('Content-Type: application/json');

        require_once __DIR__ . '/../Models/UserModel.php';

        $name = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password-conf'] ?? '';

        if (!$name || !$email || !$password) {
            echo json_encode(['success' => false, 'error' => 'All fields are required.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
            return;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            echo json_encode(['success' => false, 'error' => 'Email already exists.']);
            return;
        }

        if ($password !== $passwordConfirm) {
            echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userModel->create($name, $email, $hashedPassword);

        $newUser = $userModel->findByEmail($email);

        $_SESSION['user'] = [
            'id' => $newUser['id'],
            'name' => $newUser['name'],
            'email' => $newUser['email']
        ];

        echo json_encode(['success' => true]);
    }

}
