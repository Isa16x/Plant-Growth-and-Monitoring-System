<?php

$bazadedate = 'db_plantute';
$userdb ='root';
$parola ='';

// $conn = new mysqli("localhost", $userdb, $parola, $bazadedate);
$link = mysqli_connect("localhost", $userdb, $parola, $bazadedate);
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$bazadedate2 = 'db_dummy';
// $conn = new mysqli("localhost", $userdb, $parola, $bazadedate);
$link2 = mysqli_connect("localhost", $userdb, $parola, $bazadedate2);
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}
// if ($conn->connect_error){
//     die("Connection failed: " . $conn->connect_error);
//     } 


/*
$sql = "SELECT * FROM utilizatori WHERE ID='3'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$nume = $row['nume'];

echo "Numele este: ".$nume;
*/

/*
$sql = "SELECT * FROM utilizatori WHERE ID='2'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>Nume</th>";
                echo "<th>Prenume</th>";
                echo "<th>Parola</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nume'] . "</td>";
                echo "<td>" . $row['prenume'] . "</td>";
                echo "<td>" . $row['parola'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
 
 
 
// Close connection
mysqli_close($link);
*/

?>