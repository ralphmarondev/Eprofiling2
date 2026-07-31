<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="./assets/images/favicon.svg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - EProfile</title>
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">
</head>

<body class="bg-light">
	<main class="container">
		<div class="row justify-content-center align-items-center min-vh-100">
			<div class="col-md-7 col-lg-5 col-xl-4">
				<div class="text-center mb-4">
					<a href="index.php" class="text-decoration-none">
						<img src="./assets/images/favicon.svg" alt="Logo" width="64" class="mb-3">
					</a>
					<h2 class="fw-bold mb-2">
						Log in to your account
					</h2>
					<p class="text-muted mb-0">
						Enter your username and password below to log in.
					</p>
				</div>
				<div id="alert"></div>
				<form id="loginForm">
					<div class="mb-3">
						<label class="form-label">
							Username
						</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
					</div>

					<div class="mb-2 d-flex justify-content-between align-items-center">
						<label class="form-label mb-0">
							Password
						</label>
						<a href="forgot-password.php" class="small text-decoration-none">
							Forgot your password?
						</a>
					</div>
					<div class="mb-4">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
					</div>
					<button type="submit" class="btn btn-dark w-100 mt-2" id="btnLogin">
						Log in
					</button>
				</form>
			</div>
		</div>
	</main>

	<script src="./assets/js/jquery.min.js"></script>
	<script src="./assets/js/bootstrap.bundle.min.js"></script>

	<script>
		$("#loginForm").submit(function (e) {
			e.preventDefault();
			$("#btnLogin")
				.prop("disabled", true)
				.text("Logging in...");
			$("#alert").html("");
			$.ajax({
				url: "./api/account_login.php",
				type: "POST",
				data: {
					username: $("#username").val(),
					password: $("#password").val()
				},
				dataType: "json",
				success: function (response) {
					if (response.success) {
						window.location.href = "dashboard.php";
					} else {
						$("#alert").html(`
							<div class="alert alert-danger">
								${response.message}
							</div>
						`);
						$("#btnLogin")
							.prop("disabled", false)
							.text("Log in");
					}
				},
				error: function () {
					$("#alert").html(`
						<div class="alert alert-danger">
							Something went wrong. Please try again.
						</div>
					`);
					$("#btnLogin")
						.prop("disabled", false)
						.text("Log in");
				}
			});
		});
	</script>

</body>

</html>