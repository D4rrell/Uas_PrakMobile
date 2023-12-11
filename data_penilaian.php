<?php
include 'koneksi.php';

function tambahDataPenilaian($kode, $namaJurusan, $k1, $k2, $k3, $k4)
{
    global $koneksi;
    $query = "INSERT INTO Data_Penilaian (Kode, Nama_Jurusan, K1, K2, K3, K4) VALUES ('$kode', '$namaJurusan', $k1, $k2, $k3, $k4)";
    return mysqli_query($koneksi, $query);
}

function ambilDataPenilaian()
{
    global $koneksi;
    $query = "SELECT * FROM Data_Penilaian";
    $result = mysqli_query($koneksi, $query);
    $dataPenilaian = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataPenilaian[] = $row;
    }

    return $dataPenilaian;
}

function ambilDataPenilaianByKode($kode)
{
    global $koneksi;
    $query = "SELECT * FROM Data_Penilaian WHERE Kode='$kode'";
    $result = mysqli_query($koneksi, $query);

    return mysqli_fetch_assoc($result);
}

function updateDataPenilaian($kode, $namaJurusan, $k1, $k2, $k3, $k4)
{
    global $koneksi;
    $query = "UPDATE Data_Penilaian SET Nama_Jurusan='$namaJurusan', K1=$k1, K2=$k2, K3=$k3, K4=$k4 WHERE Kode='$kode'";
    return mysqli_query($koneksi, $query);
}

function hapusDataPenilaian($kode)
{
    global $koneksi;
    $query = "DELETE FROM Data_Penilaian WHERE Kode='$kode'";
    return mysqli_query($koneksi, $query);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $kode = $_POST['kode'];
        $namaJurusan = $_POST['nama_jurusan'];
        $k1 = $_POST['k1'];
        $k2 = $_POST['k2'];
        $k3 = $_POST['k3'];
        $k4 = $_POST['k4'];

        if (tambahDataPenilaian($kode, $namaJurusan, $k1, $k2, $k3, $k4)) {
            header("Location: penilaian.php");
        } else {
            echo "Gagal menambahkan data penilaian.";
        }
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'update' && isset($_GET['kode'])) {
        $kode = $_GET['kode'];
        $dataPenilaian = ambilDataPenilaianByKode($kode);

        if (isset($_POST['update'])) {
            $namaJurusan = $_POST['nama_jurusan'];
            $k1 = $_POST['k1'];
            $k2 = $_POST['k2'];
            $k3 = $_POST['k3'];
            $k4 = $_POST['k4'];

            if (updateDataPenilaian($kode, $namaJurusan, $k1, $k2, $k3, $k4)) {
                header("Location: penilaian.php");
            } else {
                echo "Gagal update data penilaian.";
            }
        }
    } elseif ($aksi == 'hapus' && isset($_GET['kode'])) {
        $kode = $_GET['kode'];

        if (hapusDataPenilaian($kode)) {
            header("Location: penilaian.php");
        } else {
            echo "Gagal menghapus data penilaian.";
        }
    }
}

$dataPenilaian = ambilDataPenilaian();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Penilaian</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="text-center mb-0">Data Penilaian</h2>
                    </div>
                    <div class="card-body">

                        <!-- Tambah Data Penilaian Form -->
                        <form method="post" action="" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="kode">Kode:</label>
                                    <input type="text" name="kode" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nama_jurusan">Nama Jurusan:</label>
                                    <input type="text" name="nama_jurusan" class="form-control" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="k1">K1:</label>
                                    <input type="text" name="k1" class="form-control" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="k2">K2:</label>
                                    <input type="text" name="k2" class="form-control" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="k3">K3:</label>
                                    <input type="text" name="k3" class="form-control" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="k4">K4:</label>
                                    <input type="text" name="k4" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                        </form>

                        <!-- Tabel Data Penilaian -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Jurusan</th>
                                    <th>K1</th>
                                    <th>K2</th>
                                    <th>K3</th>
                                    <th>K4</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPenilaian as $penilaian) : ?>
                                    <tr>
                                        <td><?= $penilaian['Kode']; ?></td>
                                        <td><?= $penilaian['Nama_Jurusan']; ?></td>
                                        <td><?= $penilaian['K1']; ?></td>
                                        <td><?= $penilaian['K2']; ?></td>
                                        <td><?= $penilaian['K3']; ?></td>
                                        <td><?= $penilaian['K4']; ?></td>
                                        <td>
                                            <!-- Update Form -->
                                            <form method="post" action="?aksi=update&kode=<?= $penilaian['Kode']; ?>" style="display: inline;">
                                                <input type="hidden" name="update" value="1">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="nama_jurusan">Nama Jurusan:</label>
                                                        <input type="text" name="nama_jurusan" class="form-control" value="<?= $penilaian['Nama_Jurusan']; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="k1">K1:</label>
                                                        <input type="text" name="k1" class="form-control" value="<?= $penilaian['K1']; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="k2">K2:</label>
                                                        <input type="text" name="k2" class="form-control" value="<?= $penilaian['K2']; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="k3">K3:</label>
                                                        <input type="text" name="k3" class="form-control" value="<?= $penilaian['K3']; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="k4">K4:</label>
                                                        <input type="text" name="k4" class="form-control" value="<?= $penilaian['K4']; ?>" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-sm">Update</button>
                                            </form>

                                            <a href="?aksi=hapus&kode=<?= $penilaian['Kode']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data penilaian ini?')">Hapus</a>
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
