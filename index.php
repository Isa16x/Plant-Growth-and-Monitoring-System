<?php if (!isset($_SESSION)) {
  session_start();
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
        <title>Acasa</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.css">
        <script src="./bootstrap-5.0.2-dist/js/bootstrap.js"></script> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="./styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis:wght@200&family=Montserrat:wght@200&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Tangerine&display=swap" rel="stylesheet">
            </head>
    <body>
    <?php 
    include "conectarebd.php";
    
       ?>
    <?php include "meniu.php"; ?>
    <?php 
        include "carousel.php";
    ?>
        
    </div>
    
    

    </div>
    </div>
    <br>
    <!-- <h1 style="text-align: center;">Intalneste un nou prieten pe viata!</h1> -->
    <br>
    <div class="row">
        
    </div>
    <script src="jquery-3.6.1.js"></script>
    



    </body>
</html>