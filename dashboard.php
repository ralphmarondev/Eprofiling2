<?php
session_start();
if (!isset($_SESSION["account_id"])) {
	header("Location: login.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="./assets/images/favicon.svg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard - EProfile</title>
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">
</head>

<body class="px-4 py-4">
	<h1>Dashboard</h1>
	<p>
		Welcome,
		<?php echo htmlspecialchars($_SESSION["username"]); ?>!
	</p>
	<p>
		Role:
		<?php echo htmlspecialchars($_SESSION["role"]); ?>
	</p>
	<a href="api/account_logout.php" class="btn btn-danger">
		Logout
	</a>
</body>

</html>