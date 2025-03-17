<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWD Online Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            text-align: center;
        }

        .top-container, .bottom-container {
            width: 100%;
            background: linear-gradient(to right, #002b5b, #004080);
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: white;
        }

        .top-container img {
            height: 80px;
            position: absolute;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            align-items: center;
        }

        .hero {
            text-align: center;
        }

        .hero h1 {
            font-size: 32px;
            font-weight: bold;
            color: white;
        }

        .hero p {
            font-size: 18px;
            color: white;
        }

        .container {
            max-width: 1000px;
            padding: 50px;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            margin-top: -30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #002b5b;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 20px;
            width: 220px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background: #004080;
        }

        .requirements-btn {
            display: inline-block;
            padding: 15px 30px;
            background: #ffc107;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
            margin-top: 30px;
        }

        .requirements-btn:hover {
            background: #e0a800;
        }

        .bottom-container {
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .button-container {
                flex-direction: column;
                gap: 15px;
            }
            .btn {
                width: 100%;
            }
            .top-container {
                flex-direction: column;
                height: auto;
                padding: 20px;
            }
            .top-container img {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="top-container">
        <div class="logo-container">
            <img src="pwd_logo.png" alt="PWD Logo">
            <div class="hero">
                <h1>Welcome to PWD Online Application</h1>
                <p>Easily apply for your PWD ID online with our user-friendly system.</p>
            </div>
            <img src="city_logo.png" alt="City Logo">
        </div>
    </div>
    
    <div class="container">
        <div class="button-container">
            <a href="register.php" class="btn">📝 New Registration</a>
            <a href="renew.php" class="btn">🔄 Renew ID</a>
            <a href="status.php" class="btn">📌 Check Status</a>
            <a href="requirements.html" class="requirements-btn">📂 View Requirements</a>
        </div>
    </div>
    
    <div class="bottom-container"></div>
</body>
</html>
