<?php
session_start();
include "db_connect.php";

if (isset($_POST['brukernavn']) && isset($_POST['passord'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $brukernavn = validate($_POST['brukernavn']);
    $passord = validate($_POST['passord']);

    if (empty($brukernavn)) {
        $errors[] = "Username is required!";
    }
    if (empty($passord)) {
        $errors[] = "Password is required!";
    }

    //else {
     //   $errors[] = "Ugyldig brukernavn eller passord!";
   // }
 
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM kunde WHERE Brukernavn='$brukernavn' AND Passord='$passord'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Brukernavn'] === $brukernavn && $row['Passord'] === $passord) {
                $_SESSION['Brukernavn'] = $row['Brukernavn'];
                $_SESSION['id'] = $row['idKunde'];
                var_dump($row);
                 header("Location: home.html"); 
                 exit(); 
            }
        }
    }
}

include "index.php";
?>
