<?php

$servername = "localhost";
$dbname = "db_dummy";
$username = "root";
$password = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['sensor'])) {
        echo "Sensor is set";
    }
    if (isset($_GET['measurement'])) {
        echo "Measurement is set";
    }
    // echo isset($_POST['sensor']);
    // echo isset($_POST['measurement']);
    if ((isset($_POST["sensor"]) && isset($_POST["measurement"])) || (isset($_GET["sensor"]) && isset($_GET["measurement"]))) {

        $sensor = $_POST["sensor"];
        $measurement = $_POST["measurement"];
        echo $sensor . ' ' . $measurement;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $current_timestamp = time();
        $formatted_timestamp = date("Y-m-d H:i:s", $current_timestamp);


        switch ($sensor) {
            case "light_sensor":
                $sql = "INSERT INTO senzorasi (id_senzor, valoare, id_unitate, timestamp)
                        VALUES ('1', '$measurement', '1', '$formatted_timestamp')";
                break;
            case "humidity_sensor":
                $sql = "INSERT INTO senzorasi (id_senzor, valoare, id_unitate, timestamp)
                        VALUES ('2', '$measurement', '3', '$formatted_timestamp')";
                break;
                // case "humidity_and_temperature":
                //     $sql = "INSERT INTO sensordata (sensor, location, distance, humidity, temperature)
                //             VALUES ('$sensor', '$location', '$distance', '$measurement')";
                //     break;
            case "humidity_dht":
                $sql = "INSERT INTO senzorasi (id_senzor, valoare, id_unitate, timestamp)
                        VALUES ('4', '$measurement', '3', '$formatted_timestamp')";
                break;
            case "temperature_dht":
                $sql = "INSERT INTO senzorasi (id_senzor, valoare, id_unitate, timestamp)
                        VALUES ('5', '$measurement', '2', '$formatted_timestamp')";
                break;
            default:
                echo "Error: Invalid sensor type.";
                exit;
        }


        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


        $conn->close();
    } else {
        // echo $_POST;
        echo "aaaaaaaa " . $_GET['sensor'] . ' ' . $_GET['measurement'];
        echo "Error: Incomplete data posted with HTTP POST.";
    }
} else {
    echo "No data posted with HTTP POST.";
}
