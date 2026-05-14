<?php
// File: register.php
require_once 'includes/header.php';

// If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: " . $_SESSION['role'] . "/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Storing as plain text, as requested.
    $role = $_POST['role'];

    // Using prepared statements to prevent SQL injection
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $error = "An account with this email already exists.";
    } else {
        // Insert new user
        $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss", $username, $email, $password, $role);
        
        if ($insert_stmt->execute()) {
            $user_id = $conn->insert_id;
            
            // If the role is hospital, add to hospitals table as well
            if ($role === 'hospital') {
                $hospital_name = $_POST['hospital_name'];
                $address = $_POST['address'];
                $h_stmt = $conn->prepare("INSERT INTO hospitals (user_id, name, address) VALUES (?, ?, ?)");
                $h_stmt->bind_param("iss", $user_id, $hospital_name, $address);
                $h_stmt->execute();
                $h_stmt->close();
            }
            
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Error during registration. Please try again.";
        }
        $insert_stmt->close();
    }
    $check_stmt->close();
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
        padding: 2rem 0;
    }
    .register-card {
        max-width: 500px;
        width: 100%;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <div class="card shadow-lg register-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill h1 text-success"></i>
                        <h2 class="mt-2">Create an Account</h2>
                        <p class="text-muted">Join the E-Vaccination System</p>
                    </div>

                    <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
                    <?php if (isset($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

                    <form action="register.php" method="POST" id="register-form">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="role" name="role" required>
                                <option value="parent">Parent</option>
                                <option value="hospital">Hospital</option>
                                <option value="admin">Admin</option>
                            </select>
                            <label for="role">I am a:</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        
                        <!-- Hospital specific fields -->
                        <div id="hospital-fields" style="display:none;">
                            <hr>
                             <p class="text-muted text-center">Please provide hospital details</p>
                             <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="hospital_name" name="hospital_name" placeholder="Hospital Name">
                                <label for="hospital_name">Hospital Name</label>
                            </div>
                             <div class="form-floating mb-3">
                                <textarea class="form-control" id="address" name="address" placeholder="Hospital Address" style="height: 100px"></textarea>
                                <label for="address">Hospital Address</label>
                            </div>
                            <hr>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg">Register</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">Already have an account? <a href="login.php">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show hospital fields only when 'hospital' role is selected
document.getElementById('role').addEventListener('change', function() {
    var hospitalFields = document.getElementById('hospital-fields');
    var hospitalName = document.getElementById('hospital_name');
    var hospitalAddress = document.getElementById('address');
    
    if (this.value === 'hospital') {
        hospitalFields.style.display = 'block';
        hospitalName.required = true;
        hospitalAddress.required = true;
    } else {
        hospitalFields.style.display = 'none';
        hospitalName.required = false;
        hospitalAddress.required = false;
    }
});
</script>

<?php
// We don't include the standard footer here because the layout is different
?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
