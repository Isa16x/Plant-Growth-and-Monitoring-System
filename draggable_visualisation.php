<!DOCTYPE html>
<html lang="en">

<head>
    <title>Planting Ideas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        .garden-area {
            width: 500px;
            height: 500px;
            border: 2px solid #000;
            position: relative;
            margin: 0 auto;
        }

        .corner {
            width: 20px;
            height: 20px;
            background-color: red;
            position: absolute;
            cursor: pointer;
            border-radius: 50%;
        }

        .plant {
            width: 10px;
            height: 10px;
            background-color: green;
            position: absolute;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Planting Ideas for Your Garden</h1>
        <div class="garden-area" id="gardenArea">
            <canvas id="gardenCanvas" width="500" height="500"></canvas>
            <div class="corner" id="corner1" style="top: 0; left: 0;"></div>
            <div class="corner" id="corner2" style="top: 0; right: 0;"></div>
            <div class="corner" id="corner3" style="bottom: 0; left: 0;"></div>
            <div class="corner" id="corner4" style="bottom: 0; right: 0;"></div>
        </div>
        <button class="btn btn-primary mt-3" id="calculatePlantPositions">Calculate Plant Positions</button>
        <div id="plantPositions" class="mt-3"></div>
    </div>
    <script>
        const gardenCanvas = document.getElementById('gardenCanvas');
        const ctx = gardenCanvas.getContext('2d');
        const corners = [
            document.getElementById('corner1'),
            document.getElementById('corner2'),
            document.getElementById('corner3'),
            document.getElementById('corner4')
        ];

        let isDragging = false;
        let currentCorner = null;

        corners.forEach(corner => {
            corner.addEventListener('mousedown', function(e) {
                isDragging = true;
                currentCorner = e.target;
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging && currentCorner) {
                    const rect = gardenCanvas.getBoundingClientRect();
                    let x = e.clientX - rect.left - currentCorner.offsetWidth / 2;
                    let y = e.clientY - rect.top - currentCorner.offsetHeight / 2;

                    x = Math.max(0, Math.min(x, rect.width - currentCorner.offsetWidth));
                    y = Math.max(0, Math.min(y, rect.height - currentCorner.offsetHeight));

                    currentCorner.style.left = x + 'px';
                    currentCorner.style.top = y + 'px';
                    updateGardenCanvas();
                }
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
                currentCorner = null;
            });
        });

        function updateGardenCanvas() {
            ctx.clearRect(0, 0, gardenCanvas.width, gardenCanvas.height);
            ctx.beginPath();
            corners.forEach((corner, index) => {
                const x = parseFloat(corner.style.left) + corner.offsetWidth / 2;
                const y = parseFloat(corner.style.top) + corner.offsetHeight / 2;
                if (index === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            });
            ctx.closePath();
            ctx.stroke();
        }

        function isPointInPolygon(x, y, poly) {
            let isInside = false;
            const len = poly.length;
            for (let i = 0, j = len - 1; i < len; j = i++) {
                const xi = poly[i][0],
                    yi = poly[i][1];
                const xj = poly[j][0],
                    yj = poly[j][1];
                const intersect = ((yi > y) !== (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                if (intersect) isInside = !isInside;
            }
            return isInside;
        }

        document.getElementById('calculatePlantPositions').addEventListener('click', function() {
            const plantPositionsDiv = document.getElementById('plantPositions');
            plantPositionsDiv.innerHTML = '';

            const poly = corners.map(corner => {
                return [
                    parseFloat(corner.style.left) + corner.offsetWidth / 2,
                    parseFloat(corner.style.top) + corner.offsetHeight / 2
                ];
            });

            for (let i = 0; i < 20; i++) {
                let plantX, plantY;
                do {
                    plantX = Math.random() * gardenCanvas.width;
                    plantY = Math.random() * gardenCanvas.height;
                } while (!isPointInPolygon(plantX, plantY, poly));

                const plant = document.createElement('div');
                plant.className = 'plant';
                plant.style.left = (plantX - 5) + 'px'; // Adjust for plant size
                plant.style.top = (plantY - 5) + 'px'; // Adjust for plant size
                document.getElementById('gardenArea').appendChild(plant);
            }
        });

        updateGardenCanvas();
    </script>
</body>

</html>