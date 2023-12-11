<?php
include 'koneksi.php';

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

function ambilBobotKriteria()
{
    global $koneksi;
    $query = "SELECT * FROM Kriteria";
    $result = mysqli_query($koneksi, $query);
    $bobotKriteria = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $bobotKriteria[$row['Kode']] = $row['Bobot_Kriteria'];
    }

    return $bobotKriteria;
}

function hitungMatriksNormalisasi($dataPenilaian)
{
    $matriksNormalisasi = [];
    $penjumlahanKuadrat = [];

    foreach ($dataPenilaian as $penilaian) {
        foreach ($penilaian as $k => $nilai) {
            if ($k !== 'Kode' && $k !== 'Nama_Jurusan') {
                if (!isset($penjumlahanKuadrat[$k])) {
                    $penjumlahanKuadrat[$k] = 0;
                }
                $penjumlahanKuadrat[$k] += pow($nilai, 2);
            }
        }
    }

    foreach ($dataPenilaian as $penilaian) {
        $kode = $penilaian['Kode'];
        $matriksNormalisasi[$kode] = [];
        foreach ($penilaian as $k => $nilai) {
            if ($k !== 'Kode' && $k !== 'Nama_Jurusan') {
                $matriksNormalisasi[$kode][$k] = $nilai / sqrt($penjumlahanKuadrat[$k]);
            }
        }
    }

    return $matriksNormalisasi;
}

function hitungMatriksNormalisasiTerbobot($matriksNormalisasi, $bobotKriteria)
{
    $matriksNormalisasiTerbobot = [];

    foreach ($matriksNormalisasi as $kode => $nilai) {
        $matriksNormalisasiTerbobot[$kode] = [];
        foreach ($nilai as $k => $nilaiKriteria) {
            $matriksNormalisasiTerbobot[$kode][$k] = $nilaiKriteria * $bobotKriteria[$k];
        }
    }

    return $matriksNormalisasiTerbobot;
}

$dataPenilaian = ambilDataPenilaian();
$bobotKriteria = ambilBobotKriteria();
$matriksNormalisasi = hitungMatriksNormalisasi($dataPenilaian);
$matriksNormalisasiTerbobot = hitungMatriksNormalisasiTerbobot($matriksNormalisasi, $bobotKriteria);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriks Normalisasi Terbobot</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Matriks Normalisasi Terbobot</h2>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode</th>
                            <th>K1</th>
                            <th>K2</th>
                            <th>K3</th>
                            <th>K4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matriksNormalisasiTerbobot as $kode => $nilai) : ?>
                            <tr>
                                <td><?= $kode; ?></td>
                                <td><?= $nilai['K1']; ?></td>
                                <td><?= $nilai['K2']; ?></td>
                                <td><?= $nilai['K3']; ?></td>
                                <td><?= $nilai['K4']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php mysqli_close($koneksi); ?>
