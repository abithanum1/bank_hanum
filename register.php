<?php
require 'koneksi.php';

if (isset($_POST["nama"]) && isset($_POST["username"]) && isset($_POST["password"])) {
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cek apakah username sudah ada di database
    $check_sql = "SELECT * FROM tbl_regist WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username sudah digunakan, silakan pilih username lain.";
    } else {
        // Jika username belum ada, simpan data baru
        $query_sql = "INSERT INTO tbl_regist (nama, username, password)
                      VALUES ('$nama', '$username', '$password')";

        if (mysqli_query($conn, $query_sql)) {
            header("Location: doneregister.html");
        } else {
            echo "Pendaftaran Gagal: " . mysqli_error($conn);
        }
    }
} else {
    echo "Form tidak lengkap.";
}
?>
