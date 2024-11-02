<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Apply a flex container to the parent div */
        .container {
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap to the next line */
            gap: 10px; /* Adjust the gap between items */
        }

        /* Style for input field */
        .container-search input {
            padding: 8px;
            flex: 1; /* Allow the input to take remaining space */
        }

        /* Style for button */
        button {
            padding: 8px 16px;
        }

        /* Media query to handle screen width less than 700px */
        @media (max-width: 700px) {
            /* Change flex direction to column for smaller screens */
            .container {
                flex-direction: column;
            }

            /* Reset input flex property for smaller screens */
            .container-search input {
                flex: none;
            }
        }
    </style>
</head>
<body>
    <div style="margin: auto; width:70%; ">
        <div class="container-search">
            <input type="text" placeholder="Enter something">
            <button>Submit</button>
        </div>
    </div>
</body>
</html>
