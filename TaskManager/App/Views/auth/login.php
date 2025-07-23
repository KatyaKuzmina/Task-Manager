<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="/TaskManager/public/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<div class="container">
    <h1>Login</h1>

    <div class="login-form">
        <form action="/TaskManager/public/login" method="post">


            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="email" name="email" placeholder="E.g. johndoe@email.com" required><div>
            </div>

            <div class="form-group-pswd">
                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <i class="fa-solid fa-eye-slash" id="togglePassword"></i>
            </div>

            <div class="remember-chkbox">
                <div>
                   <input type="checkbox" id="remember-auth" name="remember-box">
                   <label>Remember me</label>
                </div>

            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="register-link">
                <p>Not registered yet? <a href='/TaskManager/public/register'>Create an account</a></p>
            </div>

        </form>



    </div>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const isPassword = password.type === 'password';
        password.type = isPassword ? 'text' : 'password';

        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
    });
</script>


<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</body>
</html>

