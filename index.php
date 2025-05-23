<?php
session_start();

// Redirect logged-in users to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: src/hero/home.php");
    exit();
}

// Include the database connection
include('./backend/db.php');

// Initialize error message
$error_message = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Securely check if user exists
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ✅ Secure password verification
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullName'] = $user['fullName']; // optional if you want to use name

            header("Location: src/hero/home.php");
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url('assets/Water.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .branding {
            position: absolute;
            top: 50px;
            left: 60px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .branding img {
            width: 130px;
            height: auto;
        }

        .branding-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .branding-text h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1357A0;
            font-family: 'Changa One', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin: 0;
        }

        .branding-text p {
            font-size: 16px;
            font-weight: bold;
            font-family: 'Poppins';
            color: #2A166F;
            margin: 5px 0 0;
        }

        .login-container {
            position: absolute;
            right: 250px;
            top: 50%;
            transform: translateY(-48%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 400px;
        }

        .login-section {
            width: 350px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 16px 32px -8px rgba(12, 12, 13, 0.40);
            text-align: center;
        }

        .login-section h2 {
            font-size: 28px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #1F3C88;
            text-transform: uppercase;
            margin-bottom: 5px;
            transform: translateY(-25%);
            line-height: 1.2;
        }

        .login-section p {
            color: #ADB5BD;
            font-size: 16px;
            transform: translateY(-30%);
        }

        .input-group {
            width: 85%;
            background: #EEF1F5;
            border-radius: 10px;
            border: 1px solid #E9ECEF;
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 15px 0;
            transform: translateX(5%);
        }

        .input-group input {
            border: none;
            background: none;
            outline: none;
            padding: 8px;
            width: 100%;
            font-size: 14px;
        }

        .icon {
            font-size: 20px;
            color: #777;
            margin-right: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }

        .forgot-password {
            color: #1F3C88;
            font-size: 14px;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            text-align: left;
            transform: translateX(8%);
            width: 100%;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            background: #4177B2;
            color: white;
            padding: 12px;
            border: none;
            width: 40%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 50px;
        }

        .login-btn:hover {
            background: #163372;
        }

        @media (max-width: 1024px) {
            .branding {
                left: 20px;
                top: 20px;
            }

            .login-container {
                position: static;
                margin-top: 50px;
                transform: none;
            }

            .login-section {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="branding">
        <img src="assets/logo.png" alt="Iligan City Waterworks System">
        <div class="branding-text">
            <h1>ILIGAN CITY WATERWORKS SYSTEM</h1>
            <p>“Water is Life. Conserving it now, will save the future.”</p>
        </div>
    </div>

    <div class="login-container">
        <div class="login-section">
            <h2>PERSONNEL MANAGEMENT SYSTEM</h2>
            <p>Sign in to start your session</p>

            <form action="index.php" method="POST">
                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="username" name="username" placeholder="username" required>
                </div>

                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
