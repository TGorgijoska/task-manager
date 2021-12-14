<?php
include "header.php";
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/profil.css">
        <title>Welcome</title>
    </head>

    <body>
        <div class="container">
            <div class="red">

                <?php 
                echo '<h1><i class="fa fa-user"></i> Корисничко име: ' . $_SESSION['username'] . '</h1>';
                echo '<h1><i class="fa fa-envelope"></i> Електронска пошта: ' . $_SESSION['email'] . " </h1>";
                ?>

            </div>
            <div class="red">
                <!-- КОРИСНИЧКО ИМЕ -->
                <form action="" method="post">
                    <div class="input-group">
                        <input class="btn" type="submit" name="korIme" value="Промени корисничко име"></input>
                    </div>
                    <?php
                if (isset($_POST['korIme'])) {
                    echo '
                        <form action="" method="post">
                            <div class="input-group">
                                <input type="text" name="novoKorIme" placeholder="Ново корисничко име" required></input> 
                            </div>
                            <div class="input-group">
                                <input class="btn-z" type="submit" name="zacuvaj" value="Зачувај"></input>
                            </div>
                        </form>';
                }
                if (isset($_POST['zacuvaj'])) {
                    $novoKorIme = $_POST['novoKorIme'];

                    $sql = "SELECT * from korisnici where username='$novoKorIme'";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows >= 1) {
                        echo "<script>alert('Корисничкото име постои')</script>";
                    } else {
                        $sql = "UPDATE korisnici set username='$novoKorIme' where id='" . $_SESSION['korisnik-id'] . "'";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>alert('Успешна промена')</script>";
                            $_SESSION['username'] = $novoKorIme;
                            header("Location:welcome.php");
                        } else
                            echo "<script>alert('Имаше проблем, обиди се повторно')</script>";
                    }
                }
                ?>
                </form>

                <!-- ЕМАИЛ АДРЕСА -->
                <form action="" method="post">
                    <div class="input-group">
                        <input class="btn" type="submit" name="mail" value="Промени е-пошта"></input>
                    </div>
                    <?php
                if (isset($_POST['mail'])) {
                    echo '
                        <form action="profil.php" method="post">
                            <div class="input-group">
                                <input type="email" name="novMail" placeholder="Нова електронска пошта" required></input> 
                            </div>
                            <div class="input-group">
                                <input class="btn-z" type="submit" name="ZacuvajPromena" value="Зачувај"></input>
                            </div>
                        </form>';
                }

                if (isset($_POST['ZacuvajPromena'])) {
                    $novMail = $_POST['novMail'];

                    $sql = "SELECT * FROM korisnici WHERE email='$novMail'";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows >= 1) {
                        echo "<script>alert('Оваа електронска пошта веќе постои!')</script>";
                    } else {
                        $sql = "UPDATE korisnici SET email='$novMail' WHERE id='" . $_SESSION['korisnik-id'] . "'";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>alert('Успешна промена!')</script>";
                            $_SESSION['email'] = $novMail;
                            header("Location:welcome.php");
                        } else {
                            echo "<script>alert('Имаше проблем. Обидете се повторно!')</script>";
                        }
                    }
                }
                ?>
                </form>

                <!---- ЛОЗИНКА --->
                <form action="" method="post">
                    <div class="input-group">
                        <input class="btn" type="submit" name="lozinka" value="Промени лозинка"></input>
                    </div>
                    <?php
                if (isset($_POST['lozinka'])) {
                    echo '
                            <form action="profil.php" method="post">
                                <div class="input-group">
                                    <input type="password" name="staraLoz" placeholder="Стара лозинка" required></input><br>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="novaLoz" placeholder="Нова лозинка" required></input><br>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="potvrdiNovaLoz" placeholder="Потврди нова лозинка" required></input> 
                                </div>
                                <div class="input-group">
                                    <input class="btn-z" type="submit" name="zacuvajLoz" value="Зачувај промени"></input>
                                </div>
                                </div>
                            </form>';
                }
                if (isset($_POST['zacuvajLoz'])) {

                    $staraLoz = md5($_POST['staraLoz']);
                    $novaLoz = md5($_POST['novaLoz']);
                    $potvrdiNovaLoz = md5($_POST['potvrdiNovaLoz']);
                    $sql = "SELECT * FROM korisnici WHERE id='" . $_SESSION['korisnik-id'] . "'";
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_array();
                    if ($row['password'] == $staraLoz && $novaLoz == $potvrdiNovaLoz) {
                        $sql = "UPDATE korisnici SET password='$novaLoz' WHERE id='" . $_SESSION['korisnik-id'] . "'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            echo "<script>alert('Успешна промена на лозинка!')</script>";
                        } else {
                            echo "<script>alert('Упс, дојде до грешка!')</script>";
                        }
                    } else {
                        echo "<script>alert('Неточна лозинка!')</script>";
                    }
                }
                ?>
                </form>
            </div>
        </div>
    </body>

</html>