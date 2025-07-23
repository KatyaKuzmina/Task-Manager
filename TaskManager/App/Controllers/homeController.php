<?php
require_once __DIR__ . '/../Core/BaseController.php';
class HomeController extends BaseController
{
    public function index() {
        $title = "welcome to the system";

        ob_start();
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/main.php';
    }
}

