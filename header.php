<?php
include "config.php";
date_default_timezone_set("Europe/Skopje");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/header.css">

    <title></title>
</head>

<body id="body-pd">
    <!--    HEADER     -->
    <header class="header">
        <div class="header__container">
            <div>
                <img src="assets/img/logo.png" alt="" class="header__img">
            </div>
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
        </div>
    </header>

    <!--========== NAV ==========-->
    <div class="nav" id="navbar">
        <nav class="nav__container">
            <div>

                <div class="nav__list">
                    <div class="nav__items">
                        <a href="welcome.php" class="nav__link">
                            <i class='bx bx-calendar nav__icon'></i>
                            <span class="nav__name"><?php echo date('d-m-Y') ?></span>
                        </a>
                        <a href="profil.php" class="nav__link">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__name">Профил</span>
                        </a>
                        <div class="nav__dropdown">

                            <a class="nav__link">
                                <i class='bx bx-bell nav__icon'></i>
                                <span class="nav__name">Проекти</span>
                                <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                            </a>

                            <div class="nav__dropdown-collapse">
                                <div class="nav__dropdown-content">
                                    <a href="nov_proekt.php" class="nav__dropdown-item nav__link">
                                        <span class="nav__name">Нов проект</span>
                                        <i class='bx bx-plus nav__icon'></i>
                                    </a>
                                    <?php
                                    $korisnikId = $_SESSION['korisnik-id'];
                                    $sql = "SELECT ime FROM proekti WHERE korisnik_id=$korisnikId";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_array()) {
                                            echo '<a href="proekt.php?id=' . $row['ime'] . '" class="nav__dropdown-item"><i class="fa fa-check"></i> ' . $row['ime'] . '</a>';
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="logout.php" class="nav__link nav__logout">
                <i class='bx bx-log-out nav__icon'></i>
                <span class="nav__name">Одлогирај се</span>
            </a>
        </nav>
    </div>

    <script src="assets/js/header.js"></script>
</body>

</html>