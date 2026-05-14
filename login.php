<?php
// File: login.php
require_once 'includes/header.php';

// If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: " . $_SESSION['role'] . "/");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password (plain text comparison, as requested)
        // For a real application, ALWAYS use password_verify() with hashed passwords.
        if ($password === $user['password']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the respective dashboard
            header("Location: " . $user['role'] . "/");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
    $stmt->close();
}
?>
<!-- Add Bootstrap Icons CDN to your header.php or here -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .login-card {
        max-width: 450px;
        width: 100%;
    }
    .form-control-lg {
        height: calc(1.5em + 1rem + 2px);
        padding: .5rem 1rem;
        font-size: 1.25rem;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-lg login-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-check-fill h1 text-primary"></i>
                        <h2 class="mt-2">E-Vaccination System</h2>
                        <p class="text-muted">Please sign in to continue</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">Don't have an account? <a href="register.php">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// We don't include the standard footer here because the layout is different
// from the main application dashboard pages.
?>
<!-- jQuery and Bootstrap JS should be loaded if not already in header -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
