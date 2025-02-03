<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Plant Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis:wght@200&family=Montserrat:wght@200&family=Sacramento&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-countries/dist/leaflet-countries.min.js"></script>
</head>

<body>
    <link rel="stylesheet" href="./ism/css/my-slider.css" />
    <script src="./ism/js/ism-2.2.min.js"></script>
    <?php
    include "conectarebd.php";
    include "meniu.php";
    ?>

    <br><br><br><br>
    <?php
    $id = $_GET['id'];

    if (isset($id)) {
        // $apiUrl = "https://trefle.io/api/v1/species/" . urlencode($id) . "?token=Vy051Qi6ZyqmkINehigaDTrMmdmq_qIXh3b652mdL60";
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
        // Fetch the API response

        if (!empty($response)) {
            $plants = json_decode($response, true);
            // $plants = $plants[0];
            $plants['data'] = $plants['data'][0];
            // print_r($plants['data']);
            if (!empty($plants['data'])) {
                $common_name = htmlspecialchars($plants['data']['common_name'] ?? 'N/A');
                $scientific_name = htmlspecialchars($plants['data']['scientific_name'] ?? 'N/A');
                $slug = htmlspecialchars($plants['data']['slug'] ?? 'N/A');
                $family = htmlspecialchars($plants['data']['family'] ?? 'N/A');
                $family_common_name = htmlspecialchars($plants['data']['family_common_name'] ?? 'N/A');
                $genus = htmlspecialchars($plants['data']['genus'] ?? 'N/A');
                $image_url = htmlspecialchars($plants['data']['image_url'] ?? 'N/A');
                $rank = htmlspecialchars($plants['data']['rank'] ?? 'N/A');
                $vegetable = htmlspecialchars(isset($plants['data']['vegetable']) ? ($plants['data']['vegetable'] ? 'true' : 'false') : 'N/A');
                $family_common_name = htmlspecialchars($plants['data']['family_common_name'] ?? 'N/A');
                $appearance_year = htmlspecialchars($plants['data']['year'] ?? 'N/A');
                $id = htmlspecialchars($plants['data']['id'] ?? 'N/A');
                $observations = $plants['data']['observations'];
                $images = $plants['data']['image_url'];
                $edible = htmlspecialchars($plants['data']['edible'] ?? 'N/A');
                $edible_parts = htmlspecialchars($plants['data']['edible_parts'] ?? 'N/A');
                $common_names_for_plant = $plants['data']['common_names'];
                $synonyms = $plants['data']['synonyms'];
                $growth_habit = htmlspecialchars($plants['data']['specifications']['growth_habit'] ?? 'N/A');
                $average_height = htmlspecialchars($plants['data']['specifications']['average_height']['cm'] ?? 'N/A');
                $distributions = $plants['data']['distributions']['native'];
                // $leafimages = $plants['data']['images']['leaf'];
    ?>

                <h1 class="titlu_graph">Details about <?php echo $common_name; ?></h1>
                <br><br><br><br>
                <div class="page_interior">
                    <?php

                    ?>
                    <div class="row">
                        <div class="ism-slider col-sm" style="height:500px; width:500px" data-transition_type="fade" data-play_type="loop" id="my-slider">
                            <ol>
                                <?php
                                // foreach ($images as $image) {
                                //TODO: nu am ce sa ii fac am doar un image url in db 
                                if (isset($images)) {
                                ?>
                                    <li>
                                        <img src="<?php echo htmlspecialchars($images); ?>">
                                        <!-- Add a caption if needed -->
                                    </li>
                                <?php
                                }
                                // }
                                ?>
                            </ol>
                        </div>

                    </div>
                    <?php //echo $family; 
                    ?>

                    <div class="row" style="margin-top:20px">
                        <div class="col-sm" style="margin-left: 50px"> <!-- data div -->
                            <?php
                            if ($common_name == "N/A" && $scientific_name != "N/A") {
                                $common_name = $scientific_name;
                            } ?>
                            <p><b><i>Common name:</i></b> <?php echo $common_name; ?></p>
                            <p><b><i>Scientific name:</i></b> <?php echo $scientific_name; ?></p>
                            <!-- <p>Slug: <?php echo $slug; ?></p> -->
                            <?php
                            if ($family == "N/A" && $family_common_name != "N/A") {
                                $family = $family_common_name;
                            } else if ($family == "N/A" && $family_common_name == "N/A") {
                                $family = "No data.";
                            }
                            ?>
                            <p><b><i>Family: </i></b><?php echo $family; ?></p>
                            <p><b><i>Plant subdivision:</i></b> <?php echo $genus; ?></p>
                            <p><b><i>Rank:</i></b> <?php echo $rank; ?></p>
                            <?php
                            if ($vegetable == 'true') {
                            ?>
                                <p>The plant <b><i>is</b></i> a vegetable.</p>
                            <?php
                            } else if ($vegetable == 'false') {
                            ?>
                                <p>The plant is <b>not </b>a vegetable.</p>
                            <?php
                            } else {
                            ?>
                                <p><b><i>No data available if it's a vegetable or not.</i></b></p>
                            <?php
                            }
                            // print_r($observations);
                            ?>
                            <!-- <p>Vegetable: <?php echo $vegetable; ?></p> -->
                            <p> <b><i>Family common name:</i></b> <?php echo $family_common_name; ?></p>
                            <p><b><i>Appearance year:</i></b> <?php echo $appearance_year - 2; ?></p>
                            <?php
                            //echo gettype($appearance_year); 
                            ?>
                            <p><b><i>The plant has been observed growing naturally in:</i></b> <?php echo $observations[0]; ?> to <?php echo $observations[count($observations) - 1]; ?></p>
                            <?php
                            if ((isset($edible) && $edible == 'true') || $vegetable == 'true') {
                            ?>
                                <p>The plant <b>is</b> edible.</p>
                                <?php
                                if (isset($edible_parts)) {
                                    if ($vegetable == 'true') {
                                        $edible_parts = 'fruit';
                                    }
                                ?><p><b><i>The part(s) that can be eaten:</i></b> <?php echo $edible_parts; ?></p><?php
                                                                                                                }
                                                                                                            } else {
                                                                                                                    ?>
                                <p>The plant is <b>not </b>edible.</p>
                            <?php
                                                                                                            }
                            ?>

                        </div>
                        <div class="col-sm">


                            <?php
                            if ((!isset($common_names_for_plant) && isset($synonyms)) || ($common_names_for_plant == "N/A"
                                    && $synonyms != "N/A") || ($common_names_for_plant == NULL && $synonyms != NULL)
                            ) {
                                $common_names_for_plant = $synonyms;
                                $common_names = explode(',', $common_names_for_plant);
                            } else {
                                $common_names = $common_names_for_plant;
                            }
                            if (isset($common_names_for_plant)) {
                            ?>
                                <p><b><i>Other names for the plant:</i></b> <?php echo "<br>";

                                                                            if ($common_names != "N/A" || $common_names != NULL) {
                                                                                foreach ($common_names as $common_name) {
                                                                                    echo $common_name;
                                                                                    echo "<br>";
                                                                                }
                                                                            } else {
                                                                                echo "No data.";
                                                                            } ?></p><?php
                                                                                }
                                                                                if ($growth_habit != 'N/A') {
                                                                                    ?>
                                <p><b><i>Grows as:</i></b> <?php echo $growth_habit; ?></p>
                            <?php
                                                                                }
                                                                                if ($average_height != 'N/A' && str_contains($average_height, '.0')) {
                                                                                    // echo gettype($average_height);
                            ?>
                                <p><b><i>Average height:</i></b> <?php echo $average_height - 2; ?> cm</p>
                            <?php
                                                                                    // echo gettype($average_height);
                                                                                } else if ($average_height != 'N/A' && str_contains($average_height, '.0')) {
                            ?>
                                <p><b><i>Average height:</i></b> <?php echo $average_height; ?> cm</p>
                            <?php
                                                                                }

                            ?>
                        </div>
                    </div>
                    <div class="table" style="margin-left:200px">
                        <p>Map for plant distributions:</p>
                        <!-- <table id="plant_count_table" class="display" style="margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Country name</th>
                                    <th style="text-align: center;">Species count</th>
                                </tr>
                            </thead>
                            <tbody>-->
                        <?php
                        // foreach ($distributions as $distribution) {
                        //TODO: nici aici nu am destule date 
                        //in ce format veneau cand apelai dupa id ??
                        echo "<input type='hidden' id='plants-to-use-for-map' value='" . implode(",", $distributions['name']) . "'/>";
                        echo "<tr>";
                        // echo "<td>" . implode(",", $distributions['name']) . "</td>";
                        // echo "<td style='text-align: center;'>" . $distributions['species_count'] . "</td>";
                        echo "</tr>";
                        // }
                        ?>
                        <!--  </tbody>

                        </table> -->
                        <div id="map" style="height: 600px; width: 900px"></div>
                    </div>
                    <br>




                    <div style="margin: 0 auto;text-align: center">
                        <br>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="button" id="add_collection_button" name="add_collection_button" class="add-to-collection-btn" data-bs-toggle="modal" data-bs-target="#addToCollectionModal">Add to Collection</button>
                        </form>
                        <!-- <form method="POST" action="" >
                    <button id="add_collection_button" name="add_collection_button" class="add-to-collection-btn" >Add to Collection</button>
                </form> -->
                        <br>
                    </div>

                    <?php

                    ?>
                </div>

                </div>
    <?php
            } else {
                echo "No results found for the given plant ID.";
            }
        } else {
            echo "Error fetching data from the API.";
        }
    } else {
        echo "Invalid plant ID.";
    }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="addToCollectionModal" tabindex="-1" aria-labelledby="addToCollectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToCollectionModalLabel">Add Plant to Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="redirectForm" method="POST">
                        <div class="mb-3">
                            <label for="collection_id" class="form-label">Choose a Collection</label><br>
                            <select id="collection_id" name="collection_id" onchange="redirectOnChange()">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" id="add_col_button_true_one" name="add_col_button_true_one" class="btn btn-primary">Add to Collection</button>
                    </form>

                    <?php
                    if (isset($_POST["add_col_button_true_one"])) {
                        $collection_id = $_POST['collection_id'];
                        if ($collection_id != "new_collection") {
                            $plant_id = $_POST['id'];


                            $sql = "INSERT INTO users_collections_have_plants (collection_id, plant_id) VALUES ('$collection_id', '$plant_id')";
                            if (mysqli_query($link2, $sql)) {
                                echo "Plant added to collection.";
                            } else {
                                echo "ERROR: Could not execute $sql. " . mysqli_error($link2);
                            }
                        }
                        if ($collection_id == "new_collection") {
                            echo 'esti prost';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- ISM Slider JS -->
    <script src="./ism/js/ism-2.2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#plant_count_table').DataTable();
        });
    </script>
    <script>
        function redirectOnChange() {
            var selectElement = document.getElementById("collection_id");
            var selectedValue = selectElement.value;
            if (selectedValue == "new_collection") {
                window.location.href = "new_collection.php";
            }
        }
    </script>
    <script>
        function style(feature) {
            // var distributions = $('#plants-to-use-for-map').val().split(',');
            if ($.inArray(feature.properties.name, distributions) >= 0) {
                return {
                    fillColor: 'green',
                    weight: 2,
                    opacity: 1,
                    color: 'yellow',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            } else {
                return {
                    fillColor: 'gray',
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }
            // console.log(distributions);
            // console.log(feature.properties.name); // Print the feature.properties.name
            // switch (feature.properties.name) {
            //     case 'France':
            //         return {
            //             fillColor: 'blue', weight: 2, opacity: 1, color: 'white', dashArray: '3', fillOpacity: 0.7
            //         };
            //     case $.inArray(feature.properties.name, distributions) >= 0:
            //         console.log(feature.properties.name);
            //         return {
            //             fillColor: 'red', weight: 2, opacity: 1, color: 'white', dashArray: '3', fillOpacity: 0.7
            //         };
            //         // default:
            //         //     return {};
            //     default:
            //         return {
            //             fillColor: 'gray', weight: 2, opacity: 1, color: 'white', dashArray: '3', fillOpacity: 0.7
            //         };
            // }
        }

        // Initialize the map
        var map = L.map('map').setView([20.0, 0.0], 2);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Define the countries you want to highlight
        // var distributions = ["Canada", "United States", "Mexico", "Brazil"];

        // Loop through the distributions array and add countries to the map
        // distributions.forEach(function(country) {
        //     L.countrySelect(country, {
        //         fillColor: "#2e8b57", // Green color
        //         color: "#2e8b57", // White border
        //         weight: 2,
        //         opacity: 1,
        //         fillOpacity: 0.7
        //     }).addTo(map);
        // });

        /////////
        // Function to style the GeoJSON features
        var distributions = $('#plants-to-use-for-map').val().split(',');

        // Load GeoJSON data
        fetch('custom.geo.json')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Add GeoJSON layer to the map
                L.geoJSON(data, {
                    style: style,
                    // distributions: distributions
                }).addTo(map);
            });
    </script>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
</body>

</html>