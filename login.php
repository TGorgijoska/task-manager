<?php 

include 'config.php';

error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$sql = "SELECT * FROM korisnici WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		$_SESSION['korisnik-id']= $row['id'];
		$_SESSION['email']=$row['email'];
		header("Location: welcome.php");
	} else {
		echo "<script>alert('грешка емаил адреса или лозинка')</script>";
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

	<title>Логирај се</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Логирај се</p>
			<div class="input-group">
				<input type="email" placeholder="Е-маил" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Лозинка" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Логирај се</button>
			</div>
			<p class="login-register-text">Немаш профил? <a href="register.php">Регистрирај се овде</a>.</p>
		</form>
	</div>
</body>
</html>