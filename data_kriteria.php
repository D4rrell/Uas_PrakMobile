<?php
include 'koneksi.php';

// Fungsi untuk menambahkan kriteria
function tambahKriteria($kode, $kriteria, $bobot)
{
    global $koneksi;
    $query = "INSERT INTO Kriteria (Kode, Kriteria, Bobot_Kriteria) VALUES ('$kode', '$kriteria', $bobot)";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk mengambil data kriteria
function ambilDataKriteria()
{
    global $koneksi;
    $query = "SELECT * FROM Kriteria";
    $result = mysqli_query($koneksi, $query);
    $dataKriteria = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataKriteria[] = $row;
    }

    return $dataKriteria;
}

// Fungsi untuk mengambil data kriteria berdasarkan kode
function ambilDataKriteriaByKode($kode)
{
    global $koneksi;
    $query = "SELECT * FROM Kriteria WHERE Kode = '$kode'";
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($result);
}

// Handle operasi CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $kode = $_POST['kode'];
        $kriteria = $_POST['kriteria'];
        $bobot = $_POST['bobot'];

        // Validasi data
        if (empty($kode) || empty($kriteria) || empty($bobot)) {
            echo "Semua kolom harus diisi.";
        } else {
            if (tambahKriteria($kode, $kriteria, $bobot)) {
                header("Location: kriteria.php");
            } else {
                echo "Gagal menambahkan kriteria.";
            }
        }
    } elseif (isset($_POST['update'])) {
        $kodeUpdate = $_POST['kode_update'];
        $kriteriaUpdate = $_POST['kriteria'];
        $bobotUpdate = $_POST['bobot'];

        // Validasi data
        if (empty($kriteriaUpdate) || empty($bobotUpdate)) {
            echo "Semua kolom harus diisi.";
        } else {
            // Update data kriteria
            $queryUpdate = "UPDATE Kriteria SET Kriteria = '$kriteriaUpdate', Bobot_Kriteria = $bobotUpdate WHERE Kode = '$kodeUpdate'";
            if (mysqli_query($koneksi, $queryUpdate)) {
                header("Location: kriteria.php");
            } else {
                echo "Gagal mengupdate kriteria.";
            }
        }
    }
}

// Tampilkan data kriteria
$dataKriteria = ambilDataKriteria();

// Tampilkan data kriteria berdasarkan kode jika sedang update
$kodeUpdate = isset($_GET['kode']) ? $_GET['kode'] : '';
$dataKriteriaUpdate = [];
if (!empty($kodeUpdate)) {
    $dataKriteriaUpdate = ambilDataKriteriaByKode($kodeUpdate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kriteria</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Kriteria</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah atau Update Kriteria Form -->
                        <form method="post" action="" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="kode">Kode:</label>
                                    <input type="text" name="kode" class="form-control" required value="<?= isset($dataKriteriaUpdate['Kode']) ? $dataKriteriaUpdate['Kode'] : ''; ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="kriteria">Kriteria:</label>
                                    <input type="text" name="kriteria" class="form-control" required value="<?= isset($dataKriteriaUpdate['Kriteria']) ? $dataKriteriaUpdate['Kriteria'] : ''; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bobot">Bobot:</label>
                                    <input type="text" name="bobot" class="form-control" required value="<?= isset($dataKriteriaUpdate['Bobot_Kriteria']) ? $dataKriteriaUpdate['Bobot_Kriteria'] : ''; ?>">
                                </div>
                            </div>
                            <?php if (!empty($kodeUpdate)) : ?>
                                <!-- Hidden input field for kode when updating -->
                                <input type="hidden" name="kode_update" value="<?= $kodeUpdate; ?>">
                                <button type="submit" name="update" class="btn btn-warning">Update</button>
                            <?php else : ?>
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                            <?php endif; ?>
                        </form>

                        <!-- Tabel Data Kriteria -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode</th>
                                    <th>Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataKriteria)) : ?>
                                    <?php foreach ($dataKriteria as $kriteria) : ?>
                                        <tr>
                                            <td><?= $kriteria['Kode']; ?></td>
                                            <td><?= $kriteria['Kriteria']; ?></td>
                                            <td><?= $kriteria['Bobot_Kriteria']; ?></td>
                                            <td>
                                                <a href="?aksi=update&kode=<?= $kriteria['Kode']; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="?aksi=hapus&kode=<?= $kriteria['Kode']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data kriteria.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
if (isset($koneksi)) {
    mysqli_close($koneksi);
}
?>
