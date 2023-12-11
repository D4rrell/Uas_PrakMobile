<?php
include 'koneksi.php';

function tambahDataTesLisan($subkriteria, $bobot)
{
    global $koneksi;
    $query = "INSERT INTO Subkriteria_Nilai_Lisan (Subkriteria, Bobot) VALUES ('$subkriteria', $bobot)";
    return mysqli_query($koneksi, $query);
}

function ambilDataTesLisan()
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_Lisan";
    $result = mysqli_query($koneksi, $query);
    $dataTesLisan = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataTesLisan[] = $row;
    }

    return $dataTesLisan;
}

function ambilDataTesLisanBySubkriteria($subkriteria)
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_Lisan WHERE Subkriteria='$subkriteria'";
    $result = mysqli_query($koneksi, $query);

    return mysqli_fetch_assoc($result);
}

function updateDataTesLisan($subkriteria, $bobot)
{
    global $koneksi;
    $query = "UPDATE Subkriteria_Nilai_Lisan SET Bobot=$bobot WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

function hapusDataTesLisan($subkriteria)
{
    global $koneksi;
    $query = "DELETE FROM Subkriteria_Nilai_Lisan WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $subkriteria = $_POST['subkriteria'];
        $bobot = $_POST['bobot'];

        if (tambahDataTesLisan($subkriteria, $bobot)) {
            header("Location: tes_lisan.php");
        } else {
            echo "Gagal menambahkan data tes lisan.";
        }
    } elseif (isset($_POST['update'])) {
        $subkriteria = $_GET['subkriteria'];
        $bobot = $_POST['bobot'];

        if (updateDataTesLisan($subkriteria, $bobot)) {
            header("Location: tes_lisan.php");
        } else {
            echo "Gagal update data tes lisan.";
        }
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'update' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];
        $dataTesLisan = ambilDataTesLisanBySubkriteria($subkriteria);
    } elseif ($aksi == 'hapus' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];

        if (hapusDataTesLisan($subkriteria)) {
            header("Location: tes_lisan.php");
        } else {
            echo "Gagal menghapus data tes lisan.";
        }
    }
}

$dataTesLisan = ambilDataTesLisan();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Tes Lisan</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Tes Lisan</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah Data Tes Lisan Form -->
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

                        <!-- Tabel Data Tes Lisan -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Subkriteria</th>
                                    <th>Bobot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataTesLisan as $tesLisan) : ?>
                                    <tr>
                                        <td><?= $tesLisan['Subkriteria']; ?></td>
                                        <td><?= $tesLisan['Bobot']; ?></td>
                                        <td>
                                            <!-- Update Form -->
                                            <form method="post" action="?aksi=update&subkriteria=<?= $tesLisan['Subkriteria']; ?>" style="display: inline;">
                                                <input type="hidden" name="update" value="1">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="bobot">Bobot:</label>
                                                        <input type="text" name="bobot" class="form-control" value="<?= $tesLisan['Bobot']; ?>" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-sm">Update</button>
                                            </form>

                                            <a href="?aksi=hapus&subkriteria=<?= $tesLisan['Subkriteria']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data tes lisan ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
