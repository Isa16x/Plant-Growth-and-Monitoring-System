<?php if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include "conectarebd.php";
if (isset($_POST['planting_place']) && $_POST['planting_place'] == "new_collection") {
    header("Location: manage_collections.php"); // Redirect to new_collection.php
    exit(); // Stop further execution
}
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
    <title>Plant Collections</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>


</head>

<body>
    <?php
    include "conectarebd.php";
    ?>
    <?php include "meniu.php"; ?>
    <br>
    <br><br><br><br>
    <h1 class="titlu_pag_cat">Your plant collections</h1>
    <br>
    <br>
    <br>
    <br>
    <div class="page_interior">
        <h3>Choose your plants from your collections</h3>
        <br>
        <div>

            <h6>Select your collection</h6>
            <form id="redirectForm" method="POST">

                <select id="planting_place" name="planting_place" onchange="redirectOnChange()">
                    <!-- <option value="my_collection" style="display: none;">My Collection</option> -->
                    <?php
                    $sql = "SELECT * FROM users_collections join users_have_users_collections
                 on users_collections.collection_id = users_have_users_collections.collection_id 
                 where users_have_users_collections.user_email = '" . $_SESSION['email'] . "';";
                    $result = mysqli_query($link2, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <option value="<?php echo $row['collection_id']; ?>"><?php echo $row['collection_name']; ?></option>
                    <?php
                    }
                    ?>
                    <option value="new_collection">Create a new collection</option>
                </select>

        </div>
        <br>
        <h6>Customize your plant's details</h6>
        <label>Select the preferred details to show going forward: </label><br>

        <div class="" style="padding-top: 10px;">
            <div class="row">
                <div class="col-md">
                    <input type="checkbox" value="plant_type" id="plant_type" name="plant_type">
                    <label for="plant_type">Plant Type</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="light_lv" id="light_lv" name="light_lv">
                    <label for="light_lv">Light level</label>
                </div>
                <!-- <div class="col-md">
                            <input type="checkbox" value="water_needs" id="water_needs" name="water_needs">
                            <label for="water_needs">Water Needs</label>
                        </div> -->
                <div class="col-md">
                    <input type="checkbox" value="plant_family" id="plant_family" name="plant_family">
                    <label for="plant_family">Plant family</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="growth_form" id="growth_form" name="growth_form">
                    <label for="growth_form">Growth Form</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="growing_season" id="growing_season" name="growing_season">
                    <label for="growing_season">Growing Season</label>
                </div>

            </div>

            <div class="row">
                <div class="col-md">
                    <input type="checkbox" value="average_height" id="average_height" name="average_height">
                    <label for="average_height">Average Plant Height</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="min_temp" id="min_temp" name="min_temp">
                    <label for="min_temp">Minimum temperature</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="max_temp" id="max_temp" name="max_temp">
                    <label for="max_temp">Max temperature</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="soil_ph" id="soil_ph" name="soil_ph">
                    <label for="soil_ph">Soil pH</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="growth_rate" id="growth_rate" name="growth_rate">
                    <label for="growth_rate">Growth Rate</label>
                </div>

            </div>
            <div class="row">
                <div class="col-md">
                    <input type="checkbox" value="toxicity" id="toxicity" name="toxicity">
                    <label for="toxicity">Toxicity</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="soil_salinity" id="soil_salinity" name="soil_salinity">
                    <label for="soil_salinity">Soil salinity</label>
                </div>
                <div class="col-md">
                    <input type="checkbox" value="soil_type" id="soil_type" name="soil_type">
                    <label for="soil_type">Soil type</label>
                </div>

                <div class="col-md">
                    <input type="checkbox" value="air_humidity" id="air_humidity" name="air_humidity">
                    <label for="air_humidity">Athmosferic humidity</label>
                </div>
                <div class="col-md">

                </div>
            </div>


            <div class="row">
                <div class="col-md">

                </div>
                <div class="col-md">

                </div>
                <div class="col-md">
                    <br>
                    <input type="submit" id="continue_button_1" name="continue_button_1" class="btn btn-info " value="Continue">

                </div>
                <div class="col-md">

                </div>
                <div class="col-md">

                </div>

            </div>
            <br><br>




        </div>
        </form>


        <?php

        function generateSQL($formData, $link)
        {
            // Check checked boxes 
            $plant_details_preferred = array();
            $collection_name = mysqli_real_escape_string($link, $formData['planting_place']);
            $plant_details_preferred[] = "picture";
            $plant_details_preferred[] = "plant_name";
            $plant_details_preferred[] = "plant_species";

            if (isset($formData['plant_type'])) {
                $plant_details_preferred[] = "plant_type";
            }
            if (isset($formData['light_lv'])) {
                $plant_details_preferred[] = "light_lv";
            }
            if (isset($formData['water_needs'])) {
                $plant_details_preferred[] = "water_needs";
            }
            if (isset($formData['maintanence_lv'])) {
                $plant_details_preferred[] = "maintanence_lv";
            }
            if (isset($formData['growing_season'])) {
                $plant_details_preferred[] = "growing_season";
            }
            if (isset($formData['average_height'])) {
                $plant_details_preferred[] = "average_height";
            }
            if (isset($formData['planting_width'])) {
                $plant_details_preferred[] = "planting_width";
            }
            if (isset($formData['soil_type'])) {
                $plant_details_preferred[] = "soil_type";
            }
            if (isset($formData['soil_ph'])) {
                $plant_details_preferred[] = "soil_ph";
            }
            if (isset($formData['soil_drainage'])) {
                $plant_details_preferred[] = "soil_drainage";
            }
            // if (!empty($plant_details_preferred)) {
            //     $conditions[] = "(" . implode(" OR ", $plant_details_preferred) . ")";
            // }
            // Combine all conditions with 'AND'
            $where_clause = implode(" , ", $plant_details_preferred);

            // SQL query
            $sql = "SELECT DISTINCT ";
            if (!empty($where_clause)) {
                $sql .=  $where_clause;
            }
            $sql .= " FROM plante join users_collections_have_plants on users_collections_have_plants.plant_id = plante.id 
                    join users_collections on users_collections.collection_id = users_collections_have_plants.collection_id
                     where users_collections.collection_id = '" . $collection_name . " ' ORDER BY plante.plant_name ASC";
            // echo 'sql:';
            // echo $sql;
            return $sql;
        }


        $common_names = array();
        $scientific_names = array();
        $slugs = array();
        $familys = array();
        $genuses = array();
        $image_urls = array();
        $appearance_years = array();
        $observationss = array();
        $flowers = array();
        $index = 0;
        $fruits = array();
        $growth_forms = array();
        $average_heights = array();
        $min_temps = array();
        $max_temps = array();
        $soils = array();
        $ph_mins = array();
        $ph_maxs = array();
        $growth_rates = array();
        $toxicities = array();
        $soil_salinities = array();
        $atmospheric_humidities = array();
        $light_requirements = array();
        $vegetables = array();
        $ids = array();
        $sqlbun = "SELECT DISTINCT plant_id FROM users 
           JOIN users_have_users_collections AS in1 ON in1.user_email = users.email 
           JOIN users_collections AS col ON col.collection_id = in1.collection_id
           JOIN users_collections_have_plants ON col.collection_id = users_collections_have_plants.collection_id
           WHERE users.email = '" . $_SESSION['email'] . "';";
        // echo $_SESSION['email'];
        $resultbun = mysqli_query($link2, $sqlbun);

        while ($row = mysqli_fetch_array($resultbun)) {
            $id = $row['plant_id'];
            // $apiUrl = "https://trefle.io/api/v1/species/" . $id . "?token=Vy051Qi6ZyqmkINehigaDTrMmdmq_qIXh3b652mdL60";
            // // echo "API URL: $apiUrl<br>";
            // $contextOptions = array(
            //     "ssl" => array(
            //         "verify_peer" => false,
            //         "verify_peer_name" => false,
            //     ),
            // );

            // $context = stream_context_create($contextOptions);
            // $response = file_get_contents($apiUrl, false, $context);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://127.0.0.1/licenta/plante.php?id=' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            // echo $response;
            curl_close($curl);

            if ($response === FALSE) {
                die('Failed to fetch API response');
            }

            $plants = json_decode($response, true);
            // Fetch the API response
            // print_r($plants);
            if ($response !== FALSE) {
                // echo "Response is not false<br>";
                // Decode the JSON response

                // echo '<pre>'; print_r($plants); echo '</pre>'; // Debugging output

                if (!empty($plants['data'])) {
                    if (!empty($plants['data'])) {
                        foreach ($plants['data'] as $plant) {
                            $common_name = htmlspecialchars($plant['common_name'] ?? 'N/A');
                            // echo $common_name . "<br>";
                            $scientific_name = htmlspecialchars($plant['scientific_name'] ?? 'N/A');
                            // echo $scientific_name;
                            $slug = htmlspecialchars($plant['slug'] ?? 'N/A');
                            $family = htmlspecialchars($plant['family'] ?? 'N/A');
                            $genus = htmlspecialchars($plant['genus'] ?? 'N/A');
                            $image_url = htmlspecialchars($plant['image_url'] ?? 'N/A');
                            $rank = htmlspecialchars($plant['rank'] ?? 'N/A');
                            $vegetable = htmlspecialchars(isset($plant['vegetable']) ? ($plant['vegetable'] ? '1' : '0') : 'N/A');
                            $family_common_name = htmlspecialchars($plant['family_common_name'] ?? 'N/A');
                            $appearance_year = htmlspecialchars($plant['year'] ?? 'N/A');
                            $id = htmlspecialchars($plant['id'] ?? 'N/A');
                            $observations = $plant['observations'] ?? 'N/A';

                            // New fields to be added
                            $growth_form = htmlspecialchars($plant['specifications']['growth_form'] ?? 'N/A');
                            $average_height = htmlspecialchars($plant['specifications']['average_height']['cm'] ?? 'N/A');
                            $min_temp = htmlspecialchars($plant['growth']['minimum_temperature']['deg_c'] ?? 'N/A');
                            $max_temp = htmlspecialchars($plant['growth']['maximum_temperature']['deg_c'] ?? 'N/A');
                            $soil = htmlspecialchars($plant['growth']['soil_texture'] ?? 'N/A');
                            $ph_min = htmlspecialchars($plant['growth']['ph_minimum'] ?? 'N/A');
                            $ph_max = htmlspecialchars($plant['growth']['ph_maximum'] ?? 'N/A');
                            $growth_rate = htmlspecialchars($plant['specifications']['growth_rate'] ?? 'N/A');
                            $toxicity = htmlspecialchars($plant['specifications']['toxicity'] ?? 'N/A');
                            $soil_salinity = htmlspecialchars($plant['growth']['soil_salinity'] ?? 'N/A');
                            $atmospheric_humidity = htmlspecialchars($plant['growth']['atmospheric_humidity'] ?? 'N/A');
                            $light_requirement = htmlspecialchars($plant['growth']['light'] ?? 'N/A');

                            // Assigning values to arrays
                            $common_names[$index] = $common_name;
                            $scientific_names[$index] = $scientific_name;
                            $slugs[$index] = $slug;
                            $familys[$index] = $family;
                            $genuses[$index] = $genus;
                            $image_urls[$index] = $image_url;
                            $appearance_years[$index] = $appearance_year;
                            $observationss[$index] = $observations;
                            $growth_forms[$index] = $growth_form;
                            $average_heights[$index] = $average_height;
                            $min_temps[$index] = $min_temp;
                            $max_temps[$index] = $max_temp;
                            $soils[$index] = $soil;
                            $ph_mins[$index] = $ph_min;
                            $ph_maxs[$index] = $ph_max;
                            $growth_rates[$index] = $growth_rate;
                            $toxicities[$index] = $toxicity;
                            $soil_salinities[$index] = $soil_salinity;
                            $atmospheric_humidities[$index] = $atmospheric_humidity;
                            $light_requirements[$index] = $light_requirement;
                            $vegetables[$index] = $vegetable;
                            $ids[$index] = $id;
                            // Check if 'flower' exists in the 'images' array and if it's a string
                            if (isset($plants['data']['images']['flower']) && is_array($plants['data']['images']['flower'])) {
                                $flower_images = $plants['data']['images']['flower'];
                                // Assuming you want the first image in the flower images array
                                if (!empty($flower_images) && isset($flower_images[0]['image_url'])) {
                                    $flowers[$index] = htmlspecialchars($flower_images[0]['image_url']);
                                } else {
                                    $flowers[$index] = 'N/A';
                                }
                            } else {
                                $flowers[$index] = 'N/A';
                            }
                            // Check if 'fruit' exists in the 'images' array and if it's a string
                            if (isset($plants['data']['images']['fruit']) && is_array($plants['data']['images']['fruit'])) {
                                $fruit_images = $plants['data']['images']['fruit'];
                                // Assuming you want the first image in the fruit images array
                                if (!empty($fruit_images) && isset($fruit_images[0]['image_url'])) {
                                    $fruits[$index] = htmlspecialchars($fruit_images[0]['image_url']);
                                } else {
                                    $fruits[$index] = 'N/A';
                                }
                            } else {
                                $fruits[$index] = 'N/A';
                            }
                        }
                    }
                    // echo "am intrat";
                    // $common_name = htmlspecialchars($plants['data']['common_name'] ?? 'N/A');
                    // echo $plants['data']['common_name'];
                    // echo $common_name;

                }


                $index++;
            } else {
                echo "Failed to fetch API response<br>";
            }
        }

        // echo '<pre>'; print_r($flowers); echo '</pre>'; // Final debugging output

        for ($i = 0; $i < $index; $i++) {
            if ($flowers[$i] == 'N/A' || $fruits[$i] == 'N/A') {
            } else {
            }
        }

        function generatePlant_array_list($formData, $link)
        {
            // Check checked boxes 
            $plant_details_preferred = array();
            $plant_details_preferred[] = "Picture";
            $plant_details_preferred[] = "Plant Name";
            $plant_details_preferred[] = "Plant Species";


            if (isset($formData['plant_type'])) {
                $plant_details_preferred[] = "Plant Type";
            }
            if (isset($formData['light_lv'])) {
                $plant_details_preferred[] = "Light level";
            }
            if (isset($formData['plant_family'])) {
                $plant_details_preferred[] = "Family";
            }
            if (isset($formData['growth_form'])) {
                $plant_details_preferred[] = "Growth Form";
            }
            if (isset($formData['growing_season'])) {
                $plant_details_preferred[] = "Growing Season(s)";
            }
            if (isset($formData['average_height'])) {
                $plant_details_preferred[] = "Average Height";
            }
            if (isset($formData['min_temp'])) {
                $plant_details_preferred[] = "Min Temp";
            }
            if (isset($formData['max_temp'])) {
                $plant_details_preferred[] = "Max Temp";
            }
            if (isset($formData['soil_ph'])) {
                $plant_details_preferred[] = "Soil pH";
            }
            if (isset($formData['growth_rate'])) {
                $plant_details_preferred[] = "Growth Rate";
            }
            if (isset($formData['toxicity'])) {
                $plant_details_preferred[] = "Toxicity";
            }
            if (isset($formData['soil_salinity'])) {
                $plant_details_preferred[] = "Soil Salinity";
            }
            if (isset($formData['soil_type'])) {
                $plant_details_preferred[] = "Soil Type";
            }

            if (isset($formData['air_humidity'])) {
                $plant_details_preferred[] = "Athm. Humidity";
            }


            return $plant_details_preferred;
        }
        function generatePlant_details_for_sql_list($formData, $link)
        {
            // Check checked boxes 
            $plant_details_preferred = array();
            $plant_details_preferred[] = "picture";
            $plant_details_preferred[] = "plant_name";
            $plant_details_preferred[] = "plant_species";


            if (isset($formData['plant_type'])) {
                $plant_details_preferred[] = "plant_type";
            }
            if (isset($formData['light_lv'])) {
                $plant_details_preferred[] = "light_lv";
            }
            if (isset($formData['water_needs'])) {
                $plant_details_preferred[] = "water_needs";
            }
            if (isset($formData['maintanence_lv'])) {
                $plant_details_preferred[] = "maintanence_lv";
            }
            if (isset($formData['growing_season'])) {
                $plant_details_preferred[] = "growing_season";
            }
            if (isset($formData['average_height'])) {
                $plant_details_preferred[] = "average_height";
            }
            if (isset($formData['planting_width'])) {
                $plant_details_preferred[] = "planting_width";
            }
            if (isset($formData['soil_type'])) {
                $plant_details_preferred[] = "soil_type";
            }
            if (isset($formData['soil_ph'])) {
                $plant_details_preferred[] = "soil_ph";
            }
            if (isset($formData['soil_drainage'])) {
                $plant_details_preferred[] = "soil_drainage";
            }

            return $plant_details_preferred;
        }


        if (isset($_POST['continue_button_1'])) {

            $formData = $_POST;
            // $sql = generateSQL($formData, $link);
            $plant_details_preferred = generatePlant_array_list($formData, $link);
            // $plant_details_preferred_names_for_sql = generatePlant_details_for_sql_list($formData, $link);
            // echo 'plant_array: ';
            // echo implode(", ", $plant_details_preferred_names_for_sql);

        ?>

            <div class="plants_preview_corner ">

                <table id="table_plants_from_collection" class="center">
                    <thead>
                        <tr>
                            <?php
                            // echo "<th style='padding-right:40px '>Percentage</th>";
                            for ($i = 0; $i < count($plant_details_preferred); $i++) {
                                if ($i == 0) {
                                    echo "<th>" . $plant_details_preferred[$i] . "</th>";
                                } else {
                                    echo "<th style='padding-left:40px'>" . $plant_details_preferred[$i] . "</th>";
                                }
                            }
                            echo "<th style='padding-left:40px'>Delete</th>";
                            ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < $index; $i++) {
                            echo "<tr>";
                            // echo "<td style='padding-right:40px'><input type='number' id='plant_%_{$common_names[$i]}' name='plant_%_{$common_names[$i]}' min='1' max='100' style='width:49px'/>%</td>";
                            echo "<input type='hidden' id='hidden_plant_{$common_names[$i]}' name='hidden_plant_{$common_names[$i]}' value=''>";
                            if ($vegetables[$i] == "true") {
                                $vegetables[$i] = "Vegetable";
                            } else {
                                $vegetables[$i] = "Non-vegetable";
                            }
                            echo "<td style='padding-left:40px'><img src='{$image_urls[$i]}' alt='{$common_names[$i]}' style='width:100px; height:100px'/></td>";
                            echo "<td style='padding-left:40px'>{$common_names[$i]}</td>";
                            echo "<td style='padding-left:40px'>{$scientific_names[$i]}</td>";


                            if (isset($formData['plant_type'])) {
                                echo "<td style='padding-left:40px'>{$vegetables[$i]}</td>"; //plant type

                            }

                            $lightTypes = [
                                0 => 'No light (<= 10 lux)',
                                1 => '10 - 1,000 lux',
                                2 => '1,000 - 5,000 lux',
                                3 => '5,000 - 10,000 lux',
                                4 => '10,000 - 20,000 lux',
                                5 => '20,000 - 30,000 lux',
                                6 => '30,000 - 40,000 lux',
                                7 => '40,000 - 50,000 lux',
                                8 => '50,000 - 75,000 lux',
                                9 => '75,000 - 100,000 lux',
                                10 => 'Very intensive insolation (>= 100,000 lux)'
                            ];

                            if (isset($formData['light_lv'])) {
                                if (isset($light_requirements[$i]) && $light_requirements[$i] != "N/A") {
                                    // Display the light requirement if available
                                    $light_level = intval($light_requirements[$i]);
                                    echo "<td style='padding-left:40px'>" . $lightTypes[$light_level] . "</td>";
                                } else {
                                    // If light requirement is not available, provide default values based on vegetable type
                                    if ($vegetables[$i] == "Vegetable") {
                                        $light_requirements[$i] = 7;
                                        $light_level = intval($light_requirements[$i]);
                                        echo "<td style='padding-left:40px'>" . $lightTypes[$light_level] . "</td>";
                                    } else if ($vegetables[$i] == "Non-vegetable") {
                                        // Generate a random value for non-vegetable plants
                                        $light_requirements[$i] = rand(3, 7);
                                        $light_level = intval($light_requirements[$i]);
                                        echo "<td style='padding-left:40px'>" . $lightTypes[$light_level] . "</td>";
                                    }
                                }
                            }
                            if (isset($formData['plant_family'])) {
                                echo "<td style='padding-left:40px'>{$familys[$i]}</td>";
                            }
                            if (isset($formData['growth_form'])) {
                                if ($growth_forms[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$growth_forms[$i]}</td>";
                                } else {
                                    echo "<td style='padding-left:40px'>Unknown</td>";
                                }
                            }
                            if (isset($formData['growing_season'])) {
                                if ($vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>Spring, Summer, Very Early Fall </td>";
                                } else {
                                    echo "<td style='padding-left:40px'>Spring, Summer, Fall, Winter </td>";
                                }
                            }
                            if (isset($formData['average_height'])) {
                                if ($average_heights[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$average_heights[$i]} cm</td>";
                                } else {
                                    echo "<td style='padding-left:40px'>Unknown</td>";
                                }
                            }
                            if (isset($formData['min_temp'])) {
                                if ($min_temps[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$min_temps[$i]}°C</td>";
                                } else if ($min_temps[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>10°C</td>";
                                } else if ($min_temps[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>-1°C</td>";
                                }
                            }
                            if (isset($formData['max_temp'])) {
                                if ($max_temps[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$max_temps[$i]}°C</td>";
                                } else if ($max_temps[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>29°C</td>";
                                } else if ($max_temps[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>35°C</td>";
                                }
                            }
                            if (isset($formData['soil_ph'])) {

                                if ($ph_mins[$i] != "N/A" && $ph_maxs[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$ph_mins[$i]} - {$ph_maxs[$i]}</td>";
                                } else if (($ph_mins[$i] == "N/A" || $ph_maxs[$i] == "N/A") && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>6.0 - 7.0</td>";
                                } else if (($max_temps[$i] == "N/A" || $ph_maxs[$i] == "N/A") && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>5.9 - 7.1</td>";
                                }
                            }
                            if (isset($formData['growth_rate'])) {
                                if ($growth_rates[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$growth_rates[$i]}</td>";
                                } else if ($growth_rates[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>Normal</td>";
                                } else if ($growth_rates[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>Normal</td>";
                                }
                            }
                            if (isset($formData['toxicity'])) {
                                if ($toxicities[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$toxicities[$i]}</td>";
                                } else if ($toxicities[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>none</td>";
                                } else if ($toxicities[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>no data</td>";
                                }
                            }
                            if (isset($formData['soil_salinity'])) {
                                if ($soil_salinities[$i] != "N/A") {
                                    echo "<td style='padding-left:40px'>{$soil_salinities[$i]}</td>";
                                } else if ($soil_salinities[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>1.0</td>";
                                } else if ($soil_salinities[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>1.2</td>";
                                }
                            }
                            $soilTypes = [
                                0 => 'Clay Soil',
                                1 => 'Silty Soil',
                                2 => 'Sandy Soil',
                                3 => 'Loamy Soil',
                                4 => 'Silty Clay Soil',
                                5 => 'Sandy Clay Soil',
                                6 => 'Loamy Sand Soil',
                                7 => 'Loamy Clay Soil',
                                8 => 'Rocky Soil',
                                9 => 'Stony Soil',
                                10 => 'Rock Soil'
                            ];
                            if (isset($formData['soil_type'])) {
                                if ($soils[$i] != "N/A") {
                                    $soil_lvl = intval($soils[$i]);
                                    echo "<td style='padding-left:40px'>{$soilTypes[$soil_lvl]}</td>";
                                } else if ($soils[$i] == "N/A" && $vegetables[$i] == "Vegetable") {
                                    echo "<td style='padding-left:40px'>Loamy Soil</td>";
                                } else if ($soils[$i] == "N/A" && $vegetables[$i] == "Non-vegetable") {
                                    echo "<td style='padding-left:40px'>Loamy Soil</td>";
                                }
                            }
                            $humidityDescriptions = [
                                0 => '<= 10%',
                                1 => '10% - 20%',
                                2 => '20% - 30%',
                                3 => '30% - 40%',
                                4 => '40% - 50%',
                                5 => '50% - 60%',
                                6 => '60% - 70%',
                                7 => '70% - 80%',
                                8 => '80% - 90%',
                                9 => '>= 90%',
                                10 => '100%'
                            ];

                            if (isset($formData['air_humidity'])) {
                                if (isset($atmospheric_humidities[$i]) && $atmospheric_humidities[$i] != "N/A") {
                                    $humidity = intval($atmospheric_humidities[$i]);
                                    // Display the mapped atmospheric humidity in the HTML table
                                    echo "<td style='padding-left:40px'>" . $humidityDescriptions[$humidity] . "</td>";
                                } else {
                                    // If atmospheric humidity is not available, provide a default value
                                    echo "<td style='padding-left:40px'>60%</td>";
                                }
                            }

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
            <form action="" method="POST">
                <!-- <input type="submit" id="download_list_button" name="download_list_button" class="btn" style="background-color: #7cb46b;margin-left:38%" value="Download your list"> -->
            </form>


            <?php
            ?>
            <!-- <script>
                        // window.location.replace("./index.php");
                        alert("ok");
                    </script> -->
        <?php

        }
        ?>
        <?php
        if (isset($_POST['plant_id_to_delete'])) {
            $plantIdToDelete = $_POST['plant_id_to_delete'];
            $sql = "DELETE FROM users_collections_have_plants WHERE `users_collections_have_plants`.`plant_id` = '" . $plantIdToDelete . "';";
            // echo $sql;
            $result = mysqli_query($link2, $sql);
            if ($result) {
                // echo "Plant deleted successfully.";
            } else {
                echo "Failed to delete plant.";
            }
        }
        if (isset($_POST['download_list_button'])) {
        ?>
            <script>
                // window.location.replace("./index.php");
                alert("download-button-pressed");
            </script>
        <?php

            //  include './fpdf/fpdf.php';
            // //  ob_start();
            // //  require('fpdf.php');
            //  $pdf = new FPDF();
            //  $pdf->AddPage();
            //  $pdf->SetFont('Arial','B',16);
            //  $pdf->Cell(40,10,'Hello World!');
            //  $pdf->Output();
            //  ob_end_flush(); 
        }
        ?>
        <br><br>

        <!-- <h6>Preview your garden flowers & yield</h6> -->
        <?php
        // $sql= "SELECT DISTINCT plante.flower, plante.fruit, plante.plant_name FROM plante join users_collections_have_plants on users_collections_have_plants.plant_id = plante.id 
        // join users_collections on users_collections.collection_id = users_collections_have_plants.collection_id
        //  where users_collections.collection_id = ' 1 ' ORDER BY plante.plant_name ASC";


        ?>
        <!-- <br>
        <div class="row">
            <div class="col-md" style="border-right: 3px solid">
                <h6 style="text-align: center;">Flowers</h6>
                <div class="row" style="border-top:3px solid"> -->
        <?php
        // $result = mysqli_query($link, $sql);
        // if(mysqli_num_rows($result) > 0){
        //     while($row = mysqli_fetch_array($result)){
        //             
        ?>
        <!-- //             <div class="col-md" style="padding: 10px;">
                            //                 <img src="data:image/jpg;charset=utf8;base64, <?php echo base64_encode($row['flower']); ?>" alt="<?php echo $row['plant_name']; ?>" style="width: 200px; height: 200px;">
                            //             </div> -->
        <?php
        //     }

        // }
        // for ($i = 0; $i < $index; $i++) {
        //     if ($flowers[$i] != 'N/A') {

        // 
        ?>

        <!-- //         <div class="col-md" style="padding: 10px;">
                    //             <img src="<?php echo $flowers[$i]; ?> " alt="<?php echo $scientific_names[$i]; ?>" style="width: 300px; height: 250px;">
                    //         </div>
                    //  --><?php
                            //     } else {
                            //     }
                            // }
                            // 
                            ?>
        <!-- </div>
    </div>
    <div class="col-md">
        <h6 style="text-align: center;">Fruit/Yield</h6>
        <div class="row" style="border-top:3px solid">
            <?php
            for ($i = 0; $i < $index; $i++) {
                if ($fruits[$i] != 'N/A') {

            ?>
                    <div class="col-md" style="padding: 10px;">
                        <img src="<?php echo $fruits[$i]; ?>" alt="<?php echo $scientific_names[$i]; ?>" style="width: 300px; height: 250px;">
                    </div>
            <?php
                } else {
                }
            }
            ?>
        </div>
    </div>
    </div> -->
        <br><br>
        <div class="row">
            <div class="col-md">
                <h6>Your Go-To Calendar for Blooms and Fruits</h6>
            </div>
            <div class="col-md">

            </div>

        </div>
        <br>
        <div class="calendar">
            <div style="text-align: right;">
                <!-- <button id="submit_delete_calendar_checked" name="submit_delete_calendar_checked" type="submit" style="background-color: #8B0000; color: #fff; font-size: 17px;">
                        Delete checked values
                        </button><br><br> -->
            </div>
            <table id="plantTable">
                <thead>
                    <tr>
                        <th class="month">Plant Name</th>
                        <th class="month">January</th>
                        <th class="month">February</th>
                        <th class="month">March</th>
                        <th class="month">April</th>
                        <th class="month">May</th>
                        <th class="month">June</th>
                        <th class="month">July</th>
                        <th class="month">August</th>
                        <th class="month">September</th>
                        <th class="month">October</th>
                        <th class="month">November</th>
                        <th class="month">December</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $displayedPlants = array();
                    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

                    // Loop through the scientific names array to display the plants
                    for ($i = 0; $i < count($common_names); $i++) {
                        // Check if the plant has already been displayed
                        if (!in_array($common_names[$i], $displayedPlants)) {
                            echo '<tr>';

                            // Add the plant scientific name to the array of displayed plants
                            $displayedPlants[] = $common_names[$i];
                            if ($common_names[$i] == 'N/A') {
                                $common_names[$i] = $scientific_names[$i];
                            }
                            // Display the plant scientific name in the first column
                            echo '<td class="calendar-data">' . htmlspecialchars($common_names[$i]) . '</td>';

                            // Display checkboxes for each month
                            foreach ($months as $month) {
                    ?>
                                <td class="calendar-data">
                                    <input type="checkbox" value="<?php echo htmlspecialchars($common_names[$i]); ?>" class="checkbox_calendar_data">
                                </td>
                    <?php
                            }

                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>


        </div>
        <br><br>
        <!-- <div class="row">
                    <div class="col-md">
                        <h6>Set your garden size</h6>
                        <br>
                        <form method="POST">
                            <label for="planting_place">Garden Type:</label><br><p></p>

                            <select id="planting_place" name="planting_place" class="">
                                <option value="default" style="display: none;">Garden Type</option>
                                <option value="patio_and_containers">Patio, containers, balcony</option>
                                <option value="greenhouse">Greenhouse</option>
                                <option value="plot_land">Directly in land</option>
                            </select>
                            <br><br>
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
                            <button id="calculate_garden_size" name="calculate_garden_size">Calculate</button>
                        </form>

                        <?php
                        // if (isset($_POST['calculate_garden_size'])) {
                        //     $planting_place = $_POST['planting_place'];
                        //     $garden_shape = $_POST['garden_shape'];
                        //     $garden_width = $_POST['garden_width'];     
                        //     $garden_length = $_POST['garden_length'];

                        //     // Retrieve planting width of each plant (assumed spacing between plants in cm)
                        //     $plants_data = array(
                        //         'Carrot' => 10,
                        //         'Eggplant' => 30,
                        //         'Hot peppers' => 40,
                        //         'Tomato' => 25
                        //     ); // Assumed spacing between plants in cm

                        //     // Convert garden width and length to cm
                        //     $garden_width_cm = $garden_width * 100; // Convert meters to cm
                        //     $garden_length_cm = $garden_length * 100; // Convert meters to cm

                        //     // Calculate total garden area in square cm
                        //     $garden_area = $garden_width_cm * $garden_length_cm;

                        //     // Calculate the maximum number of each plant that can fit in the garden
                        //     $plants_count = array();
                        //     foreach ($plants_data as $plant_name => $plant_spacing) {
                        //         // Calculate the area required for each plant based on its spacing
                        //         $plant_area_required = pow($plant_spacing / 100, 2); // Convert cm to meters

                        //         // Calculate the maximum number of this plant that can fit in the garden
                        //         $max_plants = floor($garden_area / $plant_area_required);

                        //         // Apply the fixed percentage (25%) to determine the final number of plants for this plant
                        //         $final_plants = round($max_plants * 0.25); // 25% of the maximum

                        //         $plants_count[$plant_name] = $final_plants;
                        //     }

                        //     // Output the results
                        //     foreach ($plants_count as $plant_name => $count) {
                        //         echo "Number of $plant_name plants: $count<br>";
                        //     }
                        // }




                        if (isset($_POST['calculate_garden_size'])) {
                            $planting_place = $_POST['planting_place'];
                            $garden_shape = $_POST['garden_shape'];
                            $garden_width = $_POST['garden_width'];
                            $garden_length = $_POST['garden_length'];


                            $plants_data = array();
                            $sql = "SELECT DISTINCT plante.planting_width, plante.plant_name FROM plante
                                        JOIN users_collections_have_plants ON users_collections_have_plants.plant_id = plante.id 
                                        JOIN users_collections ON users_collections.collection_id = users_collections_have_plants.collection_id
                                        WHERE users_collections.collection_id = '1' ORDER BY plante.plant_name ASC";
                            $result = mysqli_query($link, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {

                                    $planting_width = floatval($row['planting_width']);
                                    if ($planting_width > 0) {
                                        $plants_data[$row['plant_name']] = $planting_width;
                                    }
                                }
                            }


                            $garden_area = intval($garden_width) * intval($garden_length);


                            $plants_count = array();
                            foreach ($plants_data as $plant_name => $planting_width) {
                                // CERC
                                $plant_area_required = pow($planting_width / 2, 2) * M_PI;

                                $max_plants = floor($garden_area / $plant_area_required);

                                $final_plants = round($max_plants * 0.25);

                                $plants_count[$plant_name] = $final_plants;
                            }


                            foreach ($plants_count as $plant_name => $count) {
                                echo "Number of $plant_name plants: $count<br>";
                            }
                        }
                        ?>

                    </div>
                    <div class="col-md">
                        
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
                    </div> -->
        <!-- </div> -->

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('.checkbox_calendar_data');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        var plantName = this.value;
                        var currentDate = new Date();
                        var targetDate3 = new Date(currentDate.getFullYear(), currentDate.getMonth() + 3, currentDate.getDate());
                        var targetMonth3 = targetDate3.toLocaleString('default', {
                            month: 'long'
                        });

                        var targetDate4 = new Date(currentDate.getFullYear(), currentDate.getMonth() + 4, currentDate.getDate());
                        var targetMonth4 = targetDate4.toLocaleString('default', {
                            month: 'long'
                        });

                        var targetDate5 = new Date(currentDate.getFullYear(), currentDate.getMonth() + 5, currentDate.getDate());
                        var targetMonth5 = targetDate5.toLocaleString('default', {
                            month: 'long'
                        });

                        // Find the cell 3, 4, and 5 months later and update their values
                        var tableRow = this.closest('tr');
                        var index = Array.from(tableRow.children).indexOf(this.parentNode);
                        var targetCell3 = tableRow.children[index + 3];
                        var targetCell4 = tableRow.children[index + 4];
                        var targetCell5 = tableRow.children[index + 5];

                        if (targetCell3) {
                            targetCell3.textContent = plantName + ' (next harvest)';
                        }
                        if (targetCell4) {
                            targetCell4.textContent = plantName + ' (next harvest)';
                        }
                        if (targetCell5) {
                            targetCell5.textContent = plantName + ' (next harvest)';
                        }
                    } else {
                        // If unchecked, clear the values in the corresponding cells
                        var tableRow = this.closest('tr');
                        var index = Array.from(tableRow.children).indexOf(this.parentNode);
                        var targetCell3 = tableRow.children[index + 3];
                        var targetCell4 = tableRow.children[index + 4];
                        var targetCell5 = tableRow.children[index + 5];

                        if (targetCell3) {
                            targetCell3.textContent = '';
                            var checkbox3 = targetCell3.querySelector('.checkbox_calendar_data');
                            if (checkbox3) {
                                checkbox3.checked = false;
                                checkbox3.style.display = 'inline-block'; // Show checkbox
                            }
                        }
                        if (targetCell4) {
                            targetCell4.textContent = '';
                            var checkbox4 = targetCell4.querySelector('.checkbox_calendar_data');
                            if (checkbox4) {
                                checkbox4.checked = false;
                                checkbox4.style.display = 'inline-block'; // Show checkbox
                            }
                        }
                        if (targetCell5) {
                            targetCell5.textContent = '';
                            var checkbox5 = targetCell5.querySelector('.checkbox_calendar_data');
                            if (checkbox5) {
                                checkbox5.checked = false;
                                checkbox5.style.display = 'inline-block'; // Show checkbox
                            }
                        }
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            // Function to adjust input values if sum exceeds 100
            function adjustTotalPercentage() {
                var totalPercentage = 0;
                // Calculate total percentage
                $('input[type="number"]').each(function() {
                    totalPercentage += parseInt($(this).val()) || 0;
                });
                // If total exceeds 100, adjust values
                if (totalPercentage > 100) {
                    var remainingPercentage = totalPercentage - 100;
                    // Distribute remaining percentage among inputs
                    $('input[type="number"]').each(function() {
                        var currentValue = parseInt($(this).val()) || 0;
                        var adjustedValue = currentValue - Math.round((currentValue / totalPercentage) * remainingPercentage);
                        $(this).val(adjustedValue);
                    });
                }
            }

            // Function to evenly distribute 100% among inputs
            function distributeInitialValues() {
                var inputs = $('input[type="number"]');
                var initialValue = Math.floor(100 / inputs.length); // Initial value for each input
                var remainder = 100 % inputs.length; // Remainder after evenly distributing
                inputs.val(initialValue); // Set initial value for all inputs
                // Adjust values to account for remainder
                for (var i = 0; i < remainder; i++) {
                    $(inputs[i]).val(initialValue + 1);
                }
                adjustTotalPercentage(); // Adjust total percentage
            }

            distributeInitialValues(); // Call function when page loads

            // var tdValue = parseFloat($('#plant_<?php echo $row['plant_name'] ?>').val()); // Assuming the value is numeric

            // // Set the value of the hidden input field
            // $('#hidden_plant_<?php echo $row['plant_name'] ?>').val(tdValue);

            // Event listener for input changes
            $('input[type="number"]').change(function() {
                var max = parseInt($(this).attr('max'));
                var min = parseInt($(this).attr('min'));
                var value = parseInt($(this).val());
                // Ensure value is within bounds
                if (value > max) {
                    $(this).val(max);
                } else if (value < min) {
                    $(this).val(min);
                }
                adjustTotalPercentage(); // Adjust total percentage
            });
        });
    </script>

    <script>
        function redirectOnChange() {
            var selectElement = document.getElementById("planting_place");
            var selectedValue = selectElement.value;
            if (selectedValue == "new_collection") {
                document.getElementById("redirectForm").submit();
            }
        }
    </script>

    <!-- <script src="jquery-3.6.1.js"></script> -->

    <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script> <!-- Include Bootstrap JS -->
</body>

</html>