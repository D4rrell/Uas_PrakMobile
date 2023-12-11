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

function hitungMatriksNormalisasi($dataPenilaian)
{
    $matriksNormalisasi = [];

    $penjumlahanKuadrat = [
        'K1' => 0,
        'K2' => 0,
        'K3' => 0,
        'K4' => 0,
    ];

    foreach ($dataPenilaian as $penilaian) {
        $penjumlahanKuadrat['K1'] += pow($penilaian['K1'], 2);
        $penjumlahanKuadrat['K2'] += pow($penilaian['K2'], 2);
        $penjumlahanKuadrat['K3'] += pow($penilaian['K3'], 2);
        $penjumlahanKuadrat['K4'] += pow($penilaian['K4'], 2);
    }

    foreach ($dataPenilaian as $penilaian) {
        $kode = $penilaian['Kode'];
        $matriksNormalisasi[$kode] = [
            'K1' => $penilaian['K1'] / sqrt($penjumlahanKuadrat['K1']),
            'K2' => $penilaian['K2'] / sqrt($penjumlahanKuadrat['K2']),
            'K3' => $penilaian['K3'] / sqrt($penjumlahanKuadrat['K3']),
            'K4' => $penilaian['K4'] / sqrt($penjumlahanKuadrat['K4']),
        ];
    }

    return $matriksNormalisasi;
}

$dataPenilaian = ambilDataPenilaian();
$matriksNormalisasi = hitungMatriksNormalisasi($dataPenilaian);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriks Normalisasi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Matriks Normalisasi</h2>
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
                        <?php foreach ($matriksNormalisasi as $kode => $nilai) : ?>
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
