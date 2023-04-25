<?php session_start(); ?>


<?php

$dbhost = 'localhost';
$dbuser = 'username';
$dbpass = 'password';
$database = 'user_db';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);


if (isset($_POST['submit'])) {


    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $table_number = mysqli_real_escape_string($conn, $_POST['table_number']);


    $query = "SELECT * FROM seats WHERE table_number = '$table_number' AND reserved = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $query = "UPDATE tables SET reserved = 1, name = '$name', email = '$email' WHERE table_number = '$table_number'";
        mysqli_query($conn, $query);
        echo "Место $table_number успешно зарезервировано для $name!";
    } else {

        echo "Извините, место $table_number уже занято.";
    }


    mysqli_close($conn);

}

?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="name">Имя:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="table_number">Номер места:</label>
    <input type="number" name="table_number" required>

    <input type="submit" name="submit" value="Зарезервировать место">
</form>