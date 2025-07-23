<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $title ?? 'Task Manager' ?></title>
    <link rel="stylesheet" href="/TaskManager/public/css/main.css">
</head>
<body>
<header>
    <?php $basePath = '/TaskManager/public'; ?>

    <div class="header-left">
        <a href="<?= $basePath ?>/">
            <img src="<?= $basePath ?>/images/logo_4.png" alt="Task Manager" class="logo-img">
        </a>

        <div class="header-right">
            <a class="active" href="<?= $basePath ?>/">Home</a>
            <a href="<?= $basePath ?>/login">Login</a>
            <a href="<?= $basePath ?>/register">Register</a>
        </div>
    </div>
    <hr class="header-line" />


</header>

<main>
    <?php if (isset($content)) echo $content; ?>
</main>

<footer>
</footer>
</body>
</html>
