<?php if (!isset($_SESSION)) {
  session_start();
//   echo session_id();
  $_SESSION['id'] = session_id();
  }
//   echo session_id();
  ?>
<?php
// session_start();
// echo $_SESSION['id'];
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
        <title>Plant Finder</title>
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
            .add-to-collection-btn {
                padding: 10px 20px !important;
                background-color: #FFD166 !important;
                color: white !important;
                border: none !important;
                border-radius: 5px !important;
                cursor: pointer !important;
                font-size: 16px !important;
                transition: background-color 0.3s ease !important;
            }

            /* Hover effect */
            .add-to-collection-btn:hover {
                background-color: darkred !important;
            }
            .form-needed{
                font-family: 'Cormorant', serif;
                font-size: 22px;
            }
            .titlu_pag_cat{
                font-family: 'Great Vibes', cursive;
            }
            input[type="checkbox"] {
                /* Your styling here */
                /* For example: */
                margin-right: 5px;
                width: 20px;
                height: 20px;
                cursor: pointer;
                /* Add any other styles you want */
            }
            input[type="checkbox"]:checked {
                /* Your styling here */
                /* For example: */
                background-color: lightblue;
                color: lightgreen;
            }
           
            .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            }

            /* Individual card */
            .card {
            width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Card title */
            .card h2 {
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 10px;
            }

            /* Card info */
            .card p {
            margin: 5px 0;
            }

            /* Plant image */
            .card img {
            width: 100%;
            border-radius: 5px;
            height: 290px;
            }

            /* Button */
            /* Button */
            .card button {
            padding: 10px 20px;
            background-color: #8BC34A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            }

            /* Button hover effect */
            .card button:hover {
            background-color: #7cb342;
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
   <h1 class="titlu_pag_cat">Plant Finder</h1>
    <br>
    <br>
    <br>
    <br>
    <div>
    <?php 
        function generateSQL($formData, $link) {
            $conditions = array();

            // Check plant name 
            if (!empty($formData['search'])) {
                $search = mysqli_real_escape_string($link, $formData['search']);
                $conditions[] = "plant_name LIKE '%$search%' OR plant_species LIKE '%$search%'";
            }
        
            // Check plant type
            if ($formData['plant_type'] !== 'default') {
                $plant_type = mysqli_real_escape_string($link, $formData['plant_type']);
                $conditions[] = "plant_type = '$plant_type'";
            }
        
            // Check water needs
            $water_conditions = array();
            if (isset($formData['water_low'])) {
                $water_conditions[] = "water_needs = 'Low'";
            }
            if (isset($formData['water_medium'])) {
                $water_conditions[] = "water_needs = 'Medium'";
            }
            if (isset($formData['water_high'])) {
                $water_conditions[] = "water_needs = 'High'";
            }
            if (!empty($water_conditions)) {
                $conditions[] = "(" . implode(" OR ", $water_conditions) . ")";
            }
        
            // Check light level
            $light_conditions = array();
            if (isset($formData['light_low'])) {
                $light_conditions[] = "light_lv = 'Low'";
            }
            if (isset($formData['light_medium'])) {
                $light_conditions[] = "light_lv = 'Medium'";
            }
            if (isset($formData['light_high'])) {
                $light_conditions[] = "light_lv = 'High'";
            }
            if (!empty($light_conditions)) {
                $conditions[] = "(" . implode(" OR ", $light_conditions) . ")";
            }
        
            // Check maintenance needs
            $maintenance_conditions = array();
            if (isset($formData['maintenance_low'])) {
                $maintenance_conditions[] = "maintanence_lv = 'Low'";
            }
            if (isset($formData['maintenance_medium'])) {
                $maintenance_conditions[] = "maintanence_lv = 'Medium'";
            }
            if (isset($formData['maintenance_high'])) {
                $maintenance_conditions[] = "maintanence_lv = 'High'";
            }
            if (!empty($maintenance_conditions)) {
                $conditions[] = "(" . implode(" OR ", $maintenance_conditions) . ")";
            }
        
            // Check growing season
            if ($formData['season'] !== 'default') {
                $season = mysqli_real_escape_string($link, $formData['season']);
                $conditions[] = "growing_season LIKE '%$season%'";
            }
        
            // Check average height
            if ($formData['average_height'] !== 'default') {
                $height = mysqli_real_escape_string($link, $formData['average_height']);
                $conditions[] = "average_height = '$height'";
            }
        
            // Check planting place
            if ($formData['planting_place'] !== 'default') {
                $place = mysqli_real_escape_string($link, $formData['planting_place']);
                $conditions[] = "planting_place LIKE '%$place%'";
            }
        
            // Combine all conditions with 'AND'
            $where_clause = implode(" AND ", $conditions);
        
            // SQL query
            $sql = "SELECT * FROM plante";
            if (!empty($where_clause)) {
                $sql .= " WHERE $where_clause";
            }
        
            return $sql;
        }
       
    ?>
    </div>
    <form class="form-needed" method="post">
        <div class="full-box">
        <div class="row">
            <div class="col-md" style="display: flex;flex-direction: column;align-items: center;">
                <label for="search">Search</label><br>
                <input style="width: 400px;margin-top:-1%;margin-bottom:3%;" type="text" id="search" name="search" autocomplete="off" placeholder="Search for plants by species name or common name"><br>
            </div> 
        </div>
        <div class="row">
            <div class="col-md plant-finder-col">
                <label for="plant_type">Plant Type</label><br>
                <select id="plant_type" name="plant_type" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Plant Type</option>
                    <option value="vegetable">Vegetables</option>
                    <option value="aquatic">Acquatic Plants</option>
                    <option value="herbs">Herbs</option>
                    <option value="roses">Roses</option>
                    <option value="fruit">Fruits</option>
                    <option value="cactus-succulents">Cactus & Succulents</option>
                </select>
            </div> 
            <div class="col-md plant-finder-col">
                <label for="water_needs">Water Needs</label><br>
                <div class="plant-finder-choose-options">
                    <input type="checkbox" value="Low" id="water_low" name="water_low">
                    <label for="water_low">Low</label>
                    <input type="checkbox" value="Medium" id="water_medium" name="water_medium">
                    <label for="water_medium">Medium</label>
                    <input type="checkbox" value="High" id="water_high" name="water_high">
                    <label for="water_high">High</label>
                </div>
            </div> 
            <div class="col-md plant-finder-col">
                <label for="light_level">Light level</label><br>
                <div class="plant-finder-choose-options">
                    <input type="checkbox" value="Low" id="light_low" name="light_low">
                    <label for="light_low">Low</label>
                    <input type="checkbox" value="Medium" id="light_medium" name="light_medium">
                    <label for="light_medium">Medium</label>
                    <input type="checkbox" value="High" id="light_high" name="light_high">
                    <label for="light_high">High</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md plant-finder-col">
            <label for="maintenance_needs">Maintenance needs</label><br>
                <div class="plant-finder-choose-options">
                    <input type="checkbox" value="Low" id="maintenance_low" name="maintenance_low">
                    <label for="maintenance_low">Low</label>
                    <input type="checkbox" value="Medium" id="maintenance_medium" name="maintenance_medium">
                    <label for="maintenance_medium">Medium</label>
                    <input type="checkbox" value="High" id="maintenance_high" name="maintenance_high">
                    <label for="maintenance_high">High</label>
                </div>
            </div>
            <div class="col-md plant-finder-col">
                <label for="season">Preferred season</label><br>
                <select id="season" name="season" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Preferred season</option>
                    <option value="winter">Winter</option>
                    <option value="early_spring">Early Spring</option>
                    <option value="spring">Spring</option>
                    <option value="early summer">Early Summer</option>
                    <option value="summer">Summer</option>
                    <option value="autumn">Autumn</option>
                </select>
            </div> 
            <div class="col-md plant-finder-col">
                <label for="soil_type">Soil Type</label><br>
                <select id="soil_type" name="soil_type" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Soil Type</option>
                    <option value="clay">Clay</option>
                    <option value="chalk">Chalk</option>
                    <option value="loam">Loam</option>
                    <option value="sand">Sand</option>
                    <option value="sandy_loam">Sandy Loam</option>
                    <option value="all_types">All types</option>
                </select>
            </div> 
        </div>
        <div class="row">
            <div class="col-md plant-finder-col">
            <label for="soil_ph">Soil pH</label><br>
                <div class="plant-finder-choose-options">
                    <input type="checkbox" value="acid_ph" id="acid_ph" name="acid_ph">
                    <label for="acid_ph">Acidic</label>
                    <input type="checkbox" value="neutral" id="neutral_ph" name="neutral_ph">
                    <label for="neutral_ph">Neutral</label>
                    <input type="checkbox" value="alkaline" id="alkaline_ph" name="alkaline_ph">
                    <label for="alkaline_ph">Alkaline</label>
                </div>
            </div>
            <div class="col-md plant-finder-col">
                <label for="soil_drainage">Soil drainage</label><br>
                <select id="soil_drainage" name="soil_drainage" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Soil drainage</option>
                    <option value="moist_but_well_drained">Moist but well drained</option>
                    <option value="poorly_drained">Poorly drained</option>
                    <option value="moisture_retentive">Moisture retentive</option>
                    <option value="well_drained">Well drained</option>
                </select>
            </div> 
            <div class="col-md plant-finder-col">
                <label for="average_height">Average height</label><br>
                <select id="average_height" name="average_height" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Average height</option>
                    <option value="height_between_1_and_20">1 - 20 cm</option>
                    <option value="height_between_21_and_50">21 - 50</option>
                    <option value="height_between_51_and_100">51 - 100</option>
                    <option value="height_more_than_100"> > 100</option>
                </select>
            </div> 
        </div>
        <div class="row">
            <div class="col-md plant-finder-col" style="margin-bottom:-40px;">
                <label for="planting_place">Planting place</label><br><br><br>

                <select id="planting_place" name="planting_place" class="plant-finder-choose-options">
                    <option value="default" style="display: none;">Planting place</option>
                    <option value="patio_and_containers">Patio and containers</option>
                    <option value="trellises">Trellises</option>
                    <option value="banks_and_slopes">Banks and slopes</option>
                    <option value="ponds_and_streams">Ponds and streams</option>
                    <option value="planting_raised_beds">Raised beds</option>
                    <option value="small_gardens">Small gardens</option>
                    <option value="underplanting_roses_and_shrubs">Underplanting roses and shrubs</option>
                    <option value="hanging_baskets">Hanging baskets</option>
                    <option value="beside_walls_and_fences">Beside walls and fences</option>
                    <option value="pathways">Pathways</option>
                    <option value="greenhouse">Greenhouse</option>
                    <option value="heated_greenhouse">Heated greenhouse</option>
                    <option value="closed_balcony">Closed balcony</option>
                    <option value="open_balcony">Open balcony</option>
                </select>
            </div>
        </div>
        <br><br><br>
        <div style="text-align: center;">
            <button id="submit_plant_finder" name="submit_plant_finder" type="submit" style="margin: auto; padding: 10px 20px;width:200px; background-color: #8BC34A; color: #fff; border: none; border-radius: 20px; cursor: pointer; font-size: 23px;">Submit</button>
        </div>
        </div>
        

    </form><br><br><br>
    <div class="card-container" style="margin-top: 3%;">
    <?php
    if(isset($_POST["submit_plant_finder"])){
            $formData = $_POST;
            $sql = generateSQL($formData, $link);
            // echo $sql;
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        ?><div class="card">
                        <img src="data:image/jpg;charset=utf8;base64, <?php echo base64_encode($row['picture']); ?>" alt="<?php echo $row['plant_name']; ?>">
                        <h2><?php
                        echo $row['plant_name']; ?> </h2>
                        <p><strong>Species:</strong> <?php echo $row['plant_species']; ?></p>
                        <p><strong>Plant Type:</strong> <?php echo $row['plant_type']; ?></p>
                        <!-- <p><strong>Light Level:</strong> <?php echo $row['light_lv']; ?></p>
                        <p><strong>Water Needs:</strong> <?php echo $row['water_needs']; ?></p> -->
                        <p><strong>Maintenance Level:</strong> <?php echo $row['maintanence_lv']; ?></p>
                        <!--  
                        <p><strong>Growing Season:</strong> <?php echo $row['growing_season']; ?></p>
                        <p><strong>Average Height:</strong> <?php echo $row['average_height']; ?></p>
                        <p><strong>Planting Width:</strong> <?php echo $row['planting_width']; ?></p>
                        <p><strong>Soil Type:</strong> <?php echo $row['soil_type']; ?></p>
                        <p><strong>Soil pH:</strong> <?php echo $row['soil_ph']; ?></p>
                        <p><strong>Soil Drainage:</strong> <?php echo $row['soil_drainage']; ?></p> -->
                        <br>
                        <a href="plant_details.php?id=<?php echo $row['id']; ?>"><button>Read More</button></a>
                        <br>
                        <form method="GET" action="">
                            <button id="add_collection_button" name="add_collection_button" class="add-to-collection-btn">Add to Collection</button>
                        </form>          
                        <?php 
                        if(isset($_GET["add_collection_button"])){
                            $plant_id = $row['id'];
                            $user_id = $_SESSION['id'];
                            $sql = "INSERT INTO users_collections_have_plants (collection_id, plant_id) VALUES ('1', '$plant_id')";
                            if(mysqli_query($link, $sql)){
                                ?> 
                                
                                <?php
                                echo "Plant added to collection.";
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                            }
                        }
                        ?> </div> <?php
                    }
                    mysqli_free_result($result);
                } else{
                    // echo "User sau parola incorecte.";
                    // die();
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        }
        ?>

    </div>
    <script src="jquery-3.6.1.js"></script>
    
    </body>
</html>