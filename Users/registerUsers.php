<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Users</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #9c0000ff;
            border-radius: 4px;
        }

        button {
            width: 95%;
            padding: 10px;
            background-color: #9c0000ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #b30000ff;
            width: 97%;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Register User</h1>

    <input type="text" placeholder="Username" />
    <input type="text" placeholder="Password" />

    <button id="submit">Submit</button>
    </div>
</body>
</html>