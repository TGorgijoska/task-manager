<?php

include 'config.php';

error_reporting(0);

if (isset($_SESSION['username'])) {
	header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	$date = date('Y-m-d H:i:s');

	if ($password == $cpassword) {
		$sql = "SELECT * FROM korisnici WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows < 1) {
			$sql = "INSERT INTO korisnici (username, email, password, date_created)
					VALUES ('$username', '$email', '$password', '$date')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				header("Location: login.php");
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Упс, има некој проблем пробај повторно.')</script>";
			}
		} else {
			echo "<script>alert('Постои профил со избраниот емаил')</script>";
		}
	} else {
		echo "<script>alert('Лозинката не се совпаѓа.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="assets/css/log-style.css">

	<title>Регистрација</title>
</head>

<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Регистрирај се</p>
			<div class="input-group">
				<input type="text" placeholder="Kорисничко име" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="E-маил" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Лозинка" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Потврди лозинка" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Регистрирај се</button>
			</div>
			<p class="login-register-text">Имаш профил? <a href="login.php">Логирај се</a>.</p>
		</form>
	</div>
</body>

</html>