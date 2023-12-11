<?php
include 'koneksi.php';

function tambahDataTesTertulis($subkriteria, $bobot)
{
    global $koneksi;
    $query = "INSERT INTO Subkriteria_Nilai_Tertulis (Subkriteria, Bobot) VALUES ('$subkriteria', $bobot)";
    return mysqli_query($koneksi, $query);
}

function ambilDataTesTertulis()
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_Tertulis";
    $result = mysqli_query($koneksi, $query);
    $dataTesTertulis = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataTesTertulis[] = $row;
    }

    return $dataTesTertulis;
}

function ambilDataTesTertulisBySubkriteria($subkriteria)
{
    global $koneksi;
    $query = "SELECT * FROM Subkriteria_Nilai_Tertulis WHERE Subkriteria='$subkriteria'";
    $result = mysqli_query($koneksi, $query);

    return mysqli_fetch_assoc($result);
}

function updateDataTesTertulis($subkriteria, $bobot)
{
    global $koneksi;
    $query = "UPDATE Subkriteria_Nilai_Tertulis SET Bobot=$bobot WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

function hapusDataTesTertulis($subkriteria)
{
    global $koneksi;
    $query = "DELETE FROM Subkriteria_Nilai_Tertulis WHERE Subkriteria='$subkriteria'";
    return mysqli_query($koneksi, $query);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $subkriteria = $_POST['subkriteria'];
        $bobot = $_POST['bobot'];

        if (tambahDataTesTertulis($subkriteria, $bobot)) {
            header("Location: tes_tulis.php");
        } else {
            echo "Gagal menambahkan data tes tertulis.";
        }
    } elseif (isset($_POST['update'])) {
        $subkriteria = $_GET['subkriteria'];
        $bobot = $_POST['bobot'];

        if (updateDataTesTertulis($subkriteria, $bobot)) {
            header("Location: tes_tulis.php");
        } else {
            echo "Gagal update data tes tertulis.";
        }
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'update' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];
        $dataTesTertulis = ambilDataTesTertulisBySubkriteria($subkriteria);
    } elseif ($aksi == 'hapus' && isset($_GET['subkriteria'])) {
        $subkriteria = $_GET['subkriteria'];

        if (hapusDataTesTertulis($subkriteria)) {
            header("Location: tes_tulis.php");
        } else {
            echo "Gagal menghapus data tes tertulis.";
        }
    }
}

$dataTesTertulis = ambilDataTesTertulis();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Tes Tertulis</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Tes Tertulis</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah Data Tes Tertulis Form -->
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

                        <!-- Tabel Data Tes Tertulis -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Subkriteria</th>
                                    <th>Bobot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataTesTertulis as $tesTertulis) : ?>
                                    <tr>
                                        <td><?= $tesTertulis['Subkriteria']; ?></td>
                                        <td><?= $tesTertulis['Bobot']; ?></td>
                                        <td>
                                            <!-- Update Form -->
                                            <form method="post" action="?aksi=update&subkriteria=<?= $tesTertulis['Subkriteria']; ?>" style="display: inline;">
                                                <input type="hidden" name="update" value="1">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="bobot">Bobot:</label>
                                                        <input type="text" name="bobot" class="form-control" value="<?= $tesTertulis['Bobot']; ?>" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-sm">Update</button>
                                            </form>

                                            <a href="?aksi=hapus&subkriteria=<?= $tesTertulis['Subkriteria']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data tes tertulis ini?')">Hapus</a>
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





























