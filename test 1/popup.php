<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #111;
        }

        .modal-button {
            background: red;
            border-radius: 20px;
            border: 0px;
            box-shadow: 0 1px 4px grey;
            color: #fff;
            cursor: pointer;
            padding: 10px 25px;
        }

        .modal-button:active {
            opacity: 0.8;
        }

        .modal {
            background-color: rgba(0, 0, 0, 0.3);
            opacity: 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: all 0.3s ease-in-out;
            z-index: -1;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal.open {
            opacity: 1;
            z-index: 999;
        }

        .modal-inner {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 1px 4px grey;
            padding: 15px 25px;
            text-align: center;
            width: 380px;
        }

        .modal-inner h2 {
            margin: 0;
        }

        .modal-inner p {
            line-height: 24px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <button id="open-modal" class="modal-button">open</button>
    <div class="modal" id="modal">
        <div class="modal-inner">
            <h2>Sample 1</h2>
            <p>the text Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam repellendus nesciunt accusamus porro tenetur labore ipsa illo voluptates eligendi eos!</p>
            <button id="close-modal" class="modal-button">Close</button>
        </div>
    </div>
</body>

<script>
    const openBtn = document.getElementById("open-modal");
    const closeBtn = document.getElementById("close-modal");
    const modal = document.getElementById("modal");

    openBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("open");
    });

    document.addEventListener("DOMContentLoaded", () => {
        openBtn.click();
    });
</script>


</html>