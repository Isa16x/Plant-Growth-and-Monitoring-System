<?php
// $response = [
//     'status' => 'success',
//     'message' => 'Hello, world!',
//     'data' => [
//         'id' => 1,
//         'name' => 'Sample Data'
//     ]
// ];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csv_db_11";
// exit(print_r($_GET['search']));
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (!empty($_GET['search'])) {
  $sql = "SELECT * FROM `plante` where scientific_name like '%" . $_GET['search'] . "%' or common_name like '%" . $_GET['search'] . "%'";
} else {
  if (!empty($_GET['id'])) {
    $sql = "SELECT * FROM `plante` where id = '" . $_GET['id'] . "'";
  }
}

$result = $conn->query($sql);
'{\'data\': {';
if ($result->num_rows > 0) {
  // output data of each row
  $data = array("data" => array());
  while ($row = $result->fetch_assoc()) {
    $data_row =
      array(
        "id" =>  $row['id'],
        "common_name" => (is_null($row['common_name']) ? null : $row['common_name']),
        "slug" => null,
        "scientific_name" => (is_null($row['scientific_name']) ? null : $row['scientific_name']),
        "year" => (is_null($row['year']) ? null : $row['year']),
        "bibliography" => (is_null($row['bibliography']) ? null : $row['bibliography']),
        "author" => (is_null($row['author']) ? null : $row['author']),
        "status" => null,
        "rank" => (is_null($row['rank']) ? null : $row['rank']),
        "family_common_name" => (is_null($row['family_common_name']) ? null : $row['family_common_name']),
        "genus_id" => null,
        "observations" => (is_null($row['distributions']) ? null : explode(",", $row['distributions'])),
        "vegetable" => (is_null($row['vegetable']) ? null : $row['vegetable']),
        "image_url" => (is_null($row['image_url']) ? null : $row['image_url']),
        "genus" => (is_null($row['genus']) ? null : $row['genus']),
        "family" => (is_null($row['family']) ? null : $row['family']),
        "duration" => null,
        "edible_part" => (is_null($row['edible_part']) ? null : $row['edible_part']),
        "edible" => (is_null($row['edible']) ? null : $row['edible']),
        "images" => array(
          "ceva" => array(
            "id" => 168057,
            "image_url" => (is_null($row['image_url']) ? null : $row['image_url']),
            "copyright" => null
          )
        ),
        "common_names" => (is_null($row['common_names']) ? null : explode(",", $row['common_names'])),
        "distribution" => array("native" => array()),
        "distributions" => array(
          "ceva" =>  is_null($row['distributions']) ? null : explode(",", $row['distributions']),
          "native" => array(
            "id" => 28,
            "name" => is_null($row['distributions']) ? null : explode(",", $row['distributions']),
            "slug" => "ind",
            "tdwg_code" => "IND",
            "tdwg_level" => 3,
            "species_count" => count(explode(',', $row['distributions'])),
            "links" => array(
              "self" => "/api/v1/distributions/ind",
              "plants" => "/api/v1/distributions/ind/plants",
              "species" => "/api/v1/distributions/ind/species"
            )
          )
        ),
        "flower" => array(
          "color" => (is_null($row['flower_color']) ? null : $row['flower_color']),
          "conspicuous" => (is_null($row['flower_conspicuous']) ? null : $row['flower_conspicuous'])
        ),
        "foliage" => array(
          "texture" => (is_null($row['foliage_texture']) ? null : $row['foliage_texture']),
          "color" => (is_null($row['foliage_color']) ? null : $row['foliage_color']),
          "leaf_retention" => null
        ),
        "fruit_or_seed" => array(
          "conspicuous" => (is_null($row['fruit_conspicuous']) ? null : $row['fruit_conspicuous']),
          "color" => (is_null($row['fruit_color']) ? null : $row['fruit_color']),
          "shape" => null,
          "seed_persistence" => null
        ),
        "sources" => array(
          array(
            "last_update" => "2022-12-05T03:44:39.319Z",
            "id" => "wfo-0000379966",
            "name" => "WFO",
            "url" => null,
            "citation" => null
          ),
          array(
            "last_update" => "2022-12-05T03:44:39.341Z",
            "id" => "70088-1",
            "name" => "IPNI",
            "url" => null,
            "citation" => null
          ),
          array(
            "last_update" => "2022-12-07T20:11:51.398Z",
            "id" => "7716613",
            "name" => "GBIF",
            "url" => "https://www.gbif.org/species/7716613",
            "citation" => null
          ),
          array(
            "last_update" => "2022-12-07T20:11:51.765Z",
            "id" => "urn:lsid:ipni.org:names:70088-1",
            "name" => "POWO",
            "url" => "http://powo.science.kew.org/taxon/urn:lsid:ipni.org:names:70088-1",
            "citation" => "POWO (2019). Plants of the World Online. Facilitated by the Royal Botanic Gardens, Kew. Published on the Internet; http://www.plantsoftheworldonline.org/ Retrieved 2022-12-07"

          )
        ),
        "specifications" => array(
          "ligneous_type" => null,
          "growth_form" => (is_null($row['growth_form']) ? "null" : $row['growth_form']),
          "growth_habit" => (is_null($row['growth_habit']) ? "null" : $row['growth_habit']),
          "growth_rate" => (is_null($row['growth_rate']) ? "null" : $row['growth_rate']),
          "average_height" => array(
            "cm" => (is_null($row['average_height_cm']) ? "null" : $row['average_height_cm'])
          ),
          "maximum_height" => array(
            "cm" => (is_null($row['maximum_height_cm']) ? "null" : $row['maximum_height_cm'])
          ),
          "nitrogen_fixation" => null,
          "shape_and_orientation" => null,
          "toxicity" => null
        ),
        "synonyms" => (is_null($row['synonyms']) ? "null" : $row['synonyms']),
        "growth" => array(
          "description" => (is_null($row['planting_description']) ? "null" : $row['planting_description']),
          "sowing" => (is_null($row['planting_sowing_description']) ? "null" : $row['planting_sowing_description']),
          "days_to_harvest" => (is_null($row['planting_days_to_harvest']) ? "null" : $row['planting_days_to_harvest']),
          "row_spacing" => array(
            "cm" => (is_null($row['planting_row_spacing_cm']) ? "null" : $row['planting_row_spacing_cm'])
          ),
          "spread" => array(
            "cm" => (is_null($row['planting_spread_cm']) ? "null" : $row['planting_spread_cm'])
          ),
          "ph_maximum" => (is_null($row['ph_maximum']) ? "null" : $row['ph_maximum']),
          "ph_minimum" => (is_null($row['ph_minimum']) ? "null" : $row['ph_minimum']),
          "light" => $row['light'],
          "atmospheric_humidity" => (is_null($row['atmospheric_humidity']) ? "null" : $row['atmospheric_humidity']),
          "growth_months" => (is_null($row['growth_months']) ? "null" : $row['growth_months']),
          "bloom_months" => (is_null($row['bloom_months']) ? "null" : $row['bloom_months']),
          "fruit_months" => (is_null($row['fruit_months']) ? "null" : $row['fruit_months']),
          "minimum_precipitation" => array(
            "mm" => null
          ),
          "maximum_precipitation" => array("mm" => null),
          "minimum_root_depth" => array(
            "cm" => (is_null($row['minimum_root_depth_cm']) ? "null" : $row['minimum_root_depth_cm'])
          ),
          "minimum_temperature" => array(
            "deg_f" => null,
            "deg_c" => null
          ),
          "maximum_temperature" => array(
            "deg_f" => null,
            "deg_c" => null
          ),
          "soil_nutriments" => (is_null($row['soil_nutriments']) ? "null" : $row['soil_nutriments']),
          "soil_salinity" => (is_null($row['soil_salinity']) ? "null" : $row['soil_salinity']),
          "soil_texture" => null,
          "soil_humidity" => null
        ),
        "links" => array(
          "self" => "/api/v1/species/nothopegia-aureofulva",
          "plant" => "/api/v1/plants/nothopegia-aureofulva",
          "genus" => "/api/v1/genus/nothopegia"
        ),
        // },
        "meta" => array(
          "images_count" => 3,
          "sources_count" => 4,
          "synonyms_count" => 0,
          "last_modified" => "2022-12-22T05:18:45.429Z"
        )
      );
    array_push($data['data'], $data_row);
    // print_r($row);
  }
} else {
  echo "0 results";
}

// $data .= '}' ;
$conn->close();
header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_SLASHES);
// $data = array("test"=>12, "jan"=>array("plm"=>3,"stf"=>"ceva", "alabala mortii " => array("1","2","4",'sdsfd')));
// Convert the array to JSON format
// echo json_decode($data);
// echo json_encode($data)));
