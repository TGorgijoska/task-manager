<?php
include "header.php";

?>
<?php
    if (isset($_POST['sozdadiProekt'])) {
        $imeProekt = $_POST['imeProekt'];
        $opis = $_POST['opis'];

        $sql = "SELECT * FROM proekti WHERE korisnik_id='" . $_SESSION['korisnik-id'] . "' AND ime='$imeProekt'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO proekti (ime, korisnik_id, opis)
                            VALUES('$imeProekt', '" . $_SESSION['korisnik-id'] . "', '$opis')";
            $result = mysqli_query($conn, $sql);
            if ($result) {               
                header("Location:proekt.php?id=$imeProekt");
                
            } else {
                echo "<script>alert('Упс! Имаше грешка. Обидете се повторно!')</script>";
            }
        } else {
            echo "<script>alert('Проектот веќе постои!')</script>";
        }
        
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Создавање нов проект</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/nov_proekt.css">
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div class="input-group">
                <input type="text" name="imeProekt" placeholder="Име на проект" required />
            </div>
            <div class="input-group">
                <input type="text" name="opis" placeholder="Краток опис(опционално)">
            </div>
            <div class="input-group">
                <input class="btn" type="submit" name="sozdadiProekt" value="Создади проект!" />
            </div>

        </form>
    </div>
    
    </form>
</body>

</html>