<?php

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the form values
    $hostname = $_POST['hostname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    $sql_file = $_POST['sql_file'];

    // Connect to the database
    $conn = mysqli_connect($hostname, $username, $password);

    // Check for an error
    if (!$conn) {
        die('Error connecting to MySQL: ' . mysqli_connect_error());
    }

    // Select the database to use
    $db_selected = mysqli_select_db($conn, $database);

    // Check for an error
    if (!$db_selected) {
        die ('Can\'t use ' . $database . ': ' . mysqli_error($conn));
    }

    // Read the .sql file
    $sql = file_get_contents($sql_file);

    // Split the file into individual queries
    $queries = explode(';', $sql);

    // Execute each query
    foreach ($queries as $query) {
        mysqli_query($conn, $query);
    }

    // Close the connection
    mysqli_close($conn);

    echo 'Database installed successfully!';
} else {
echo '
    <h4> Php script for auto install .sql Database </h4>
    <form method="post" action="install.php">
        <label for="hostname">Hostname:</label>
        <input type="text" name="hostname" required>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password">
        <label for="database">Database:</label>
        <input type="text" name="database" required>
        <label for="sql_file">SQL File:</label>
        <input type="file" name="sql_file" required>
<br><hr><br>
        <input type="submit" name="submit" value="Install">
    </form>
';
 }
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<style>
    form {
        width: 300px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="password"], input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</body>
</html>
