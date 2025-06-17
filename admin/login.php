<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Koneksi database
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "Web_jurusan"; 

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses login jika ada POST
$error = ''; // Inisialisasi pesan error
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $row['username'];
                header("Location: ../Dashboard_admin/admin.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }

        $stmt->close();
    } else {
        $error = "Kesalahan server: gagal menyiapkan statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      background-color: #080710;
      font-family: 'Poppins', sans-serif;
    }
    .background {
      width: 430px;
      height: 520px;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }
    .shape {
      height: 200px;
      width: 200px;
      position: absolute;
      border-radius: 50%;
    }
    .shape:first-child {
      background: linear-gradient(#56021f,rgb(121, 104, 29));
      top: -80px;
      left: -80px;
    }
    .shape:last-child {
      background: linear-gradient(to right, #56021f,rgb(148, 63, 6));
      bottom: -80px;
      right: -30px;
    }
    form {
      height: 520px;
      width: 400px;
      background-color: rgba(255,255,255,0.13);
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border-radius: 10px;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255,255,255,0.1);
      box-shadow: 0 0 40px rgba(8,7,16,0.6);
      padding: 50px 35px;
    }
    form * {
      color: #fff;
      letter-spacing: 0.5px;
      border: none;
      outline: none;
    }
    form h3 {
      font-size: 32px;
      font-weight: 500;
      text-align: center;
    }
    label {
      display: block;
      margin-top: 30px;
      font-size: 16px;
      font-weight: 500;
    }
    input {
      display: block;
      width: 100%;
      height: 50px;
      background-color: rgba(255,255,255,0.07);
      border-radius: 3px;
      padding: 0 10px;
      margin-top: 8px;
      font-size: 14px;
    }
    ::placeholder {
      color:rgb(174, 174, 174);
    }
    button {
      margin-top: 40px;
      width: 100%;
      padding: 15px 0;
      background-color:rgba(86, 2, 31, 0.82);
      color: #fff;
      font-size: 18px;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
    }

    .alert-error {
      background-color: rgba(255, 0, 0, 0.46);
      padding: 10px;
      color: #fff;
      margin-bottom: 15px;
      text-align: center;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <form method="POST">
    <h3>Login Admin</h3>

    <?php if (!empty($error)) echo '<div class="alert-error">' . $error . '</div>'; ?>

    <label for="username">Username</label>
    <input type="text" name="username" placeholder="Username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Password" id="password" required>

    <button type="submit">Log In</button>

  </form>
</body>
</html>