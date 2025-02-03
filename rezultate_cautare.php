<?php if (!isset($_SESSION)) {
    session_start();
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

    <title>Design your garden</title>
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
    <style>
        .modal-backdrop {
            z-index: -1;
            /* Default Bootstrap backdrop z-index */
        }

        .modal {
            z-index: 1050;
            /* Default Bootstrap modal z-index */
        }

        .btn {
            background-color: #98FF98 !important;
            color: black !important;
            border-color: black !important;
        }
    </style>


</head>

<body>
    <?php
    include "conectarebd.php";
    ?>
    <?php include "meniu.php"; ?>
    <br>
    <br><br><br><br>
    <h1 class="titlu_pag_cat"><?php echo $_GET['keyword']; ?></h1>
    <br>
    <br>
    <br>
    <br>
    <div class="page_interior">
        <div class="card-container" style="margin-top: 3%;">
            <?php
            $keyword = $_GET['keyword'];
            if (isset($keyword)) {

                $sql = "SELECT * FROM plante where plante.rank = 'species' AND (plante.common_name LIKE '%" . $keyword . "%' OR plante.scientific_name LIKE '%" . $keyword . "%');";
                echo "";
                $bazadedate = 'csv_db_11';
                $userdb = 'root';
                $parola = '';

                // $conn = new mysqli("localhost", $userdb, $parola, $bazadedate);
                $link3 = mysqli_connect("localhost", $userdb, $parola, $bazadedate);
                if ($link3 === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }
                // PT API
                // $images_array = array();

                // function fetch_image_url($apiUrl)
                // {
                //     $ch = curl_init();
                //     curl_setopt($ch, CURLOPT_URL, $apiUrl);
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for simplicity; enable in production
                //     $response = curl_exec($ch);
                //     if (curl_errno($ch)) {
                //         echo 'Error:' . curl_error($ch);
                //         curl_close($ch);
                //         return false;
                //     }
                //     curl_close($ch);
                //     return $response;
                // }

                // // Fetch image URLs from Pixabay API

                // if ($result = mysqli_query($link3, $sql)) {
                //     if (mysqli_num_rows($result) > 0) {
                //         while ($row = mysqli_fetch_array($result)) {
                //             $id = $row['id'];
                //             $scientific_name = $row['scientific_name'];
                //             $plantsearchterm = str_replace(' ', '+', $scientific_name);
                //             // echo $plantsearchterm;


                //             if (isset($_SESSION['image_cache'][$scientific_name])) {
                //                 $images_array[$scientific_name] = $_SESSION['image_cache'][$scientific_name];
                //             } else {
                //                 // Fetch from Pixabay API
                //                 $apiUrl = "https://pixabay.com/api/?key=44695603-3027f92f8137dfabe01ab46b6&q=" . $plantsearchterm . "&image_type=photo";

                //                 $response = fetch_image_url($apiUrl);

                //                 if ($response !== FALSE) {
                //                     $pictures = json_decode($response, true);

                //                     if (isset($pictures['hits']) && count($pictures['hits']) > 0) {
                //                         $image_url = $pictures['hits'][0]['webformatURL'];
                //                         $images_array[$scientific_name] = $image_url;

                //                         // Store in session cache for next time
                //                         $_SESSION['image_cache'][$scientific_name] = $image_url;
                //                     } else {
                //                         $images_array[$scientific_name] = "N/A";
                //                     }
                //                 } else {
                //                     $images_array[$scientific_name] = "Error fetching image";
                //                 }
                //             }
                //             // Update the database with the fetched image URL
                //             $update_sql = "UPDATE plante SET image_url = ? WHERE id = ?";
                //             if ($stmt = mysqli_prepare($link3, $update_sql)) {
                //                 mysqli_stmt_bind_param($stmt, 'si', $image_url, $id);
                //                 mysqli_stmt_execute($stmt);
                //                 mysqli_stmt_close($stmt);
                //             } else {
                //                 echo "ERROR: Could not prepare query: $update_sql. " . mysqli_error($link3);
                //             }


                //             // if ($response !== FALSE) {
                //             //     $pictures = json_decode($response, true);

                //             //     if (isset($pictures['hits']) && count($pictures['hits']) > 0) {
                //             //         $image_url = $pictures['hits'][0]['webformatURL'];
                //             //         $images_array[] = $image_url;

                //             //         // Store in session cache
                //             //         $_SESSION['image_cache'][$scientific_name] = $image_url;
                //             //     } else {
                //             //         $images_array[] = "N/A";
                //             //     }
                //             // } else {
                //             //     $images_array[] = "Error fetching image";
                //             // }
                //         }
                //     }
                // }




                // $result = mysqli_query($link3, $sql);
                if ($result = mysqli_query($link3, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "Results for '" . $keyword . "':<br><br>";
                        $index = 3;
                        echo "<div class='row'>";
                        while ($row = mysqli_fetch_array($result)) {

                            if ($index % 3 == 0 && $index == 3) {
                                echo "<div class='row'>";
                            }
                            if ($index % 3 == 0) {
                                echo "</div>";
                                echo "<div class='row'>";
                            }
                            $index++;
                            $common_name = $row['common_name'];
                            $scientific_name = $row['scientific_name'];
                            $family = $row['family'];
                            $genus = $row['genus'];
                            $image_url = $row['image_url'];
                            $rank = $row['rank'];
                            $vegetable = $row['vegetable'] ? 'true' : 'false';
                            $family_common_name = $row['family_common_name'];
                            $appearance_year = $row['year'];
                            $id = $row['id'];

            ?>
                            <div class="card-plant col-sm" style="background-color: #ecfce8!important;">
                                <?php
                                if ($image_url != 'N/A' || $image_url != NULL) {
                                ?>
                                    <img src="<?php echo $image_url; ?>" alt="<?php echo $scientific_name; ?>" width="320px" height="250px">

                                <?php
                                } else {
                                ?>
                                    <img src="./imagini/generic_plant.jpg" alt="<?php echo $scientific_name; ?>" width="320px" height="250px">
                                <?php
                                }
                                ?>
                                <br><br>
                                <h2><?php echo $common_name != 'N/A' ? $common_name : $scientific_name; ?></h2>
                                <p><strong>Species:</strong> <?php echo $scientific_name; ?></p>
                                <p><strong>Plant Type:</strong> <?php echo $rank; ?></p>
                                <p><strong>Known year:</strong> <?php echo $appearance_year - 0; ?></p>
                                <br>
                                <a href="plant_details.php?id=<?php echo $id; ?>"><button style="background-color: #FFFFE0; border-radius: 6px;">Read More</button></a>
                                <br><br>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="button" class="btn btn-primary" onclick="openAddToCollectionModal(<?php echo $id; ?>)">Add to Collection</button>
                                </form>
                                <br>
                            </div>
            <?php
                        }
                        echo "</div>";
                    } else {
                        echo "No results found for '" . htmlspecialchars($keyword) . "'.";
                    }
                } else {
                    echo "Error fetching data from the database.";
                }
            }


            ?>
        </div>
    </div>

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
                                <?php
                                $sql = "SELECT * FROM users_collections JOIN users_have_users_collections
                                    ON users_collections.collection_id = users_have_users_collections.collection_id 
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
                        </div>
                        <input type="hidden" id="plant_id" name="id" value="">
                        <button type="submit" id="add_col_button_true_one" name="add_col_button_true_one" class="btn btn-add-to-col">Add to Collection</button>
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

    <script>
        function openAddToCollectionModal(plantId) {
            document.getElementById('plant_id').value = plantId;
            var myModal = new bootstrap.Modal(document.getElementById('addToCollectionModal'), {
                keyboard: false
            });
            myModal.show();
        }
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
    <script src="jquery-3.6.1.js"></script>

</body>

</html>