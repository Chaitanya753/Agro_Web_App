<?php
session_start();
include("db_connection.php");

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);

    if (!empty($name) && !empty($email) && !empty($password) && !empty($phone) && !empty($location)) {

        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $error = "Email already registered!";
        } else {

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, location, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $location);

            if ($stmt->execute()) {
                $message = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }

            $stmt->close();
        }

        $checkStmt->close();

    } else {
        $error = "Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration | Agro-Web-App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       body {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                url('images/farmer.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-card {
    width: 450px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.95);
}

    </style>
</head>

<body>

<div class="card shadow-lg p-4 register-card">
    <h3 class="text-center text-success mb-4">🌾Farmer Registration</h3>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Register</button>

        <div class="text-center mt-3">
            <a href="user_login.php">Already have an account? Login</a>
        </div>

        <div class="text-center mt-2">
            <a href="index.php">Back to Home</a>
        </div>

    </form>
</div>

</body>
</html>
