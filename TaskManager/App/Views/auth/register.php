<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="/TaskManager/public/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<div class="container">
    <h1>Create an account</h1>

    <div class="login-form">
        <form id="registerForm">
            <div class="form-group">
                <span class="line-with-text">create your account</span>
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required><div>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="email" name="email" placeholder="E.g. johndoe@email.com" required><div>
            </div>

            <div class="form-group-pswd">
                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <i class="fa-solid fa-eye-slash toggle-password" data-target="password"></i>
            </div>

            <div class="form-group-pswd">
                <label>Confirm password:</label>
                <input type="password" id="password-conf" name="password-conf" placeholder="Enter your password" required>
                <i class="fa-solid fa-eye-slash toggle-password" data-target="password-conf"></i>
            </div>

            <button type="submit" class="register-btn">Sign up</button>

            <div class="login-link">
                <p>Already have an account? <a href='/TaskManager/public/login'>Login</a></p>
            </div>

            <div id="error-message" style="color: red; margin-top: 10px;"></div>

        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.dataset.target;
            const input = document.getElementById(targetId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            toggle.classList.toggle('fa-eye');
            toggle.classList.toggle('fa-eye-slash');
        });
    });


    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('/TaskManager/public/register', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                const errorDiv = document.getElementById('error-message');
                if (data.success) {
                    window.location.href = '/TaskManager/public/dashboard';
                } else {
                    errorDiv.textContent = data.error || 'Something went wrong';
                }
            })
            .catch(err => {
                console.error('Error submitting form:', err);
                document.getElementById('error-message').textContent = 'Server error. Try again.';
            });
    });
</script>

</body>
</html>

