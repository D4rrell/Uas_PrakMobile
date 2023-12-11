<?php
include 'koneksi.php';

function tambahDataNilaiUS($subkriteria, $bobot)
{
    global $koneksi;
    $query = "INSERT INTO Subkriteria_Nilai_US (Subkriteria, Bobot) VALUES ('$subkriteria', $bobot)";
    return mysqli_query($koneksi, $query);
}

function ambilDataNilaiUS()
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_US";
    $result = mysqli_query($koneksi, $query);
    $dataNilaiUS = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataNilaiUS[] = $row;
    }

    return $dataNilaiUS;
}

function ambilDataNilaiUSBySubkriteria($subkriteria)
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_US WHERE Subkriteria='$subkriteria'";
    $result = mysqli_query($koneksi, $query);

    return mysqli_fetch_assoc($result);
}

function updateDataNilaiUS($subkriteria, $bobot)
{
    global $koneksi;
    $query = "UPDATE Subkriteria_Nilai_US SET Bobot=$bobot WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

function hapusDataNilaiUS($subkriteria)
{
    global $koneksi;
    $query = "DELETE FROM Subkriteria_Nilai_US WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $subkriteria = $_POST['subkriteria'];
        $bobot = $_POST['bobot'];

        if (tambahDataNilaiUS($subkriteria, $bobot)) {
            header("Location: nilaius.php");
        } else {
            echo "Gagal menambahkan data nilai US.";
        }
    }

    // Handle update form submission
    if (isset($_POST['update'])) {
        $subkriteriaUpdate = $_POST['subkriteria_update'];
        $bobotUpdate = $_POST['bobot_update'];

        if (updateDataNilaiUS($subkriteriaUpdate, $bobotUpdate)) {
            header("Location: nilaius.php");
        } else {
            echo "Gagal update data nilai US.";
        }
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'update' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];
        $dataNilaiUS = ambilDataNilaiUSBySubkriteria($subkriteria);

        // Tampilkan formulir untuk update data
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Data Nilai US</title>
            <!-- Bootstrap CSS -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h2 class="text-center mb-0">Update Data Nilai US</h2>
                            </div>
                            <div class="card-body">
                                <form method="post" action="" class="mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="subkriteria">Subkriteria:</label>
                                            <input type="text" name="subkriteria_update" class="form-control" value="' . $dataNilaiUS['Subkriteria'] . '" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bobot">Bobot:</label>
                                            <input type="text" name="bobot_update" class="form-control" value="' . $dataNilaiUS['Bobot'] . '" required>
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
    } elseif ($aksi == 'hapus' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];

        if (hapusDataNilaiUS($subkriteria)) {
            header("Location: nilaius.php");
        } else {
            echo "Gagal menghapus data nilai US.";
        }
    }
}

$dataNilaiUS = ambilDataNilaiUS();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Nilai US</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Nilai US</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah Data Nilai US Form -->
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

                        <!-- Tabel Data Nilai US -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Subkriteria</th>
                                    <th>Bobot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataNilaiUS)) : ?>
                                    <?php foreach ($dataNilaiUS as $nilaiUS) : ?>
                                        <tr>
                                            <td><?= $nilaiUS['Subkriteria']; ?></td>
                                            <td><?= $nilaiUS['Bobot']; ?></td>
                                            <td>
                                                <a href="?aksi=update&subkriteria=<?= $nilaiUS['Subkriteria']; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="?aksi=hapus&subkriteria=<?= $nilaiUS['Subkriteria']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data nilai US ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data nilai US.</td>
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

<?php mysqli_close($koneksi); ?>
