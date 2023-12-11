<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: 20px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to right, #00a4f6, #00f9f6);
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple-animation 0.7s linear;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .card i {
            font-size: 40px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="data_kriteria.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-cogs"></i>
                    <h4>Data Kriteria</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="data_minat.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-heart"></i>
                    <h4>Data Minat</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="data_nilai_us.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-graduation-cap"></i>
                    <h4>Data Nilai US</h4>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="data_penilaian.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-chart-bar"></i>
                    <h4>Data Penilaian</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="data_tes_lisan.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-microphone"></i>
                    <h4>Data Tes Lisan</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="data_tes_tulis.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-pencil-alt"></i>
                    <h4>Data Tes Tulis</h4>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="normalisasi_terbobot.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-balance-scale"></i>
                    <h4>Normalisasi Terbobot</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="normalisasi.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-chart-pie"></i>
                    <h4>Normalisasi</h4>
                </a>
            </div>
            <div class="col-md-4">
                <a href="optimasi.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-cogs"></i>
                    <h4>Optimasi</h4>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="perangkingan.php" class="card" onclick="addRippleEffect(event)">
                    <i class="fas fa-medal"></i>
                    <h4>Perangkingan</h4>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        function addRippleEffect(event) {
            const card = event.currentTarget;
            const ripple = document.createElement("span");
            const rect = card.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.className = "ripple";

            card.appendChild(ripple);

            // Remove the ripple element after the animation ends
            ripple.addEventListener("animationend", () => {
                ripple.remove();
            });
        }
    </script>
</body>

</html>
