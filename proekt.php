<?php
include "header.php";

$id = $_GET['id'];
date_default_timezone_set("Europe/Skopje");

$sql = "SELECT opis FROM proekti WHERE ime='$id'";
$result = mysqli_query($conn, $sql);
$proekt_opis = $result->fetch_array();


//KREIRANJE NOVA ZADACA
if (isset($_POST['novaZad'])) {
    $date = date('Y-m-d', strtotime($_POST['deadline']));
    $ime = $_POST['ime'];
    $prioritet = $_POST['prioritet'];
    $sql = "INSERT INTO zadaci (proekt_id, ime, prioritet, deadline, zavrsen) 
        VALUES ('$id','$ime','$prioritet','$date', 0 )";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "<script>alert('имаше проблем, обиди се повторно')</script>";
    }
}
// KREIRANJE NOV CEKOR
if (isset($_POST['novCekor'])) {
    $ime = $_POST['ime'];
    $zadaca_id = $_POST['zadaca_id'];
    $sql = "INSERT INTO cekori (zadaci_id, ime) VALUES ('$zadaca_id', '$ime')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "<script>alert('имаше проблем, обиди се повторно')</script>";
    }
}
// IZBRISI ZADACA
if (isset($_POST['izbrisiZadaca'])) {
    $zadacaID = $_POST['zadaca_id'];

    $sql = "DELETE FROM zadaci WHERE id='$zadacaID'";
    mysqli_query($conn, $sql);

    if (!mysqli_query($conn, $sql)) {
        echo "<script>('Упс! Обидете се повторно!')</script>";
    }
}
// IZBRISI CEKOR
if (isset($_POST['izbrisiCekor'])) {

    $cekorID = $_POST['cekor_id'];
    $sql = "DELETE FROM cekori WHERE id='$cekorID'";
    mysqli_query($conn, $sql);
    if (!mysqli_query($conn, $sql)) {
        echo "<script>('Упс! Обидете се повторно!')</script>";
    }
}
//  IZBRISI PROEKT
if (isset($_POST['izbrisiProekt'])) {

    $sql = "DELETE FROM proekti WHERE korisnik_id='" . $_SESSION['korisnik-id'] . "' AND ime='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>('Успешно избришан проект!')</script";
        header("Location:welcome.php");
    } else {
        echo "<script>('Упс!Обидете се повторно')</script>";
    }
}
// ZADACATA E ZAVRSENA
if (isset($_POST['zavrsen'])) {
    $zadaca_id = $_POST['zadaca_id'];
    $sql = "UPDATE zadaci SET zavrsen = '1' WHERE id = '$zadaca_id'";
    $zavrsen = mysqli_query($conn, $sql);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/proekt.css">

    <title></title>
</head>

<body>

    <div class="ime">
        <h1><i class="fa fa-angle-double-right"></i> <?php echo $id ?> </h1>

        <button class="btn" id="myBtn">Нова задача</button>
        <form action="proekt.php?id=<?php echo $id ?>" method="post">
            <button class="button" name="izbrisiProekt" title="избриши проект"><i class="fa fa-trash"></i></button>
        </form>
    </div>
    <?php 
    if($proekt_opis[0] != ""){
        echo '
            <div class="opis">
                <button class="button" id="opisBtn"><i class="fa fa-caret-right"></i></button>
                <div id="opis">'. $proekt_opis[0] .'</div>
            </div>';
    }
    
    ?>
    <!-- НОВА ЗАДАЧА МОДАЛ -->
    <div id="myModal" class="modal">
        <!-- ФОРМА / МОДАЛ СОДРЖИНА -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="proekt.php?id=<?php echo $id ?>" method="POST">
                <div class="form">
                    <div class="input-group">
                        <input type="text" name="ime" placeholder="Име" required></input>
                    </div>

                    <p> Приоритет:
                        <input type="radio" name="prioritet" value="висок">Висок </input>
                        <input type="radio" name="prioritet" value="среден">Среден </input>
                        <input type="radio" name="prioritet" value="низок">Низок </input>
                    </p>
                    <input type="date" name="deadline" value="<?php echo date("Y-m-d"); ?>"></input>
                    <input type="submit" name="novaZad" value="Креирај" class="btn"></input>
                </div>
            </form>
        </div>

    </div>
    <hr>
    <!-- ЗАДАЧИ НЕЗАВРШЕНИ -->
    <h5>Незавршени задачи:</h5>
    <section class="wrapper">
        <ul class="column__list">

            <!-- ЗАДАЧИ  -->
            <?php
            $sql = "SELECT * FROM zadaci WHERE proekt_id='$id' AND zavrsen=0 ORDER BY deadline ASC";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {

                    echo
                    '<li class="column__item">            
                        <div class="column__title--wrapper ime">                            
                            <h1><i class="fa fa-angle-double-right"></i> ' . $row['ime'] . ' </h1> 
                            <span class="' . $row['prioritet'] . ' prioritet"><i class="fa fa-bolt"></i> ' . $row['prioritet'] . '</span>
                            <p>рок: <i class="fa fa-calendar"></i> <b>' . $row['deadline'] . '</b></p> 
                            
                        </div>';
                    //----- CEKORI
                    $sqlCekori = "SELECT * FROM cekori WHERE zadaci_id='" . $row['id'] . "'";
                    $cekori = mysqli_query($conn, $sqlCekori);
                    if ($cekori->num_rows > 0) {
                        echo '<ul class="card__list">';
                        while ($cekor = $cekori->fetch_array()) {
                            echo '
                                <li class="card__item">
                                    <h5 class="card__title"><i class="fa fa-angle-right"></i> ' . $cekor['ime'] . '</h5>
                                    <form action="proekt.php?id=' . $id . '" method="POST">  
                                        <input type="hidden" name="cekor_id" value="' . $cekor['id'] . '">
                                        <button class="button" name="izbrisiCekor" title="избриши чекор"><i class="fa fa-trash"></i></button>    
                                    </form> 
                                                                   
                                </li>';
                        }
                        echo '</ul>';
                    }
                    //------- NOV CEKOR
                    echo '
                    <div class="column__item--cta">                       
                            <form action="proekt.php?id=' . $id . '" method="POST">                              
                                <div class="input-group">
                                    <input type="text" name="ime" placeholder="Име" required></input>
                                </div>
                                <input type="hidden" name="zadaca_id" value="' . $row['id'] . '">
                                <input class="btn2" type="submit" name="novCekor" value="Додај чекор"></input>
                            </form>    
                            <form action="proekt.php?id=' . $id . '" method="POST">  
                                <input type="hidden" name="zadaca_id" value="' . $row['id'] . '">
                                <button class="button" name="izbrisiZadaca" title="избриши задача"><i class="fa fa-trash"></i></button>    
                                <button class="button" name="zavrsen" title="Заврши"><i class="fa fa-check-circle"></i></button>    
                            </form>                    
                    </div>
                    
                    </li>
                    ';
                }
            }
            ?>

        </ul>
    </section>
    <hr>
    <!-- ЗАДАЧИ ЗАВРШЕНИ -->    
    <h5>Завршени задачи:</h5>
    <section class="wrapper">
        <ul class="column__list">

            <!-- ЗАДАЧИ  -->
            <?php
            $sql = "SELECT * FROM zadaci WHERE proekt_id='$id' AND zavrsen=1 ORDER BY deadline ASC";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {

                    echo
                    '<li class="column__item">            
                        <div class="column__title--wrapper ime">                            
                            <h1><i class="fa fa-angle-double-right"></i> ' . $row['ime'] . ' </h1> 
                            <span class="' . $row['prioritet'] . ' prioritet"><i class="fa fa-bolt"></i> ' . $row['prioritet'] . '</span>
                            <p>рок: <i class="fa fa-calendar"></i> <b>' . $row['deadline'] . '</b></p> 
                            
                        </div>';
                    //----- CEKORI
                    $sqlCekori = "SELECT * FROM cekori WHERE zadaci_id='" . $row['id'] . "'";
                    $cekori = mysqli_query($conn, $sqlCekori);
                    if ($cekori->num_rows > 0) {
                        echo '<ul class="card__list">';
                        while ($cekor = $cekori->fetch_array()) {
                            echo '
                                <li class="card__item">
                                    <h5 class="card__title"><i class="fa fa-angle-right"></i> ' . $cekor['ime'] . '</h5>
                                    <form action="proekt.php?id=' . $id . '" method="POST">  
                                        <input type="hidden" name="cekor_id" value="' . $cekor['id'] . '">
                                        <button class="button" name="izbrisiCekor" title="избриши чекор"><i class="fa fa-trash"></i></button>    
                                    </form> 
                                                                   
                                </li>';
                        }
                        echo '</ul>';
                    }

                    //------- NOV CEKOR
                    echo '
                    <div class="column__item--cta">                       
                            <form action="proekt.php?id=' . $id . '" method="POST">  
                                <input type="hidden" name="zadaca_id" value="' . $row['id'] . '">
                                <button class="button" name="izbrisiZadaca" title="избриши задача"><i class="fa fa-trash"></i></button>    
                            </form>                    
                    </div>
                    </li>';
                }
            }
            ?>

        </ul>
    </section>

    <script src="assets/js/proekt.js"></script>
</body>

</html>