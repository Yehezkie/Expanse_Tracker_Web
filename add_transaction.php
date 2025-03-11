<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $sql = "INSERT INTO transactions (type, amount, description, date) VALUES (:type, :amount, :description, :date)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':type' => $type,
        ':amount' => $amount,
        ':description' => $description,
        ':date' => $date
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title text-center mb-0">Tambah Transaksi</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <!-- Jenis Transaksi -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Jenis Transaksi</label>
                                <select class="form-select" name="type" id="type" required>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="amount" id="amount" step="0.01" required>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" name="description" id="description" required>
                            </div>

                            <!-- Tanggal -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="date" id="date" required>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opsional, jika menggunakan komponen interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>