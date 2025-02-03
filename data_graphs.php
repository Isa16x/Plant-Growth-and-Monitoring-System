<?php
if (!isset($_SESSION)) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_dummy";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['values_for_humidity_chart'])) {
    $selectedOption = $_POST['values_for_humidity_chart'];
    switch ($selectedOption) {
        case "current_week":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '2' 
            AND WEEK(senzorasi.timestamp) = WEEK(CURRENT_DATE()) 
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;

        case "current_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS 
            unitate_masura FROM 
            senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate
             WHERE senzorasi.id_senzor = '2' 
             AND MONTH(senzorasi.timestamp) = MONTH(CURRENT_DATE()) 
             AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "last_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '2'
             AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
             AND MONTH(senzorasi.timestamp) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH));";
            break;
        case "last_3_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '2'
            AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH))
            AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH));";
            break;
        case "last_6_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '2'
            AND (
            (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)))
            );";
            break;
        case "current_year":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '2'
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "all_values":
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '2';";
            break;
        default:
            // Default case if no valid option is selected
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '2';";
            exit;
    }
    $result_humidity = mysqli_query($conn, $sql_humidity);

    $dataPoints_humidity = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_humidity, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
} else {
    $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '2';";
    $result_humidity = mysqli_query($conn, $sql_humidity); // Initialize $result_humidity
    $dataPoints_humidity = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_humidity, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
}
$dataPointsJSON_humidity = json_encode($dataPoints_humidity);

if (isset($_POST['values_for_light_chart'])) {
    $selectedOption = $_POST['values_for_light_chart'];
    switch ($selectedOption) {
        case "current_week":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '1' 
            AND WEEK(senzorasi.timestamp) = WEEK(CURRENT_DATE()) 
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;

        case "current_month":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS 
            unitate_masura FROM 
            senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate
             WHERE senzorasi.id_senzor = '1' 
             AND MONTH(senzorasi.timestamp) = MONTH(CURRENT_DATE()) 
             AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "last_month":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '1'
             AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
             AND MONTH(senzorasi.timestamp) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH));";
            break;
        case "last_3_months":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '1'
            AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH))
            AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH));";
            break;
        case "last_6_months":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '1'
            AND (
            (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)))
            );";
            break;
        case "current_year":
            $sql_light = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '1'
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "all_values":
            $sql_light = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '1';";
            break;
        default:
            // Default case if no valid option is selected
            $sql_light = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '1';";
            exit;
    }
    $result_light = mysqli_query($conn, $sql_light);

    $dataPoints_for_light = array();

    if (mysqli_num_rows($result_light) > 0) {
        while ($row = mysqli_fetch_assoc($result_light)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_light, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
} else {
    $sql_light = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '1';";
    $result_light = mysqli_query($conn, $sql_light); // Initialize $result_humidity
    $dataPoints_for_light = array();

    if (mysqli_num_rows($result_light) > 0) {
        while ($row = mysqli_fetch_assoc($result_light)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_light, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
}
$dataPointsJSON_light = json_encode($dataPoints_for_light);

if (isset($_POST['values_for_humidity_dht_chart'])) {
    $selectedOption = $_POST['values_for_humidity_dht_chart'];
    switch ($selectedOption) {
        case "current_week":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '4' 
            AND WEEK(senzorasi.timestamp) = WEEK(CURRENT_DATE()) 
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;

        case "current_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS 
            unitate_masura FROM 
            senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate
             WHERE senzorasi.id_senzor = '4' 
             AND MONTH(senzorasi.timestamp) = MONTH(CURRENT_DATE()) 
             AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "last_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '4'
             AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
             AND MONTH(senzorasi.timestamp) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH));";
            break;
        case "last_3_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '4'
            AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH))
            AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH));";
            break;
        case "last_6_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '4'
            AND (
            (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)))
            );";
            break;
        case "current_year":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '4'
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "all_values":
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '4';";
            break;
        default:
            // Default case if no valid option is selected
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '4';";
            exit;
    }
    $result_humidity = mysqli_query($conn, $sql_humidity);

    $dataPoints_for_humidity_dht = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_humidity_dht, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
} else {
    $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '4';";
    $result_humidity = mysqli_query($conn, $sql_humidity); // Initialize $result_humidity
    $dataPoints_for_humidity_dht = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_humidity_dht, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
}
$dataPointsJSON_humidity = json_encode($dataPoints_for_humidity_dht);

if (isset($_POST['values_for_temperature_dht_chart'])) {
    $selectedOption = $_POST['values_for_temperature_dht_chart'];
    switch ($selectedOption) {
        case "current_week":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '5' 
            AND WEEK(senzorasi.timestamp) = WEEK(CURRENT_DATE()) 
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;

        case "current_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS 
            unitate_masura FROM 
            senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate
             WHERE senzorasi.id_senzor = '5' 
             AND MONTH(senzorasi.timestamp) = MONTH(CURRENT_DATE()) 
             AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "last_month":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire AS
            unitate_masura FROM senzorasi JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor JOIN unitati_masura ON 
            unitati_masura.id_unitate = senzorasi.id_unitate WHERE senzorasi.id_senzor = '5'
             AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
             AND MONTH(senzorasi.timestamp) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH));";
            break;
        case "last_3_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '5'
            AND YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH))
            AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH));";
            break;
        case "last_6_months":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '5'
            AND (
            (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 2 MONTH)))
            OR (YEAR(senzorasi.timestamp) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) AND MONTH(senzorasi.timestamp) >= MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)))
            );";
            break;
        case "current_year":
            $sql_humidity = "SELECT id_senzor.denumire AS denumire_senzor,
            senzorasi.valoare,
            senzorasi.timestamp,
            unitati_masura.denumire AS unitate_masura
            FROM senzorasi
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate
            WHERE senzorasi.id_senzor = '5'
            AND YEAR(senzorasi.timestamp) = YEAR(CURRENT_DATE());";
            break;
        case "all_values":
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '5';";
            break;
        default:
            // Default case if no valid option is selected
            $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
            unitate_masura 
            FROM `senzorasi` 
            JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
            JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
            WHERE senzorasi.id_senzor = '5';";
            exit;
    }
    $result_humidity = mysqli_query($conn, $sql_humidity);

    $dataPoints_for_temperature_dht = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_temperature_dht, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
} else {
    $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as 
    unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '5';";
    $result_humidity = mysqli_query($conn, $sql_humidity); // Initialize $result_humidity
    $dataPoints_for_temperature_dht = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_for_temperature_dht, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }
    // var_dump($dataPoints_humidity);
}
$dataPointsJSON_temperature = json_encode($dataPoints_for_temperature_dht);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Graphs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis:wght@200&family=Montserrat:wght@200&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Great+Vibes&family=Sacramento&family=Tangerine&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include "conectarebd.php";
    ?>
    <?php include "meniu.php"; ?>
    <br>
    <br><br><br><br>
    <h1 class="titlu_graph">Graphs</h1>
    <br>
    <br>
    <br>
    <br>

    <div class="container_chart">
        <br><br>
        <!-- <h5>My plant's registered humidity values</h5> -->
        <form id="chartFormHumidity" method="post" onchange="redirectOnChangeHumidity()">
            <div class="row">
                <h5 class="col-md">My plant's registered humidity values</h5>
                <div class="col-md" style="text-align:right;">
                    <label for="values_for_humidity_chart">Values for </label>

                    <select id="values_for_humidity_chart" name="values_for_humidity_chart" class="">
                        <option value="current_month" style="display: none;">Current month</option>
                        <option value="current_week">Current week</option>
                        <option value="current_month">Current month</option>
                        <option value="last_month">Last month</option>
                        <option value="last_3_months">Last 3 months</option>
                        <option value="last_6_months">Last 6 months</option>
                        <option value="current_year">Full current year</option>
                        <option value="all_values">All times</option>

                    </select>
                </div>
            </div>
        </form>
        <canvas id="humidityChart" style="height: 400px; width: 100%"></canvas>
    </div>

    <div class="container_chart">
        <br><br>
        <form id="chartFormLight" method="post" onchange="redirectOnChangeLight()">

            <div class="row">
                <h5 class="col-md">My plant's registered light values</h5>
                <div class="col-md" style="text-align:right;">
                    <label for="values_for_light_chart">Values for </label>

                    <select id="values_for_light_chart" name="values_for_light_chart" class="">
                        <option value="current_month" style="display: none;">Current month</option>
                        <option value="current_week">Current week</option>
                        <option value="current_month">Current month</option>
                        <option value="last_month">Last month</option>
                        <option value="last_3_months">Last 3 months</option>
                        <option value="last_6_months">Last 6 months</option>
                        <option value="current_year">Full current year</option>
                        <option value="all_values">All times</option>

                    </select>
                </div>
            </div>
        </form>

        <canvas id="lightChart" style="height: 400px; width: 100%"></canvas>
    </div>
    <!-- humidityDHTChart -->
    <div class="container_chart">
        <br><br>
        <form id="humidityDHTChartForm" method="post" onchange="redirectOnChangeHumidityDHT()">

            <div class="row">
                <h5 class="col-md">My plant's registered air humidity values</h5>
                <div class="col-md" style="text-align:right;">
                    <label for="values_for_humidity_dht_chart">Values for </label>

                    <select id="values_for_humidity_dht_chart" name="values_for_humidity_dht_chart" class="">
                        <option value="current_month" style="display: none;">Current month</option>
                        <option value="current_week">Current week</option>
                        <option value="current_month">Current month</option>
                        <option value="last_month">Last month</option>
                        <option value="last_3_months">Last 3 months</option>
                        <option value="last_6_months">Last 6 months</option>
                        <option value="current_year">Full current year</option>
                        <option value="all_values">All times</option>

                    </select>
                </div>
            </div>
        </form>

        <canvas id="humidityDHTChart" style="height: 400px; width: 100%"></canvas>
    </div>

    <!-- temperatureDHTChartForm -->

    <div class="container_chart">
        <br><br>
        <form id="temperatureDHTChartForm" method="post" onchange="redirectOnChangeHumidityDHT()">

            <div class="row">
                <h5 class="col-md">My plant's registered temperature values</h5>
                <div class="col-md" style="text-align:right;">
                    <label for="values_for_temperature_dht_chart">Values for </label>

                    <select id="values_for_temperature_dht_chart" name="values_for_temperature_dht_chart" class="">
                        <option value="current_month" style="display: none;">Current month</option>
                        <option value="current_week">Current week</option>
                        <option value="current_month">Current month</option>
                        <option value="last_month">Last month</option>
                        <option value="last_3_months">Last 3 months</option>
                        <option value="last_6_months">Last 6 months</option>
                        <option value="current_year">Full current year</option>
                        <option value="all_values">All times</option>

                    </select>
                </div>
            </div>
        </form>

        <canvas id="temperatureDHTChart" style="height: 400px; width: 100%"></canvas>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     var selectElement = document.getElementById('values_for_light_chart');
        //     selectElement.addEventListener('change', function() {
        //         alert("Value changed to: " + this.value);
        //         var selectedOption = this.value; // Get the selected option value
        //         document.getElementById('chartFormLight').submit(); // Submit the form when the select element changes

        //     });

        // });
        function redirectOnChangeHumidity() {
            var selectElement = document.getElementById("values_for_humidity_chart");
            var selectedValue = selectElement.value;
            document.getElementById("chartFormHumidity").action = "data_graphs.php?value_for_humidity_chart=" + selectedValue;
            document.getElementById("chartFormHumidity").submit();
        }

        function redirectOnChangeLight() {
            var selectElement = document.getElementById("values_for_light_chart");
            var selectedValue = selectElement.value;
            document.getElementById("chartFormLight").action = "data_graphs.php?values_for_light_chart=" + selectedValue;
            document.getElementById("chartFormLight").submit();
        }

        function redirectOnChangeHumidityDHT() {
            var selectElement = document.getElementById("values_for_humidity_dht_chart");
            var selectedValue = selectElement.value;
            document.getElementById("humidityDHTChartForm").action = "data_graphs.php?value_for_humidity_dht_chart=" + selectedValue;
            document.getElementById("humidityDHTChartForm").submit();
        }

        function redirectOnChangeTemperatureDHT() {
            var selectElement = document.getElementById("values_for_temperature_dht_chart");
            var selectedValue = selectElement.value;
            document.getElementById("temperatureDHTChartForm").action = "data_graphs.php?value_for_temperature_dht_chart=" + selectedValue;
            document.getElementById("temperatureDHTChartForm").submit();
        }
    </script>

    <script>
        var xValuesHumidity = [];
        var yValuesHumidity = [];

        <?php
        foreach ($dataPoints_humidity as $dataPoint) {
            echo "xValuesHumidity.push('" . date('Y-m-d H:i:s', $dataPoint['x'] / 1000) . "');";
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
            echo "xValuesLight.push('" . date('Y-m-d H:i:s', $dataPoint['x'] / 1000) . "');";
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

        var xValuesHumiditydht = [];
        var yValuesHumiditydht = [];

        <?php
        foreach ($dataPoints_for_humidity_dht as $dataPoint) {
            echo "xValuesHumiditydht.push('" . date('Y-m-d H:i:s', $dataPoint['x'] / 1000) . "');";
            echo "yValuesHumiditydht.push(" . $dataPoint['y'] . ");";
        }
        ?>

        // chart lumina
        new Chart("humidityDHTChart", {
            type: "line",
            data: {
                labels: xValuesHumiditydht,
                datasets: [{
                    label: 'Humidity in air ( % )',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0, 128, 128, 1.0)",
                    borderColor: "rgba(0, 128, 128,0.35)",
                    data: yValuesHumiditydht
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
            echo "xValuesTemperaturedht.push('" . date('Y-m-d H:i:s', $dataPoint['x'] / 1000) . "');";
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
        // Store scroll position before page refresh
        // Function to store scroll position before page refresh
        function storeScrollPosition() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        }

        // Function to restore scroll position after page refresh
        function restoreScrollPosition() {
            var scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, parseInt(scrollPosition));
                sessionStorage.removeItem('scrollPosition');
            }
        }

        // Call storeScrollPosition before refreshing the page
        window.addEventListener('beforeunload', storeScrollPosition);

        // Call restoreScrollPosition when the page loads
        window.addEventListener('load', restoreScrollPosition);
    </script>

    <br>
    <br>
    <p> </p>
    <br>
    <!-- <form action="download_graph_values.php" method="POST" style="text-align: center;">
        <button type="submit" class="btn btn-primary" style="width: 100px; height: 50px; background-color:#A42A04;">Download</button>
    </form> -->


    <script src="jquery-3.6.1.js"></script>

</body>

</html>