<script>
    function searchPlants() {
        const keyword = document.getElementById('keywordInput').value;
        if (keyword) {
            window.location.href = `rezultate_cautare.php?keyword=${encodeURIComponent(keyword)}`;
        }
    }
</script>

<nav class="navbar navbar-expand-lg navbar-light row navmenu">
    <div class="container-fluid">

        <a class="navbar-brand" href="./index.php"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse row" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php" class="d-none d-lg-flex align-items-center ml-auto ml-lg-0 text-dark">
                        <img src="./imagini/logo.png" alt="logo" height="80px" style="vertical-align:  baseline; margin-left:20px;">
                        <b style="line-height: 1.1; display: inline-block; top:70px; font-family: 'Montserrat', sans-serif;vertical-align:center;"></b>
                    </a>
                </li>
                <!-- <li class="nav-item col-md-1"> -->
                <!-- <a class="nav-link col-md-1 p-3" href="garden_design.php"><b style=" top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align: center;">Plant Collections</b></a> -->
                <!-- </li> -->
                <li class="nav-item col-md-2">
                    <!-- <a class="nav-link col-md-1 p-3" href="garden_design.php"><b style=" top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align: center;">Plant Collections</b></a> -->
                </li>

                <div id="navbarSupportedContent" class="collapse navbar-collapse">

                    <div class="navbar-nav mx-auto d-flex align-items-center d-sm-none d-lg-block ">

                        <div class="d-flex">
                            <input id="keywordInput" type="text" name="keyword" autocomplete="off" placeholder="Look for plants and choose your leafy partner" class="form-control" style="min-width: 360px;">
                            <button class="btn btn-secondary btn-light" style="display: inline-block;" type="button" onclick="searchPlants()">Search</button>
                        </div>

                    </div>
                    <?php
                    if (isset($_SESSION['email'])) {
                    ?>
                        <li class="nav-item" style="margin-right: 20px; position: relative;">
                            <a class="nav-link p-3" href="collection.php">
                                <b style="font-weight: 1200; font-size: 20px; font-family: 'Montserrat', sans-serif; color: black; text-align: center; position: relative; z-index: 1; text-shadow: 0 0 5px black;">Plant Collections</b>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-right: 20px; position: relative;">
                            <a class="nav-link p-3" href="logout.php">
                                <b style="font-weight: 1200; font-size: 20px; font-family: 'Montserrat', sans-serif; color: black; text-align: center; position: relative; z-index: 1;">Logout</b>
                            </a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item" style="margin-right: 20px; position: relative;">
                            <a class="nav-link p-3" href="register.php">
                                <b style="font-weight: 1200; font-size: 20px; font-family: 'Montserrat', sans-serif; color: black; text-align: center; position: relative; z-index: 1;">Register</b>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-right: 20px; position: relative;">
                            <a class="nav-link p-3" href="login.php">
                                <b style="font-weight: 1200; font-size: 20px; font-family: 'Montserrat', sans-serif; color: black; text-align: center; position: relative; z-index: 1;">Login</b>
                            </a>
                        </li>
                    <?php
                    }
                    ?>


                    <li class="nav-item col-md-1">
                        <!-- <a class="nav-link col-md-1 p-3" href="garden_design.php"><b style=" top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align: center;">Plant Collections</b></a> -->
                    </li>
            </ul>
        </div>
    </div>
</nav>

<div class="row" style="position: -webkit-sticky; position: sticky;">

    <div class="" style="background-color: #ecfce8!important; height:75px">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item col-md-2">
                    <!-- <a class="nav-link col-md-1 p-3" href="garden_design.php"><b style="line-height: 1.1; display: inline-block; top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black">Design your garden </b></a> -->
                </li>
                <li class="nav-item col-md-1">
                    <!-- <a class="nav-link col-md-1 p-3" href="garden_design.php"><b style="line-height: 1.1; display: inline-block; top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black">Design your garden </b></a> -->
                </li>
                <li class="nav-item col-md-3 " style="margin-top:-1.7%;">
                    <a class="nav-link col-md-1 " href="garden_design.php"><b style="line-height: 1.1; display:flex;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align:center;">Plan your garden </b></a>
                </li>
                <li class="nav-item col-md-3 " style="margin-top:-0.4%">
                    <a class="nav-link col-md-1 " href="plant_ideas.php"><b style="line-height: 1.1; display:flex;margin-top:-30%;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align:center;">Planting Ideas</b></a>
                </li>
                <li class="nav-item col-md-3">
                    <a class="nav-link col-md-1 " href="manage_collections.php"><b style="line-height: 1.1; display:flex;margin-top:-30%;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black; text-align:center;">Manage collections </b></a>
                </li>

                <li class="nav-item col-md-3" style="margin-top:-1.7%;">
                    <a class="nav-link col-md-1 " href="main_dashboard.php"><b style="line-height: 1.1; display: inline-block; top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black;text-align:center;">Dashboard for current plants </b></a>
                </li>

                <li class="nav-item col-md-3">
                    <a class="nav-link col-md-1 " href="data_graphs.php"><b style="line-height: 1.1; display: inline-block; top:70px;font-weight:1200;font-size:20px; font-family: 'Montserrat', sans-serif;color:black;text-align:center;">Data graphs </b></a>
                </li>

                <div class="container py-2" style="max-width:650px; ">
                    <nav class="nav nav-pills flex-column flex-sm-row">

                    </nav>
                </div>
    </div>