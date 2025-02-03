<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conectarebd.php";
include "meniu.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Planting ideas</title>
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

    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <p></p>
    <p></p>
    <h1 class="titlu_pag_cat">Planting Ideas for Your Garden</h1>
    <div class="page_interior">
        <div class="note-container">
            <h2>Notes for plants</h2>
            <div class="note-input">
                <textarea id="noteText" placeholder="Write a note..."></textarea>
                <button id="addNote" name="addNote">Add note</button>
            </div>
            <div class="note-board">

            </div>
        </div>
    </div>

    <?php
    include 'conectarebd.php';
    if (isset($_POST['addNote'])) {

        $noteText = $_POST['noteText'];
        $stmt = $conn->prepare("INSERT INTO notes (text) VALUES (?)");
        echo "am adaugat";
        // $stmt->bind_param("s", $noteText);
        // $stmt->execute();
        // $stmt->close();
        // $conn->close();
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            var colors = ["#e3f2fd", "#c8e6c9", "#ffccbc", "#f0f4c3", "#d1c4e9"];
            var colorIndex = 0;

            // Make note drag and drop
            function makeDraggable() {
                $(".note").draggable({
                    containment: ".note-board",
                    stop: function(event, ui) {
                        var pos = $(this).position();
                        $(this).data("position", pos);
                    }
                });
            }


            // new note
            $("#addNote").click(function() {
                var noteText = $("#noteText").val();
                if (noteText.trim() !== "") {
                    var newNote = $("<div class='note'></div>").text(noteText);
                    newNote.css("background-color", colors[colorIndex]);
                    colorIndex = (colorIndex + 1) % colors.length;
                    $(".note-board").append(newNote);
                    makeDraggable();
                    $("#noteText").val("");
                }
            });

            // Initialize drag notes
            makeDraggable();
        });
    </script>

    <style>
        .note-container {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .note-input {
            margin-bottom: 20px;
        }

        .note-input textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .note-input button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .note-board {
            border: 1px dashed #ccc;
            padding: 10px;
            border-radius: 5px;
            min-height: 400px;
            position: relative;
            background-color: #fff;
        }

        .note {
            border: 1px solid #90caf9;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: move;
            position: absolute;
            max-width: 200px;
            /* Adjust this value as needed */
            word-wrap: break-word;
        }
    </style>

</body>

</html>