<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conectarebd.php";
include "meniu.php";
if (isset($_SESSION['email'])) {
    $common_names = [];
    $scientific_names = [];
    $vegetables = [];
    $image_urls = [];
    $ids = [];
    $spacing = [];
    $family_common_names = [];

    // Fetch plant details from the API based on user's collection
    $sql = "SELECT DISTINCT plant_id FROM users 
            JOIN users_have_users_collections AS in1 ON in1.user_email = users.email 
            JOIN users_collections AS col ON col.collection_id = in1.collection_id
            JOIN users_collections_have_plants ON col.collection_id = users_collections_have_plants.collection_id
            WHERE users.email = '" . $_SESSION['email'] . "';";
    $result = mysqli_query($link2, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $id = $row['plant_id'];
        $sql2 = "SELECT * FROM plante where plante.rank = 'species' AND plante.id = '" . $id . "';";
        echo "";
        $bazadedate = 'csv_db_11';
        $userdb = 'root';
        $parola = '';

        // $conn = new mysqli("localhost", $userdb, $parola, $bazadedate);
        $link3 = mysqli_connect("localhost", $userdb, $parola, $bazadedate);
        if ($link3 === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $result2 = mysqli_query($link3, $sql2);
        while ($row2 = mysqli_fetch_array($result2)) {
            if ($row2['common_name'] != NULL) {
                $common_names[] = $row2['common_name'];
            } else if ($row2['scientific_name'] != NULL) {
                $common_names[] = $row2['scientific_name'];
            }

            $scientific_names[] = $row2['scientific_name'];
            $vegetables[] = $row2['vegetable'];
            $image_urls[] = $row2['image_url'];
            $ids[] = $row2['id'];
            $spacing[] = $row2['planting_row_spacing_cm'];
            $family_common_names[] = $row2['family_common_name'];
        }
        // $apiUrl = "https://trefle.io/api/v1/species/" . $id . "?token=Vy051Qi6ZyqmkINehigaDTrMmdmq_qIXh3b652mdL60";
        // $contextOptions = [
        //     "ssl" => [
        //         "verify_peer" => false,
        //         "verify_peer_name" => false,
        //     ],
        // ];

        // $context = stream_context_create($contextOptions);
        // $response = file_get_contents($apiUrl, false, $context);
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'http://127.0.0.1/licenta/plante.php?id=' . $id,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        // ));

        // $response = curl_exec($curl);
        // // echo $response;
        // curl_close($curl);
        // Fetch the API response
        //         if ($response !== FALSE) {
        //             $plants = json_decode($response, true);

        //             if (isset($plants['data']) && !empty($plants['data'])) {
        //                 $common_names[] = htmlspecialchars($plants['data']['common_name'] ?? 'N/A');
        //                 $scientific_names[] = htmlspecialchars($plants['data']['scientific_name'] ?? 'N/A');
        //                 $vegetables[] = htmlspecialchars(isset($plants['data']['vegetable']) ? ($plants['data']['vegetable'] ? 'true' : 'false') : 'N/A');
        //                 $image_urls[] = htmlspecialchars($plants['data']['image_url'] ?? 'N/A');
        //                 $ids[] = htmlspecialchars($plants['data']['id'] ?? 'N/A');
        //                 $spacing[] = htmlspecialchars($plants['data']['row_spacing']['cm'] ?? 'N/A');
        //             }
        //         }
    }
} else {
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Design your garden</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <style>
        .garden-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            grid-template-rows: repeat(10, 1fr);
            gap: 2px;
            width: 100%;
            height: 500px;
            border: 2px solid #333;
        }

        .garden-cell {
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8em;
        }

        .plant-tomato {
            background-color: #fdfd96;
        }

        .plant-blueberry {
            background-color: #e0f8e6;
        }

        .plant-raspberry {
            background-color: #b19cd9;
        }

        .plant-strawberry {
            background-color: #40E0D0;
        }

        .plant-default {
            background-color: #d3d3d3;
        }
    </style>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <p></p>
    <p></p>
    <h1 class="titlu_pag_cat">Plan your garden</h1>
    <div class="page_interior">
        <?php
        if (isset($_SESSION['email'])) {
        ?>
            <h6>Select your collection</h6>
            <form id="redirectForm" method="POST">
                <select id="planting_place" name="planting_place" required onchange="redirectOnChange()">
                    <?php
                    $sql = "SELECT * FROM users_collections 
                        JOIN users_have_users_collections ON users_collections.collection_id = users_have_users_collections.collection_id 
                        WHERE users_have_users_collections.user_email = '" . $_SESSION['email'] . "';";
                    $result = mysqli_query($link2, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <option value="<?php echo $row['collection_id']; ?>"><?php echo $row['collection_name']; ?></option>
                    <?php
                    }
                    ?>
                    <option value="new_collection">Create a new collection</option>
                </select>
                <br>
                <br>
                <input type="submit" name="show_plants" id="show_plants" value="Show plants" style="margin-left:3%">
            </form>
            <br><br>
            <?php
            if (isset($_POST['show_plants'])) {
                $collection_id = $_POST['planting_place'];
                $_SESSION['collection_id'] = $collection_id;
            }
            ?>
            <form action="" method="POST">
                <div class="plants_preview_corner">
                    <table id="table_plants_from_collection" class="center">
                        <thead>
                            <tr>
                                <th style='padding-right:40px'>Percentage</th>
                                <th>Picture</th>
                                <th style='padding-left:40px'>Plant Name</th>
                                <th style='padding-left:40px'>Plant Species</th>
                                <th style='padding-left:40px'>Plant Family</th>
                                <th style='padding-left:40px'>Plant Type</th>
                                <th style='padding-left:40px'>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($common_names); $i++) {
                                echo "<tr>";
                                echo "<td style='padding-right:40px'><input type='number' id='plant_{$i}' name='plant_{$i}' min='1' max='100' style='width:49px'/>%</td>";
                                echo "<input type='hidden' id='hidden_plant_{$i}' name='hidden_plant_{$i}' value='{$common_names[$i]}'>";
                                echo "<td style='padding-left:40px'><img src='{$image_urls[$i]}' alt='{$common_names[$i]}' style='width:100px; height:100px'/></td>";
                                echo "<td style='padding-left:40px'>{$common_names[$i]}</td>";
                                echo "<td style='padding-left:40px'>{$scientific_names[$i]}</td>";
                                echo "<td style='padding-left:40px'>{$family_common_names[$i]}</td>";
                                echo "<td style='padding-left:40px'>" . ($vegetables[$i] == "1" ? "Vegetable" : "Non-vegetable") . "</td>";
                            ?>
                                <td style='padding-left:40px'>
                                    <form method="post">
                                        <button type='submit' class='btn btn-danger' name='delete_button_for_<?php echo $ids[$i]; ?>'>X</button>
                                        <input type="hidden" name="plant_id_to_delete" value="<?php echo $ids[$i]; ?>">
                                    </form>
                                </td>
                            <?php
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <br><br>

                <?php
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'delete_button_for_') === 0) {
                        $plant_id_to_delete = $_POST['plant_id_to_delete'];

                        $delete_sql = "DELETE FROM users_collections_have_plants WHERE plant_id = $plant_id_to_delete";
                        if (mysqli_query($link2, $delete_sql)) {
                            // echo "<script> alert('Plant deleted successfully.'); </script>";
                            echo "<script> window.location.href = 'garden_design.php'; </script>";
                            // header("Location: garden_design.php");
                            exit();
                        } else {
                            echo "Error deleting plant: " . mysqli_error($conn);
                        }
                        break;
                    }
                }
                ?>

                <div class="row">
                    <div class="col-md" style="padding-left:10%;">
                        <div style="border:2px solid ;margin-right:10%; margin-left:20%; text-align:center">


                            <h5>Set your garden size</h5>
                            <br>
                            <!-- <label for="planting_place">Garden Type:</label><br><p></p>
            <select id="planting_place" name="planting_place" class="">
                <option value="default" style="display: none;">Garden Type</option>
                <option value="patio_and_containers">Patio, containers, balcony</option>
                <option value="greenhouse">Greenhouse</option>
                <option value="plot_land">Directly in land</option>
            </select> -->

                            <label for="garden_shape"> Shape of your area: </label>
                            <div class="garden_shape_checker">
                                <input type="checkbox" value="Rectangle" id="garden_shape_rectangle" name="garden_shape_rectangle">
                                <label for="garden_shape_rectangle">Rectangle</label>
                                <input type="checkbox" value="Triangle" id="garden_shape_triangle" name="garden_shape_triangle">
                                <label for="garden_shape_triangle">Triangle</label>
                                <input type="checkbox" value="Circle" id="garden_shape_circle" name="garden_shape_circle">
                                <label for="garden_shape_circle">Circle</label>
                            </div>
                            <label for="garden_width"> Your garden width (m): </label>
                            <div>
                                <input type="text" id="garden_width" name="garden_width" placeholder="10">
                            </div>
                            <label for="garden_length"> Your garden length (m): </label>
                            <div>
                                <input type="text" id="garden_length" name="garden_length" placeholder="10">
                            </div>
                            <br>
                            <button id="calculate_garden_size" name="calculate_garden_size">Calculate</button>
                        </div>
                    </div>

            </form>
            <div class="col-md">
                <?php
                if (isset($_POST['calculate_garden_size'])) {
                    $length = $_POST['garden_length'];
                    $width = $_POST['garden_width'];
                    $area = 0;

                    if (isset($_POST['garden_shape_rectangle'])) {
                        if (isset($_POST['garden_length']) && isset($_POST['garden_width']) && $length != null && $width != null) {
                            $area = $length * $width * 10000; // Convert square meters to square centimeters
                        }
                    } elseif (isset($_POST['garden_shape_triangle'])) {
                        if (isset($_POST['garden_length']) && isset($_POST['garden_width']) && $length != null && $width != null) {
                            $area = 0.5 * $length * $width * 10000; // Convert square meters to square centimeters
                        }
                    } elseif (isset($_POST['garden_shape_circle'])) {
                        if (isset($_POST['garden_length']) && $length != null) {
                            $radius = $length / 2;
                            $area = pi() * pow($radius, 2) * 10000; // Convert square meters to square centimeters
                        }
                    }

                    if ($area > 0) {
                        $plant_areas = [];
                        $total_used_area = 0;

                        // Calculate the area for each plant based on the given percentage
                        for ($i = 0; $i < count($common_names); $i++) {
                            $plant_key = "plant_" . $i;
                            if (isset($_POST[$plant_key]) && is_numeric($_POST[$plant_key])) {
                                $plantPercentage = $_POST[$plant_key];
                                $plant_area = $area * ($plantPercentage / 100);
                                $plant_areas[] = $plant_area;
                                $total_used_area += $plant_area;
                            } else {
                                $plant_areas[] = 0; // No percentage given
                            }
                        }

                        // Calculate the number of plants for each area
                        echo "<h5>Your shopping list</h5>";
                        echo "<br>";
                        echo "<table id='resultsTable' style='text-align:center'>";
                        echo "<thead><tr><th>Plant Name</th><th style='padding-left:20px'>Percentage</th><th style='padding-left:20px'>Allocated space</th><th style='padding-left:20px'>Plant Count</th></tr></thead>";
                        echo "<tbody>";

                        for ($i = 0; $i < count($common_names); $i++) {
                            $plant_key = "plant_" . $i;
                            if (isset($_POST[$plant_key]) && is_numeric($_POST[$plant_key])) {
                                $plantPercentage = $_POST[$plant_key];
                                $plantArea = $plant_areas[$i];
                                $spacingCm = $spacing[$i];

                                if ($spacingCm != NULL) {
                                    $numPlants = floor($plantArea / ($spacingCm * $spacingCm));
                                } else if ($spacingCm == NULL && $vegetables[$i] == "true") {
                                    $spacingCm = 55;
                                    $numPlants = floor($plantArea / (55 * 55)); // 55cm for vegetables
                                } else if ($spacingCm == NULL && $vegetables[$i] == "false") {
                                    $spacingCm = 75;
                                    $numPlants = floor($plantArea / (75 * 75)); // 75cm for non-vegetables
                                } else {
                                    $spacingCm = 70;
                                    $numPlants = floor($plantArea / (70 * 70)); // 70 for all else
                                }
                                $arie = $plantArea / 100;

                                echo "<tr>";
                                echo "<td>{$common_names[$i]}</td>";
                                echo "<td style='padding-left:20px'>{$plantPercentage}%</td>";
                                echo "<td style='padding-left:20px'>{$arie} cm</td>";
                                echo "<td style='padding-left:20px'>{$numPlants}</td>";
                                // echo "<td style='padding-left:20px'>{$spacingCm}</td>"; // Usual spacing in centimeters
                                echo "</tr>";
                            } else {
                                echo "<tr>";
                                echo "<td>{$common_names[$i]}</td>";
                                echo "<td style='padding-left:20px'>N/A</td>";
                                echo "<td style='padding-left:20px'>N/A</td>";
                            }
                        }

                        echo "</tbody>";
                        echo "</table>";

                        // Calculate remaining space
                        $remaining_area = $area - $total_used_area;
                        if ($remaining_area > 0) {
                            echo "<br><p> <b>Remaining area: </b> " . $remaining_area / 10000 . " square meters</p>"; // Convert back to square meters
                        } else {
                            echo "<br><p>No remaining space</p>";
                        }
                    }
                }
                ?>
            </div>
    </div><br><br><br>
    <?php
            if (isset($_POST['calculate_garden_size'])) {
    ?>
        <div id="garden-visual" style="padding-left:100px; padding-right:70px;">
            <h5>Garden layout and planting area visualization</h5><br>
            <div class="garden-grid">
                <?php
                $length = $_POST['garden_length'];
                $width = $_POST['garden_width'];
                // $plant_colors = [
                //     'Tomato' => 'plant-tomato',
                //     'European blueberry' => 'plant-blueberry',
                //     'Raspberry' => 'plant-raspberry',
                //     'Irish strawberry-tree' => 'plant-strawberry'
                // ];
                $plant_colors = [
                    $common_names[0] =>  'plant-tomato',
                    $common_names[1] => 'plant-blueberry',
                    $common_names[2] => 'plant-raspberry',
                    $common_names[3] => 'plant-strawberry'
                ];


                $total_cells = $length * $width * 100; // Define the total number of cells in the grid
                for ($i = 0; $i < count($common_names); $i++) {
                    $plant_key = "plant_" . $i;
                    // echo $plant_key;
                    if (isset($_POST[$plant_key]) && is_numeric($_POST[$plant_key])) {
                        $plant_percentage = $_POST[$plant_key];
                        if (isset($plant_percentage)) {
                            $num_cells = floor(($plant_percentage / ($length * $width * 100)) * $total_cells);
                            for ($j = 0; $j < $num_cells; $j++) {
                                $plant_name = $common_names[$i];
                                $plant_class = $plant_colors[$plant_name] ?? 'plant-default'; // Use a default class if plant name is not found
                                echo "<div class='garden-cell $plant_class" . $plant_colors[$common_names[$i]] . "'> " . $common_names[$i] . "</div>";
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    <?php } ?>
    </div>
    </div>
<?php
        } else {
            echo '<h3>You are not logged in</h3>';
        }
?>


<!-- <div class="col-md" style="padding-right:10%">
                        
                        <h6>Your shopping list</h6>
                        <br>
                        <table>
                            <thead>
                                <tr>
                                    <th class="shopping_list_plants">Plants</th>
                                    <th class="shopping_list_qty">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div> 
                </div> -->

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
<script>
    function redirectOnChange() {
        var selectElement = document.getElementById("planting_place");
        var selectedValue = selectElement.value;
        if (selectedValue == "new_collection") {
            window.location.href = "manage_collections.php";
        }
    }
</script>
</body>

</html>