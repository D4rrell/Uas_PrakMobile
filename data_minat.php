<?php
include 'koneksi.php';

// Fungsi untuk menambahkan data minat
function tambahDataMinat($subkriteria, $bobot)
{
    global $koneksi;
    $query = "INSERT INTO Subkriteria_Minat (Subkriteria, Bobot) VALUES ('$subkriteria', $bobot)";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk mengambil data minat
function ambilDataMinat()
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Minat";
    $result = mysqli_query($koneksi, $query);
    $dataMinat = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dataMinat[] = $row;
        }
    }

    return $dataMinat;
}

// Fungsi untuk mengambil data minat berdasarkan subkriteria
function ambilDataMinatBySubkriteria($subkriteria)
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Minat WHERE Subkriteria='$subkriteria'";
    $result = mysqli_query($koneksi, $query);

    return mysqli_fetch_assoc($result);
}

// Fungsi untuk mengupdate data minat
function updateDataMinat($subkriteria, $bobot)
{
    global $koneksi;
    $query = "UPDATE Subkriteria_Minat SET Bobot=$bobot WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk menghapus data minat
function hapusDataMinat($subkriteria)
{
    global $koneksi;
    $query = "DELETE FROM Subkriteria_Minat WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

// Handle operasi CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $subkriteria = $_POST['subkriteria'];
        $bobot = $_POST['bobot'];

        // Validasi data
        if (empty($subkriteria) || empty($bobot)) {
            echo "Semua kolom harus diisi.";
        } else {
            if (tambahDataMinat($subkriteria, $bobot)) {
                header("Location: data_minat.php");
            } else {
                echo "Gagal menambahkan data minat.";
            }
        }
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'update' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];
        $dataMinat = ambilDataMinatBySubkriteria($subkriteria);

        // Tampilkan formulir untuk update data
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Data Minat</title>
            <!-- Bootstrap CSS -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h2 class="text-center mb-0">Update Data Minat</h2>
                            </div>
                            <div class="card-body">
                                <form method="post" action="" class="mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="subkriteria">Subkriteria:</label>
                                            <input type="text" name="subkriteria_update" class="form-control" value="' . $dataMinat['Subkriteria'] . '" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bobot">Bobot:</label>
                                            <input type="text" name="bobot_update" class="form-control" value="' . $dataMinat['Bobot'] . '" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                                </form>
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
        ';

        if (isset($_POST['update'])) {
            $bobotUpdate = $_POST['bobot_update'];

            if (updateDataMinat($subkriteria, $bobotUpdate)) {
                header("Location: data_minat.php");
            } else {
                echo "Gagal update data minat.";
            }
        }
    } elseif ($aksi == 'hapus' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];

        if (hapusDataMinat($subkriteria)) {
            header("Location: data_minat.php");
        } else {
            echo "Gagal menghapus data minat.";
        }
    }
}

// Tampilkan data minat
$dataMinat = ambilDataMinat();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Minat</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Minat</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah Data Minat Form -->
                        <form method="post" action="" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="subkriteria">Subkriteria:</label>
                                    <input type="text" name="subkriteria" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bobot">Bobot:</label>
                                    <input type="text" name="bobot" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                        </form>

                        <!-- Tabel Data Minat -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Subkriteria</th>
                                    <th>Bobot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataMinat)) : ?>
                                    <?php foreach ($dataMinat as $minat) : ?>
                                        <tr>
                                            <td><?= $minat['Subkriteria']; ?></td>
                                            <td><?= $minat['Bobot']; ?></td>
                                            <td>
                                                <a href="?aksi=update&subkriteria=<?= $minat['Subkriteria']; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="?aksi=hapus&subkriteria=<?= $minat['Subkriteria']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data minat ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data minat.</td>
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
