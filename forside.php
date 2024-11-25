<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';

    $query = "
        SELECT 
            DATE_FORMAT(o.ordreDate, '%Y-%m') AS month,
            SUM(CASE WHEN r.rammeID IS NOT NULL THEN 1 ELSE 0 END) AS ramme_count,
            SUM(CASE WHEN b.båndID IS NOT NULL THEN 1 ELSE 0 END) AS bånd_count
        FROM ordre o
        LEFT JOIN ramme r ON o.ordreID = r.ordreID
        LEFT JOIN bånd b ON o.ordreID = b.ordreID
        GROUP BY month
        ORDER BY month;
    ";

    $result = $conn->query($query);
    $chartData = [];
    while ($row = $result->fetch_assoc()) {
        $chartData[] = $row;
    }

    echo '<script>console.log("Chart Data:", ' . json_encode($chartData) . ');</script>';

    ?>

    <!DOCTYPE html>
    <html>

    <head>
    <title>DONNÉS || FORSIDE</title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script> <!-- Date adapter -->
</head>


    <body>
        <nav class="navbar">
            <img src="./img/hflogo.png" class="logo" alt="logo">
            <h3>Hej
                <?php
                echo $_SESSION['name'];
                ?> 👋🏻
            </h3>
            <a href="logout.php"><button class="signOut" alt="LogOut"></button>
            </a>
        </nav>

        <div class="wrapper">
            <!-- GRAF div -->
            <div class="header">
                <canvas id="orderChart" width="400" height="250"></canvas>

            </div>

            <div class="mainContent">
                <h2>Bestilling:</h2><br>
                <a href="./import/importRamme.php">
                    <button class="mainBtn">ADJ ramme</button>
                </a>
                <a href="ordre_bånd.php">
                    <button class="mainBtn">Bånd</button>
                </a>
                <a href="ordre_dias.php">
                    <button class="mainBtn">Dias</button>
                </a>
                <a href="ordre_smalfilm.php">
                    <button class="mainBtn">Smalfilm</button>
                </a>
                <a href="ordre_rep.php">
                    <button class="mainBtn">Reparationer</button>
                </a>
            </div>

            <div class="secContent">
                <h2>Ordre:</h2><br>
                <a href="./export/output_rammer.php">
                    <button class="mainBtn">Ramme ordre</button>
                </a>

                <a href="output_bånd.php">
                    <button class="mainBtn">Bånd ordre</button>
                </a>
            </div>

            <div class="secContent">
                <h2>Export:</h2><br>
                <a href="export_rammer.php">
                    <button class="mainBtn">Rammer ugelig</button>
                </a>
            </div>
        </div>
      

        <script>
            document.addEventListener("DOMContentLoaded", function () {
    const chartData = <?php echo json_encode($chartData); ?>;

    const months = chartData.map(item => item.month); // Eksempel: ["2024-01", "2024-02", ...]
    const rammeCounts = chartData.map(item => item.ramme_count);
    const båndCounts = chartData.map(item => item.bånd_count || 0); // Fallback til 0, hvis ingen data

    console.log("Months:", months);
    console.log("Ramme Counts:", rammeCounts);
    console.log("Bånd Counts:", båndCounts);

    const ctx = document.getElementById('orderChart').getContext('2d');

    // Dynamisk datasets-konfiguration
    const datasets = [
        {
            label: 'Ramme',
            data: rammeCounts.map((count, index) => ({
                x: months[index],
                y: count
            })),
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 0.1,
            borderRadius: 2,
            barThickness: 20,
            maxBarThickness: 25,
        }
    ];

    // Tilføj kun Bånd-datasættet, hvis der er data
    if (båndCounts.some(count => count > 0)) {
        datasets.push({
            label: 'Bånd',
            data: båndCounts.map((count, index) => ({
                x: months[index],
                y: count
            })),
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 0.1,
            borderRadius: 2,
            barThickness: 20,
            maxBarThickness: 25,
        });
    }

    // Opret Chart.js-graf
    const orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'MMM YYYY',
                        displayFormats: {
                            month: 'MMM YYYY', // Eksempel: "Jan 2024"
                        },
                    },
                    title: {
                        display: true,
                        text: 'Måneder'
                    },
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: 30,
                    title: {
                        display: true,
                        text: 'Antal Ordrer'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });

    // Scroll-effekt til den nuværende måned
    setTimeout(function () {
        const chartContainer = document.querySelector(".header"); // Sikrer, at det passer til din HTML
        const totalMonths = months.length;
        const today = moment();
        const currentMonthIndex = months.findIndex(month =>
            month.startsWith(today.format("YYYY-MM"))
        );

        if (currentMonthIndex >= 0) {
            const scrollPosition =
                (chartContainer.scrollWidth / totalMonths) * currentMonthIndex;

            chartContainer.scrollLeft =
                scrollPosition - chartContainer.clientWidth / 2;
        }
    }, 100); // Giver grafen tid til at loade
});


        </script>

    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>