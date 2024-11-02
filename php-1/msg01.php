<?php
include_once 'include-all-class-and-session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>

        .popup-1 {
            font-family: "Poppins", sans-serif;
            background: #111;
            box-sizing: border-box;
        }

        .modal-button {
            font-size: 14px;
            background: red;
            border-radius: 10px;
            border: 0px;
            color: #fff;
            cursor: pointer;
            padding: 12px;
            margin: 10px 25px;
            transition: 0.5s;
        }

        .modal-button:hover{
            box-shadow: 0 1px 10px grey;
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
            text-align: justify;
            width: 50%;
        }

        .t-a-center {
            text-align: center;
        }
        .modal-inner h2 {
            margin: 0;
        }

        .modal-inner p {
            /* line-height: 24px; */
            margin: 10px 0;
            font-size: 15px;
        }

        @media (max-width: 720px) {
            .modal-inner {
                width: 75%;
            }
        }
    </style>
</head>

<body>
    <div>
        <h1>
            <?php if (isset($_SESSION['msg01'])) { ?>
                <div class="popup-1">
                    <!-- <button id="open-modal" class="modal-button">open</button> -->
                    <div class="modal" id="modal">
                        <div class="modal-inner">
                            <h2 class="t-a-center">SIAS</h2>
                            <p><?php echo $_SESSION['msg01']; ?></p>
                            <div class="t-a-center">
                                <button id="close-modal" class="modal-button">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['msg01']); ?>
            <?php } ?>
        </h1>
    </div>
</body>

<script>
    const closeBtn = document.getElementById("close-modal");
    const modal = document.getElementById("modal");

    // Trigger the modal directly
    document.addEventListener("DOMContentLoaded", () => {
        modal.classList.add("open");
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("open");
    });
</script>


</html>