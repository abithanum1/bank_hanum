<?php
require 'koneksi.php';

// Validasi apakah form sudah disubmit
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Ambil data dari form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validasi input (tidak kosong)
    if (empty($username) || empty($password)) {
        echo "Username atau Password tidak boleh kosong!";
        exit;
    }

    // Hash password sebelum menyimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk insert data ke tabel registrasi
    $query_sql = "INSERT INTO tbl_regist (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query_sql);

    if ($stmt) {
        // Bind parameter untuk mencegah SQL injection
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            echo "Registrasi berhasil. Silakan login.";
            echo "<br><a href='index.html'>Login</a>";
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
	<style>
	body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
	}

	.container {
		background-color: #708090;
		padding: 20px;
		border-radius: 10px;
		width: 300px;
		text-align: center;
		color: white;
	}

	.form-container {
		background-color: white;
		padding: 20px;
		border-radius: 8px;
		color: black;
	}

	.form-container h2 {
		margin-top: 0;
		padding: 20px;
	}

	.input-group {
		margin-bottom: 15px;
	}

	.input-group label {
		display: block;
		font-weight: bold;
	}

	.input-group input {
		width: 75%; /* Make input fields full width */
		padding: 10px;
		margin-top: 5px;
		border-radius: 4px;
		border: 1px solid #ccc;
	}

	.regist-button {
		width: 100%;
		padding: 10px;
		background-color: #05545b;
		color: white;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		font-size: 16px;
	}

	.regist-button:hover {
		background-color: #002244;
	}

	.links {
		margin-top: 10px;
		font-size: 14px;
	}

	.links a {
		color: #003366;
		text-decoration: none;
	}

	.register-link {
		color: red;
		padding: 2px 5px;
	}
	</style>
</head>
<body>

<div class="container">
	<img src="BNI_putih.jpg" alt="Logo BNI" class="logo" width="300" height="120" style="background-color: whitesmoke;">
    <div class="form-container">
        <h2>Daftar Akun</h2>
		<form action="register.php" method="post">
		<form action="doneregister.html" method="post">
		<div class="input-group">
            <label for="username">Nama</label>
            <input type="nama" id="nama" name="nama" required>
        </div>
        <div class="input-group">
            <label for="username">E-mail/Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button class="regist-button">Daftar Sekarang</button>
        <div class="links">
            
        </div>
		</form></form>
    </div>
</div>

</body>
</html>
