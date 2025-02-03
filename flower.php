<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flower Petals Animation</title>
<style>
    body {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f8f8f8;
    }

    .flower {
        position: relative;
        width: 150px;
        height: 150px;
        background-color: #f00; /* Center of the flower */
        border-radius: 50%;
    }

    .petal {
        position: absolute;
        width: 40px;
        height: 80px;
        background-color: #ff0; /* Petal color */
        border-radius: 50%;
        animation: petal-fall 4s linear infinite;
    }

    .petal:nth-child(1) {
        top: -20px;
        left: 30px;
        transform: rotate(30deg);
    }

    .petal:nth-child(2) {
        top: -20px;
        left: 80px;
        transform: rotate(60deg);
    }

    .petal:nth-child(3) {
        top: -20px;
        left: 130px;
        transform: rotate(90deg);
    }

    .petal:nth-child(4) {
        top: 30px;
        left: -20px;
        transform: rotate(120deg);
    }

    .petal:nth-child(5) {
        top: 80px;
        left: -20px;
        transform: rotate(150deg);
    }

    .petal:nth-child(6) {
        top: 130px;
        left: -20px;
        transform: rotate(180deg);
    }

    .petal:nth-child(7) {
        top: 130px;
        left: 30px;
        transform: rotate(210deg);
    }

    .petal:nth-child(8) {
        top: 130px;
        left: 80px;
        transform: rotate(240deg);
    }

    .petal:nth-child(9) {
        top: 130px;
        left: 130px;
        transform: rotate(270deg);
    }

    .petal:nth-child(10) {
        top: 80px;
        left: 180px;
        transform: rotate(300deg);
    }

    .petal:nth-child(11) {
        top: 30px;
        left: 180px;
        transform: rotate(330deg);
    }

    @keyframes petal-fall {
        0% {
            top: -20px;
            opacity: 0;
            transform: translateY(0) rotateZ(0deg);
        }
        50% {
            opacity: 1;
            transform: translateY(100px) rotateZ(180deg);
        }
        100% {
            top: 100%;
            opacity: 0;
            transform: translateY(100%) rotateZ(360deg);
        }
    }
</style>
</head>
<body>
<div class="flower">
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
    <div class="petal"></div>
</div>
</body>
</html>
