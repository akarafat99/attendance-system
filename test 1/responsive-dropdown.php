<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Select Option</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <style>
        

        .container {
            max-width: 400px;
            width: 100%;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <label for="selectOption">Select Option:</label>
        <select id="selectOption" name="selectOption" class="js-example-basic-single" style="width: 100%">
            <option value="option1">Option 1 Lorem, ipsum. Lorem, ipsum. Lorem, ipsum dolor.</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
            <!-- Add more options as needed -->
        </select>
    </div>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
</body>

</html>
