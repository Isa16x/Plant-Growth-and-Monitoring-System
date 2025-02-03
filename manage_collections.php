<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['email'])) {
    $common_names = [];
    $scientific_names = [];
    $vegetables = [];
    $image_urls = [];
    $ids = [];
    $spacing = [];
?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
        <title>Manage your collections</title>
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
        include "meniu.php";
        ?>

        <br><br><br><br>
        <h1 class="titlu_pag_cat"> Manage your collections</h1>
        <br><br><br><br>
        <div class="page_interior">
            <?php
            $hasCol = 0;
            $collectionsIDS = array();
            $collectionsNAMES = array();
            $indexForCollections = 0;

            if (isset($_SESSION['email'])) {
                $sqlbun = "SELECT DISTINCT col.collection_id, col.collection_name FROM users 
                JOIN users_have_users_collections AS in1 ON in1.user_email = users.email 
                JOIN users_collections AS col ON col.collection_id = in1.collection_id 
                WHERE users.email ='" . $_SESSION['email'] . "';";

                $resultbun = mysqli_query($link2, $sqlbun);

                if ($resultbun) {
                    if (mysqli_num_rows($resultbun) > 0) {
                        $hasCol = 1;
                        while ($row = mysqli_fetch_array($resultbun)) {
                            $collectionsIDS[$indexForCollections] = $row['collection_id'];
                            $collectionsNAMES[$indexForCollections] = $row['collection_name'];
                            $indexForCollections++;
                        }
                    } else {
                        echo "No collections associated with this account. Please create a new collection.";
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($link2);
                }

                for ($i = 0; $i < $indexForCollections; $i++) {
            ?>
                    <div class="row">
                        <div class="col-sm column-for-display" style="background-image: linear-gradient(to right, #FFFFE0, #B0E0E6);">
                            <br>
                            <h5 style="text-align: center;">Current collections for email: <?php echo $_SESSION['email']; ?></h5>
                            <div class="row">
                                <div class="col-sm small-columns-for-comparing" style="margin-left:30px">
                                    <form action="" method="POST">
                                        <p style="text-align: center;"><i>Present collections:</i> </p>
                                        <p></p>
                                        <?php
                                        for ($i = 0; $i < count($collectionsIDS); $i++) {
                                            $value = $collectionsNAMES[$i];
                                            $collectionID = $collectionsIDS[$i];
                                        ?>
                                            <div class="row">
                                                <div class="col-sm">
                                                    <p class="" style="text-align: center;"><?php echo $value; ?></p>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="submit" name="see_plants_collection" class="btn btn-primary" style="background-color: #E0B0FF;color:black" value="<?php echo $collectionID; ?>">Plants</button>
                                                    <button type="submit" name="delete_collection" class="btn btn-danger" value="<?php echo $collectionID; ?>">Delete</button>
                                                </div>
                                            </div>
                                            <br>
                                        <?php
                                        }
                                        ?>
                                        <br>
                                    </form>
                                    <?php
                                    if (isset($_POST['delete_collection'])) {
                                        $collectionIDToDelete = $_POST['delete_collection'];
                                        $sql = "DELETE FROM users_collections WHERE collection_id = " . $collectionIDToDelete;
                                        $result = mysqli_query($link2, $sql);

                                        if ($result) {
                                            echo "Collection deleted successfully.";
                                        } else {
                                            echo "Error deleting collection: " . mysqli_error($link2);
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-7 small-columns-for-comparing">
                                    <?php
                                    if (isset($_POST['see_plants_collection'])) {
                                        $hasPlants = 0;
                                        $collectionIDToShowPlants = $_POST['see_plants_collection'];
                                        $common_names = [];
                                        $scientific_names = [];
                                        $vegetables = [];
                                        $image_urls = [];
                                        $ids = [];
                                        $spacing = [];

                                        $sqlGETplants = "SELECT DISTINCT plant_id FROM users 
                                        JOIN users_have_users_collections AS in1 ON in1.user_email = users.email 
                                        JOIN users_collections AS col ON col.collection_id = in1.collection_id
                                        JOIN users_collections_have_plants ON col.collection_id = users_collections_have_plants.collection_id
                                        WHERE users.email = '" . $_SESSION['email'] . "' AND col.collection_id = " . $collectionIDToShowPlants . ";";

                                        $result = mysqli_query($link2, $sqlGETplants);

                                        while ($row = mysqli_fetch_array($result)) {
                                            $hasPlants = 1;
                                            $id = $row['plant_id'];
                                            $apiUrl = "https://trefle.io/api/v1/species/" . $id . "?token=Vy051Qi6ZyqmkINehigaDTrMmdmq_qIXh3b652mdL60";
                                            $contextOptions = [
                                                "ssl" => [
                                                    "verify_peer" => false,
                                                    "verify_peer_name" => false,
                                                ],
                                            ];

                                            $context = stream_context_create($contextOptions);
                                            $response = file_get_contents($apiUrl, false, $context);

                                            if ($response !== FALSE) {
                                                $plants = json_decode($response, true);

                                                if (isset($plants['data']) && !empty($plants['data'])) {
                                                    $common_names[] = htmlspecialchars($plants['data']['common_name'] ?? 'N/A');
                                                    $scientific_names[] = htmlspecialchars($plants['data']['scientific_name'] ?? 'N/A');
                                                    $vegetables[] = htmlspecialchars(isset($plants['data']['vegetable']) ? ($plants['data']['vegetable'] ? 'true' : 'false') : 'N/A');
                                                    $image_urls[] = htmlspecialchars($plants['data']['image_url'] ?? 'N/A');
                                                    $ids[] = htmlspecialchars($plants['data']['id'] ?? 'N/A');
                                                    $spacing[] = htmlspecialchars($plants['data']['row_spacing']['cm'] ?? 'N/A');
                                                }
                                            }
                                        }

                                        if ($hasPlants == 1) {
                                    ?>
                                            <div class="plants_preview_corner">
                                                <table id="table_plants_from_collection" class="center">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th style='padding-right:40px'>Percentage</th> -->
                                                            <th>Picture</th>
                                                            <th style='padding-left:40px'>Plant Name</th>
                                                            <th style='padding-left:40px'>Plant Species</th>
                                                            <th style='padding-left:40px'>Plant Type</th>
                                                            <th style='padding-left:40px'>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($i = 0; $i < count($common_names); $i++) {
                                                            echo "<tr>";
                                                            // echo "<td style='padding-right:40px'><input type='number' id='plant_{$i}' name='plant_{$i}' min='1' max='100' style='width:49px'/>%</td>";
                                                            // echo "<input type='hidden' id='hidden_plant_{$i}' name='hidden_plant_{$i}' value='{$common_names[$i]}'>";
                                                            echo "<td style='padding-left:40px'><img src='{$image_urls[$i]}' alt='{$common_names[$i]}' style='width:100px; height:100px'/></td>";
                                                            echo "<td style='padding-left:40px'>{$common_names[$i]}</td>";
                                                            echo "<td style='padding-left:40px'>{$scientific_names[$i]}</td>";
                                                            echo "<td style='padding-left:40px'>" . ($vegetables[$i] == "true" ? "Vegetable" : "Non-vegetable") . "</td>";
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
                                    <?php
                                        }
                                    }
                                    if (isset($_POST['plant_id_to_delete'])) {
                                        $plantIdToDelete = $_POST['plant_id_to_delete'];
                                        $sql = "DELETE FROM users_collections_have_plants WHERE `users_collections_have_plants`.`plant_id` = '" . $plantIdToDelete . "';";
                                        // echo $sql;
                                        $result = mysqli_query($link2, $sql);
                                        if ($result) {
                                            echo "<script>
                                            window.location.href = 'manage_collections.php';
                                        </script>";
                                            echo "Plant deleted successfully.";
                                        } else {
                                            echo "Failed to delete plant.";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm column-create-col" style="background-image: linear-gradient(to right, #FFFFE0, #FFB0CB);">
                            <br>
                            <h5 style="text-align: center;">Create a new collection</h5>
                            <div class="row">
                                <div class="col-sm small-columns-for-comparing" style="margin-left:30px">
                                    <form method="post">
                                        <div class="form-group row">
                                            <label for="collection_name" class="col-sm" style="text-align: center; margin-top:8px">Collection name:</label>
                                            <input type="text" class="form-control col-sm" id="collection_name" name="collection_name" placeholder="Enter collection name" style="width:200px" required>
                                            <div class="col-sm">

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm">

                                            </div>
                                            <div class="col-sm">
                                                <button type="submit" id="create_collection" name="create_collection" class="btn btn-info" style="background-color: #E0B0FF;">Create collection</button>
                                            </div>
                                            <div class="col-sm">

                                            </div>
                                        </div>


                                    </form>

                                    <?php

                                    if (isset($_POST['create_collection'])) {
                                        $collection_name = $_POST['collection_name'];
                                        $sql = "INSERT INTO users_collections (collection_name) VALUES ('$collection_name');";
                                        $result = mysqli_query($link2, $sql);
                                        if ($result) {
                                            $last_inserted_id = mysqli_insert_id($link2);
                                            echo "Collection created successfully.";
                                        } else {
                                            echo "Failed to create collection.";
                                        }
                                        $sql2 = "INSERT INTO `users_have_users_collections` (user_email, collection_id) VALUES ('" . $_SESSION['email'] . "', '" . $last_inserted_id . "') ";
                                        $result2 = mysqli_query($link2, $sql2);
                                        if ($result2) {
                                            // $last_inserted_id = mysqli_insert_id($link2);
                                            echo "Connection created successfully.";
                                            echo "<script>
                                            window.location.href = 'manage_collections.php';
                                        </script>";
                                        } else {
                                            echo "Failed to create collection.";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">

                        </div>


                    </div>
            <?php
                }
            } else {
                echo '<h3>You are not logged in</h3>';
            }
            ?>
        </div>
    </body>

    </html>

<?php
}
?>