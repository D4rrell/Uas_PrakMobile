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

function hitungNilaiYi($matriksNormalisasiTerbobot)
{
    $nilaiYi = [];

    foreach ($matriksNormalisasiTerbobot as $kode => $nilai) {
        $benefit = $nilai['K1'] + $nilai['K2'] + $nilai['K3'];
        $cost = $nilai['K4'];
        $nilaiYi[$kode] = $benefit - $cost;
    }

    return $nilaiYi;
}

$dataPenilaian = ambilDataPenilaian();
$bobotKriteria = ambilBobotKriteria();
$matriksNormalisasi = hitungMatriksNormalisasi($dataPenilaian);
$matriksNormalisasiTerbobot = hitungMatriksNormalisasiTerbobot($matriksNormalisasi, $bobotKriteria);
$nilaiYi = hitungNilaiYi($matriksNormalisasiTerbobot);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Yi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Hasil Perhitungan Nilai Yi</h2>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Benefit</th>
                            <th>Cost</th>
                            <th>Nilai Yi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nilaiYi as $kode => $nilai): ?>
                            <?php
                            $benefit = $matriksNormalisasiTerbobot[$kode]['K1'] + $matriksNormalisasiTerbobot[$kode]['K2'] + $matriksNormalisasiTerbobot[$kode]['K3'];
                            $cost = $matriksNormalisasiTerbobot[$kode]['K4'];
                            ?>
                            <tr>
                                <td><?= $kode; ?></td>
                                <td><?= $benefit; ?></td>
                                <td><?= $cost; ?></td>
                                <td><?= $nilai; ?></td>
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
