<?php

include "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/proekt.css">
    <title>today</title>
</head>

<body>
    <?php
    $date = date('Y-m-d');
    $sql = "SELECT * FROM `denesni_zadaci`
                    WHERE  korisnikId='" . $_SESSION['korisnik-id'] . "'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        echo "<h2>" . $_SESSION['username'] . "  твоите денешни задачи се: </h2>";
        echo '<section class="wrapper">
                        <ul class="column__list">';
        while ($row = $result->fetch_array()) {

            echo
            '<li class="column__item">            
                                <div class="column__title--wrapper ime">                            
                                    <h1><i class="fa fa-angle-double-right"></i> ' . $row['zadacaIme'] . ' </h1> 
                                    <p>проект: <i>' . $row['proektIme'] . '</i> </p>
                                    <span class="' . $row['prioritet'] . ' prioritet"><i class="fa fa-bolt"></i> ' . $row['prioritet'] . '</span>
                                    <p>рок: <i class="fa fa-calendar"></i> <b>' . $row['deadline'] . '</b></p> 
                                    
                                </div>
                    </li>';
        }
        echo '</ul>
                </section>';
    } else echo '<h2>' . $_SESSION['username'] . '  немаш задачи за денес.  
    <img src="https://editablegifs.com/gifs/gifs/fireworks-1/output.gif?egv=2247"></h2>';
    ?>


</body>

</html>