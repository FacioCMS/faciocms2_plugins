<div class="_plugin_fcmsanalytics">

    <button class="analytics-btn"><em class="fas fa-chart-line"></em></button>

    <div class="analytics">
        <?php 
            $query = "SELECT DISTINCT entry_date FROM analytics_entry ORDER BY entry_date ASC";
            $entries = [];
            if($res = $db->query($query)) {
                if($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {
                        $entries[] = $row;
                    }
                }
                else {
                    echo "No entries";
                }
            }

            function countDates($date) {
                global $db;
                $query = "SELECT id FROM analytics_entry WHERE entry_date = '$date'";
                if($res = $db->query($query)) {
                    return $res->num_rows;
                } 
            }
        ?>
        <h3>Website statistics (entries)</h3>
        <canvas id="chart-analytics" width="400" height="380"></canvas>
    </div>

    <style>
        .analytics {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: #131313;
            border-radius: 20px;
            box-shadow: 0 0 8px #000;
            display: flex;
            padding: 20px;
            align-items: flex-start;
            justify-content: flex-start;
            flex-direction: column;
            font-size: 30px;
            display: none;
        }

        .analytics.active {
            display: flex;
        }

        .analytics-btn {
            position: fixed;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            padding: 5px;
            font-size: 20px;
            border: 0;
            outline: 0;
            background: #1f2020;
            color: #fff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.1/dist/chart.min.js"></script>

    <script>

        document.querySelector(".analytics-btn").addEventListener("click", () => {
            document.querySelector(".analytics").classList.toggle("active")
        })

        const ctx = document.getElementById('chart-analytics').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php
                        foreach($entries as $entry) {
                            echo "'".$entry["entry_date"]."',";
                        }
                    ?>
                ],
                datasets: [{
                    label: 'Entries',
                    data: [
                        <?php
                            foreach($entries as $entry) {
                                echo countDates($entry["entry_date"]) . ',';
                            }
                        ?>
                    ],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    </script>
</div>
