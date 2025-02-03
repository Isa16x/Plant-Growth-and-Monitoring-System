<?php
include_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (!isset($_SESSION)) {
    session_start();
}
include "conectarebd.php";

//EMAAAAAIL PT AVERAGEEEEEEEEEEEEEEEEEEEE LA UMID SOL

$sql = "SELECT s.id_senzor, s.valoare,
s.timestamp FROM senzorasi s join id_senzor as u on 
u.id_senzor = s.id_senzor join unitati_masura as m on 
m.id_unitate = s.id_unitate WHERE DATE(timestamp) = CURDATE() 
AND s.id_senzor = 2 ORDER BY s.timestamp";
$soil_average = 0.0;
$number = 0;
$alert = "";
$treshold = 40;
if ($result = mysqli_query($link2, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $number++;
            $soil_average = $soil_average + $row['valoare'];
            if ($number <= 3 && $row['valoare'] <= $treshold) {
                $alert = "without water";
            } else {
            }
        }
    }
}
// echo $alert;
if ($alert == "without water") {
    //SEND EMAIL CA NU MAI E APA PROBABIL ESTUPIDO


    // $developmentMode = true;
    //                 $mailer = new PHPMailer($developmentMode);

    //                 try {
    //                     $mailer->SMTPDebug = 0; //PUNE 2 PT CONVERSATIE
    //                     $mailer->isSMTP();

    //                     if ($developmentMode) {
    //                     $mailer->SMTPOptions = [
    //                         'ssl'=> [
    //                         'verify_peer' => false,
    //                         'verify_peer_name' => false,
    //                         'allow_self_signed' => true
    //                         ]
    //                     ];
    //                     }


    //                     $mailer->Host = 'smtp.gmail.com';
    //                     $mailer->SMTPAuth = true;
    //                     $mailer->Username = 'chocolateriapup@gmail.com';
    //                     $mailer->Password = 'tgvt avkj tjvc xvpu';
    //                     $mailer->SMTPSecure = 'tls';
    //                     $mailer->Port = 587;

    //                     $mailer->setFrom('chocolateriapup@gmail.com', 'Your plants');
    //                     $mailer->addAddress('isabela_hasnas@yahoo.com', 'Your plants');

    //                     $mailer->isHTML(true);
    //                     $mailer->Subject = 'Check the water level';
    //                     $mailer->Body = 'Dear Owner,<br><br>

    //                     Roses are red,<br>
    //                     Violets are blue,<br>
    //                     We\'ve got a problem,<br>
    //                     And we need you.<br><br>

    //                     The sensors are telling us<br>
    //                     Something\'s not right,<br>
    //                     Maybe there\'s an error,<br>
    //                     Or no water in sight.<br><br>

    //                     Please come and check,<br>
    //                     Our reservoir might be dry,<br>
    //                     Without your help,<br>
    //                     We fear we might die.<br><br>

    //                     With leafy love,<br>
    //                     And petals too,<br>
    //                     Your innocent plants,<br>
    //                     Are counting on you.<br><br>

    //                     So please take a moment,<br>
    //                     To give us a drink,<br>
    //                     Or we\'ll stage a revolt,<br>
    //                     And make the whole house stink!<br><br>



    //                     Sincerely,<br><br>
    //                     The Thirsty Plant Gang.';

    //                     $mailer->send();
    //                     $mailer->ClearAllRecipients();
    //                     // echo "MAIL HAS BEEN SENT SUCCESSFULLY";

    //                 } catch (Exception $e) {
    //                     echo "EMAIL SENDING FAILED. INFO: " . $mailer->ErrorInfo;
    //                 }
}

//calculate AVERAGESSSSSSSSSSSSSSSSSSSSS

$sql = "SELECT * FROM senzorasi WHERE DATE(timestamp) = CURDATE() - INTERVAL 1 DAY ORDER BY id_senzor;";
$airHumidity = 0;
$soilHumidity = 0;
$temperature = 0;
$light = 0;

$airHumidityCount = 0;
$soilHumidityCount = 0;
$temperatureCount = 0;
$lightCount = 0;
$initialid = 1;
if ($result = mysqli_query($link2, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($row['id_senzor'] == $initialid) {
                $light = $light + $row['valoare'];
                $lightCount++;
            } else {
                $initialid = $row['id_senzor'];
                if ($row['id_senzor'] == '2') {
                    $soilHumidity = $soilHumidity + $row['valoare'];
                    $soilHumidityCount++;
                } else if ($row['id_senzor'] == '4') {
                    $airHumidity = $airHumidity + $row['valoare'];
                    $airHumidityCount++;
                } else if ($row['id_senzor'] == '5') {
                    $temperature = $temperature + $row['valoare'];
                    $temperatureCount++;
                }
            }
        }
    }
}

$airHumidityAverage = $airHumidityCount > 0 ? $airHumidity / $airHumidityCount : 0;
$soilHumidityAverage = $soilHumidityCount > 0 ? $soilHumidity / $soilHumidityCount : 0;
$temperatureAverage = $temperatureCount > 0 ? $temperature / $temperatureCount : 0;
$lightAverage = $lightCount > 0 ? $light / $lightCount : 0;


// FOR THE DAMN CHARTS 

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_dummy";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql_temp = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '5' AND DATE(senzorasi.timestamp) = CURDATE(); ";
$result_temp = mysqli_query($conn, $sql_temp); // Initialize $result_humidity
$dataPoints_for_temperature_dht = array();

if (mysqli_num_rows($result_temp) > 0) {
    while ($row = mysqli_fetch_assoc($result_temp)) {
        $timestamp_ms = strtotime($row['timestamp']) * 1000;

        array_push($dataPoints_for_temperature_dht, array("x" => $timestamp_ms, "y" => $row['valoare']));
    }
}
$dataPointsJSON_temperature = json_encode($dataPoints_for_temperature_dht);


$sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '2' AND DATE(senzorasi.timestamp) = CURDATE()";
$result_humidity = mysqli_query($conn, $sql_humidity); // Initialize $result_humidity
$dataPoints_humidity = array();

if (mysqli_num_rows($result_humidity) > 0) {
    while ($row = mysqli_fetch_assoc($result_humidity)) {
        $timestamp_ms = strtotime($row['timestamp']) * 1000;
        array_push($dataPoints_humidity, array("x" => $timestamp_ms, "y" => $row['valoare']));
    }
}
$dataPointsJSON_humidity = json_encode($dataPoints_humidity);

$sql_light = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '1' AND DATE(senzorasi.timestamp) = CURDATE();";
$result_light = mysqli_query($conn, $sql_light); // Initialize $result_humidity
$dataPoints_for_light = array();

if (mysqli_num_rows($result_light) > 0) {
    while ($row = mysqli_fetch_assoc($result_light)) {
        $timestamp_ms = strtotime($row['timestamp']) * 1000;
        array_push($dataPoints_for_light, array("x" => $timestamp_ms, "y" => $row['valoare']));
    }
}
$dataPointsJSON_light = json_encode($dataPoints_for_light);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <script>
        // function add_dnone_class(){
        //     // const addElm=document.querySelectorAll("ism-pause-button").forEach(addElm => addElm.classList.add("d-none"));
        //     const elements = document.getElementsByClassName("ism-pause-button");
        //     while(elements.length > 0){
        //         elements[0].parentNode.removeChild(elements[0]);
        //     }
        // }
    </script>
    <title>Main Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis:wght@200&family=Montserrat:wght@200&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Great+Vibes&family=Sacramento&family=Tangerine&display=swap" rel="stylesheet">


</head>

<body>
    <?php

    ?>
    <?php include "meniu.php"; ?>
    <br>
    <br><br><br><br>
    <h1 class="titlu_graph">Main Dashboard for your plants</h1>
    <br>
    <br>
    <br>
    <br>

    <div class="page_interior">
        <div class="row">
            <!-- <div class="col-sm column-for-display" style="background-color: rgba(0, 128, 128, 0.20);">
                <br>
                <h5 style="text-align: center;">Your plants</h5>
                <br><br>
                <p style="text-align: center;">Pick the plants in your greenhouse for more accurate measurements</p>
                <form method="POST" style="text-align: center;">
                    <select name="plant_name" id="plant_name">
                    <?php
                    $sql = "SELECT plant_name FROM `plante`;";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['plant_name'] . '" style="text-align: center;">' . $row['plant_name'] . '</option>';
                            }
                        }
                    }
                    ?>
                    </select>
                    <br><br>
                    <input type="submit" value="Pick">
                </form>
                <br>
            </div> -->
            <div class="col-sm column-for-display" style="background-color: rgba(0, 128, 128, 0.20); text-align:center;">
                <br>
                <h5>Your plants' current status</h5>
                <br><br>

                <?php
                $light = 0;
                $soil = 0;
                $air = 0;
                $temp = 0;

                $sql = "SELECT s.*, u.denumire AS senzor_denumire, m.denumire AS unitate_masura 
                 FROM senzorasi s JOIN ( SELECT id_senzor, MAX(`timestamp`) AS max_timestamp FROM senzorasi GROUP BY id_senzor ) t 
                 ON s.id_senzor = t.id_senzor AND s.`timestamp` = t.max_timestamp 
                 join id_senzor as u on u.id_senzor = s.id_senzor 
                 join unitati_masura as m on m.id_unitate = s.id_unitate;";
                $initialid = 1;
                if ($result = mysqli_query($link2, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['id_senzor'] == '1') {
                                $light = $row['valoare'];
                            } else if ($row['id_senzor'] == '2') {
                                $soil = $row['valoare'];
                            } else if ($row['id_senzor'] == '4') {
                                $air = $row['valoare'];
                            } else if ($row['id_senzor'] == '5') {
                                $temp = $row['valoare'];
                            }
                        }
                    }
                }
                ?>
                <p>Light:
                    <?php

                    if ($light > 40) {
                        echo $light; ?> % <span style="color:green">Light's good</span><?php
                                                                                    } else if ($light < 40) {
                                                                                        echo $light; ?> % <span style="color:red">Needs more light</span><?php
                                                                                                                                                        }
                                                                                                                                                            ?>
                </p>
                <p>Soil Humidity:
                    <?php

                    if ($soil >= 40) {
                        echo $soil; ?> % <span style="color:green">Normal Humidity</span><?php
                                                                                        } else if ($soil < 40) {
                                                                                            echo $soil; ?> % <span style="color:red">Needs watering!</span><?php
                                                                                                                                                        }
                                                                                                                                                            ?>
                </p>
                <p>Air Humidity:
                    <?php

                    if ($air >= 50 && $air <= 80) {
                        echo $air; ?> % <span style="color:green">Normal Humidity</span><?php
                                                                                    } else if ($air < 50) {
                                                                                        echo $air; ?> % <span style="color:red">Needs misting</span><?php
                                                                                                                                                } else if ($air > 80) {
                                                                                                                                                    echo $air; ?> % <span style="color:red">Too much humidity</span><?php
                                                                                                                                                                                                                }
                                                                                                                                                                                                                    ?>
                </p>
                <p>Temperature:
                    <?php

                    if ($temp >= 15 && $temp <= 30) {
                        echo $temp; ?> °C <span style="color:green">Normal Values</span><?php
                                                                                    } else if ($temp < 15) {
                                                                                        echo $temp; ?> °C <span style="color:#9370DB">Too cold</span><?php
                                                                                                                                                    } else if ($temp > 30) {
                                                                                                                                                        echo $temp; ?> °C <span style="color:red">Too hot</span><?php
                                                                                                                                                                                                            }
                                                                                                                                                                                                                ?>
                </p>


            </div>
            <div class="col-sm column-for-display" style="background-color: rgba(0, 170, 128, 0.20);">
                <br>
                <h5 style="text-align: center;">Current environment values for your greenhouse</h5>
                <br>
                <?php

                $sql = "SELECT s.*, u.denumire AS senzor_denumire, m.denumire AS unitate_masura 
                    FROM senzorasi s JOIN ( SELECT id_senzor, MAX(`timestamp`) AS max_timestamp FROM senzorasi GROUP BY id_senzor ) t 
                    ON s.id_senzor = t.id_senzor AND s.`timestamp` = t.max_timestamp 
                    join id_senzor as u on u.id_senzor = s.id_senzor 
                    join unitati_masura as m on m.id_unitate = s.id_unitate;";
                if ($result = mysqli_query($link2, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<p style="text-align: center;">' . $row['senzor_denumire'] . ': ' . $row['valoare'] . ' ' . $row['unitate_masura'] . '</p>';
                        }
                    }
                }
                ?>
            </div>
            <div class="col-sm column-for-display" style="text-align: center; background-color: rgba(0, 230, 128, 0.20);">
                <br><br>
                <h5>Yesterday's average environment values</h5>
                <br>

                <p>Light sensor average: <?php echo $light; ?> %</p>
                <p>Soil Humidity: <?php echo $soilHumidity; ?> RH%</p>
                <p>Air humidity: <?php echo $airHumidity; ?> RH%</p>
                <p>Temperature: <?php echo $temperature; ?> °C</p>

            </div>
        </div>
        <div class="row">
            <div class="col-sm column-for-display">
                <br>
                <h5 style="text-align: center;">Today's soil humidity data</h5>
                <br>
                <canvas id="humidityChart" style="height: 300px; width: 100%"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-sm column-for-display">
                <br>
                <h5 style="text-align: center;">Today's temperature data</h5>
                <br>
                <canvas id="temperatureDHTChart" style="height: 300px; width: 100%"></canvas>
            </div>
            <div class="col-sm column-for-display">
                <br>
                <h5 style="text-align: center;">Today's light data</h5>
                <br>
                <canvas id="lightChart" style="height: 300px; width: 100%"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-sm column-for-display" style="background-image: linear-gradient(to right, #ADD8E6, #9370DB);">
                <br>
                <h5 style="text-align: center;">Compare values</h5>
                <div class="row">
                    <div class="col-sm small-columns-for-comparing" style="margin-left:30px">
                        <form method="POST">
                            <div class="row" style="width:350px">
                                <h6 style="text-align: center;">Pick the dates to compare</h6>
                                <p></p>
                                <div class="col-sm" style="text-align: center;">
                                    <label for="start_date">Starting date: </label><br><input type="date" name="start_date" required pattern="\d{2}/\d{2}/\d{4}" placeholder="dd/mm/yyyy" style="text-align: center;background-image: linear-gradient(to right, #FFFFE0, #90EE90);" /><br>
                                </div>
                                <br>
                                -
                                <div class="col-sm" style="text-align: center;">
                                    <label for="end_date">Ending date: </label><br><input type="date" name="end_date" required pattern="\d{2}/\d{2}/\d{4}" placeholder="dd/mm/yyyy" style="text-align: center;background-image: linear-gradient(to right, #FFFFE0, #90EE90);" />
                                </div>
                                <div style="width:450px; text-align:center;">
                                    <br>
                                    <label for="compare_type">Compare per </label>
                                    <select name="compare_type" id="compare_type" style="text-align: center;background-image: linear-gradient(to right, #FFFFE0, #90EE90);">
                                        <option value="per_day">days</option>
                                        <!-- <option value="per_week">weeks</option>
                                        <option value="per_month">months</option> -->
                                    </select>
                                    <br><br>
                                    <label for="data_which_sensor">Sensor data from </label>
                                    <select name="data_which_sensor" id="data_which_sensor" style="text-align: center;background-image: linear-gradient(to right, #FFFFE0, #90EE90);">
                                        <option value="all_sensors">All sensors</option>
                                        <option value="light_sensor">light sensor</option>
                                        <option value="soil_humidity">soil humidity</option>
                                        <option value="air_humidity">air humidity</option>
                                        <option value="temperature">temperature</option>

                                    </select>
                                    <br><br>
                                    <button type="submit" class="submit-btn" name="submit_download_raport_plant" id="submit_download_raport_plant" style="background-image: linear-gradient(to right, #90EE90, #AFEEEE);">Compare*</button>
                                    <br><br>
                                    <p>*Pressing the button will download a raport with all plants data from the inputted period </p>
                                </div>

                            </div>
                        </form>
                        <?php
                        if (isset($_POST['submit_download_raport_plant'])) {
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];
                            $compare_type = $_POST['compare_type'];
                            $data_which_sensor = $_POST['data_which_sensor'];
                        ?>
                            <script>
                                window.location.replace("http://www.localhost/licenta/download_raport_data.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&compare_type=<?php echo $compare_type; ?>&data_which_sensor=<?php echo $data_which_sensor; ?>");
                            </script>
                        <?php

                        }
                        ?>
                    </div>
                    <div class="col-md-7 small-columns-for-comparing">
                        <img src="./imagini/plant_types.jpg" alt="plants" style="width:700px; height:400px">
                    </div>
                </div>



            </div>
        </div>

    </div>


    <!-- SELECT s.id_senzor, s.valoare,
     s.timestamp FROM senzorasi s join id_senzor as u on 
     u.id_senzor = s.id_senzor join unitati_masura as m on 
     m.id_unitate = s.id_unitate WHERE DATE(timestamp) = CURDATE() 
     AND s.id_senzor = 2 ORDER BY s.timestamp; --QUERY FOR COMPARING / AVERAGEING ?? FOR SOIL HUMIDITY -->


    <script src="jquery-3.6.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".datepicker", {
            dateFormat: "d/m/Y"
        });
    </script>

    <script>
        var xValuesHumidity = [];
        var yValuesHumidity = [];

        <?php
        foreach ($dataPoints_humidity as $dataPoint) {
            echo "xValuesHumidity.push('" . date('H:i', $dataPoint['x'] / 1000) . "');";
            echo "yValuesHumidity.push(" . $dataPoint['y'] . ");";
        }
        ?>


        // umiditate chart
        new Chart("humidityChart", {
            type: "line",
            data: {
                labels: xValuesHumidity,
                datasets: [{
                    label: 'Humidity ( % )',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(176, 58, 46,1.0)",
                    borderColor: "rgba(176, 58, 46,0.35)",
                    data: yValuesHumidity
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var xValuesLight = [];
        var yValuesLight = [];

        <?php
        foreach ($dataPoints_for_light as $dataPoint) {
            echo "xValuesLight.push('" . date('H:i', $dataPoint['x'] / 1000) . "');";
            echo "yValuesLight.push(" . $dataPoint['y'] . ");";
        }
        ?>

        // chart lumina
        new Chart("lightChart", {
            type: "line",
            data: {
                labels: xValuesLight,
                datasets: [{
                    label: 'Light ( % )',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(124, 67, 150,1.0)",
                    borderColor: "rgba(124, 67, 150,0.35)",
                    data: yValuesLight
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var xValuesTemperaturedht = [];
        var yValuesTemperaturedht = [];

        <?php
        foreach ($dataPoints_for_temperature_dht as $dataPoint) {
            echo "xValuesTemperaturedht.push('" . date('H:i', $dataPoint['x'] / 1000) . "');";
            echo "yValuesTemperaturedht.push(" . $dataPoint['y'] . ");";
        }
        ?>

        // chart lumina
        new Chart("temperatureDHTChart", {
            type: "line",
            data: {
                labels: xValuesTemperaturedht,
                datasets: [{
                    label: 'Temperature ( °Celsius )',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(100, 149, 237, 1.0)",
                    borderColor: "rgba(100, 149, 237, 0.35)",
                    data: yValuesTemperaturedht
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</body>

</html>