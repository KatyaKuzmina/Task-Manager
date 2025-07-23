<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $title ?? 'Task Manager' ?></title>
    <link rel="stylesheet" href="/TaskManager/public/css/userPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/TaskManager/public/task-form.js"></script>

</head>
<body>
<header>
</header>

<main>
    <?php $basePath = '/TaskManager/public'; ?>
    <div class="container">

        <div class="menu-left">
            <div class="logo">
                <a href="<?= $basePath ?>/">
                    <img src="<?= $basePath ?>/images/logo_4.png" alt="Task Manager" class="logo-img">
                </a>
                <p>Hi! Welcome back, <?= htmlspecialchars($user['name'] ?? '') ?></p>

            </div>

            <div class="menu">
                <a href="?date=<?= date('Y-m-d') ?>">
                    <i class="fa fa-calendar-o"></i>
                    Today
                </a>

                <div class="create-task">
                        <a href="#" class="create-task" id="open-create-task">
                            <i class="fa fa-plus"></i>
                            Create task
                        </a>
                </div>
            </div>

            <div class="settings">
                <a href="/TaskManager/public/logout">Log out
                <i class="fa fa-sign-out"></i>
                </a>
            </div>

        </div>

        <div class="main-content">
            <?php if (isset($content)) echo $content; ?>
        </div>

    </div>
</main>

<footer>
</footer>
</body>
</html>

<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>