<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Discover Coffee House</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f3f1ee;
    }

    .hero-section {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: left;
      background-image: url('http://localhost/Project%20Hadirah/background%203.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      color: white;
      padding: 20px;
    }

    .content {
      max-width: 600px;
      background: rgba(0, 0, 0, 0.7);
      padding: 20px;
      border-radius: 8px;
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 150px; /* Adjust logo size */
      height: auto;
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
      text-align: center;
    }

    p {
      font-size: 2em;
      line-height: 1.6;
      margin-bottom: 60px;
      text-align: center;
    }

    .buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn {
      text-decoration: none;
      padding: 10px 20px;
      font-size: 1em;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .btn.primary {
      background-color: #ff9f43;
      color: white;
    }

    .btn.secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn:hover {
      opacity: 0.8;
    }
  </style>
</head>
<body>
  <div class="hero-section">
    <div class="content">
      <h1>WELCOME TO CAFE</h1>
      <p>
        COFFEE PANDADOLL
      </p>
      <div class="buttons">
        <a href="Cafe Coffee Pandadoll.php" class="btn primary">COFFEE SHOP</a>
        <a href="login.admin.php" class="btn secondary">ADMIN</a> <!-- Link ke Admin Page -->
      </div>
    </div>
  </div>
</body>
</html>
