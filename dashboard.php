<!DOCTYPE html>
<html>
<head>
    <title>LOGIN BANK BNI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        header {
            padding: 20px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 20px;
            background-color: #05545b;
        }

        nav ul li a:hover {
            background-color: #044248;
        }

        section {
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            text-align: center;
        }

        .btn-primary {
            background-color: #05545b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #044248;
        }

        .table thead th {
            background-color: #05545b;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bank_baru";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['transfer'])) {
        $norek = $_POST['norek'];
        $jumlah = $_POST['jumlah'];
        $password = $_POST['password'];

        $validPassword = "password123";
        if ($password !== $validPassword) {
            echo "<script>alert('Password salah. Transaksi gagal.');</script>";
        } else {
            $result = $conn->query("SELECT saldo_akhir FROM riwayat_transaksi ORDER BY id_transaksi DESC LIMIT 1");
            $saldoAkhir = $result->num_rows > 0 ? $result->fetch_assoc()['saldo_akhir'] : 0;

            $saldoBaru = $saldoAkhir - $jumlah;

            $sql = "INSERT INTO riwayat_transaksi (jenis_transaksi, tanggal_transaksi, keterangan, tipe, nominal, saldo_akhir)
                    VALUES ('Transfer', CURDATE(), 'Transfer ke $norek', 'D', $jumlah, $saldoBaru)";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Gagal menambahkan transaksi: " . $conn->error . "');</script>";
            }
        }
    }

    $result = $conn->query("SELECT * FROM riwayat_transaksi ORDER BY tanggal_transaksi DESC");
    ?>

    <header>
        <img src="BNI_lagi.png" alt="Logo BNI" class="img-fluid">
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="#Riwayat-Transaksi">Riwayat Transaksi</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#formulir-transfer">Formulir Transfer</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#tentang-kami">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#hubungi-kami">Hubungi Kami</a></li>
            </ul>
        </nav>
    </header>

    <section id="Riwayat-Transaksi">
        <h2 class="text-center">Riwayat Transaksi</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Jenis Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                        <th>Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['jenis_transaksi']}</td>
                                    <td>{$row['tanggal_transaksi']}</td>
                                    <td>{$row['keterangan']}</td>
                                    <td>{$row['tipe']}</td>
                                    <td>" . number_format($row['nominal'], 2, ',', '.') . "</td>
                                    <td>" . number_format($row['saldo_akhir'], 2, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data transaksi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="formulir-transfer">
        <h2 class="text-center">Formulir Transfer</h2>
        <form method="POST" action="" class="p-3 bg-light rounded">
            <div class="mb-3">
                <label for="norek" class="form-label">Rekening Tujuan:</label>
                <input type="text" id="norek" name="norek" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Transaksi:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="transfer" class="btn btn-primary">Transfer</button>
        </form>
    </section>

    <section id="tentang-kami" class="mt-5">
        <h2 class="text-center">Tentang Kami</h2>
        <p class="text-center">Dengan jaringan yang luas dan layanan yang inovatif, BNI hadir untuk memenuhi segala kebutuhan perbankan Anda.</p>
        <p class="text-justify">Sebagai bank tertua di Indonesia, BNI telah berkontribusi dalam membangun perekonomian negara sejak tahun 1946. Seiring berjalannya waktu, BNI terus bertransformasi menjadi bank modern yang senantiasa menghadirkan inovasi dalam produk dan layanannya. Dengan jaringan yang luas dan didukung oleh teknologi terkini, BNI berkomitmen untuk menjadi mitra terpercaya bagi nasabah dalam mencapai tujuan finansial.</p>
        <img src="BNI_lagi.PNG" alt="Logo Bank" class="d-block mx-auto">
    </section>

    <section id="hubungi-kami" class="mt-5">
        <h2 class="text-center">Hubungi Kami</h2>
        <p class="text-center">Ada pertanyaan atau kendala pada transaksi Anda? Jangan ragu untuk menghubungi kami melalui formulir di bawah ini.</p>
        <form class="p-3 bg-light rounded">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kendala" class="form-label">Kendala:</label>
                <input type="text" id="kendala" name="kendala" class="form-control" required>
            </div>
            <button type="submit">Kirim</button>
            <footer>
        <div class="text-center">
            <a href="index.html" class="btn btn-secondary">Logout</a>
        </div>
    </footer>

