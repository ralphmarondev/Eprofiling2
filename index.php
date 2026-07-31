<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="./assets/images/favicon.svg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome - EProfile</title>
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">

	<style>
		:root {
			--primary: #0d6efd;
			--background: #f4f6f9;
		}

		html,
		body {
			height: 100%;
		}

		body {
			display: flex;
			flex-direction: column;
			min-height: 100vh;
			background: #f4f6f9;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
		}

		/* Header */
		.navbar {
			background: transparent;
			padding: 1.25rem 0;
		}

		.navbar-brand {
			color: #0d6efd !important;
			font-size: 1.35rem;
			font-weight: 700;
		}

		.navbar .btn {
			border-radius: 50rem;
			padding: .55rem 1.5rem;
		}

		/* Hero */
		.hero {
			flex: 1;
			display: flex;
			align-items: center;
			padding: 4rem 0;
		}

		.hero-title {
			font-size: 2.8rem;
			font-weight: 700;
			color: #212529;
			margin-bottom: .5rem;
		}

		.hero-subtitle {
			color: var(--primary);
			font-size: 1.4rem;
			font-weight: 600;
			margin-bottom: 1.5rem;
		}

		.hero-description {
			color: #6c757d;
			font-size: 1rem;
			line-height: 1.8;
			max-width: 560px;
		}

		.hero-image {
			width: 100%;
			max-width: 240px;
			animation: float 4s ease-in-out infinite;
			user-select: none;
		}

		@keyframes float {
			0% {
				transform: translateY(0px);
			}

			50% {
				transform: translateY(-12px);
			}

			100% {
				transform: translateY(0px);
			}
		}

		/* Footer */
		footer {
			background: #f8f9fa;
			border-top: 1px solid #dee2e6;
		}

		@media (max-width: 991.98px) {
			.hero {
				text-align: center;
				padding: 3rem 0;
			}

			.hero-title {
				font-size: 2.2rem;
			}

			.hero-subtitle {
				font-size: 1.2rem;
			}

			.hero-image {
				max-width: 240px;
				margin-bottom: 2rem;
			}

			.hero-description {
				margin: auto;
			}
		}
	</style>
</head>

<body>
	<!-- Header -->
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<div class="navbar-brand">
				EProfile
			</div>
			<a href="login.php" class="btn btn-outline-none px-4">
				Login
			</a>
		</div>
	</nav>

	<!-- Hero -->
	<main class="hero">
		<div class="container">
			<div class="row align-items-center">
				<!-- Image -->
				<div class="col-lg-6 order-1 order-lg-2 text-center mb-5 mb-lg-0">
					<img src="./assets/images/favicon.svg" alt="Profiling System" class="hero-image img-fluid">
				</div>
				<!-- Text -->
				<div class="col-lg-6 order-2 order-lg-1">
					<h1 class="hero-title">
						Profiling Management System
					</h1>
					<h4 class="hero-subtitle">
						Gonzaga, Cagayan
					</h4>
					<p class="hero-description">
						A centralized digital platform for managing and maintaining
						profiling records within the Municipality of Gonzaga,
						Cagayan. The system provides secure, organized, and efficient
						record management to support faster services and informed
						decision-making.
					</p>
					<div class="mt-4">
						<a href="register_family.php" class="btn btn-primary btn-lg px-4">
							Register Family
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<footer class="py-4">
		<div class="container text-center">
			<h6 class="fw-semibold mb-1">
				Profiling Management System
			</h6>
			<small class="text-muted">
				© 2026 Municipality of Gonzaga, Cagayan. All Rights Reserved.
			</small>
		</div>
	</footer>
	<script src="./assets/js/jquery.js"></script>
	<script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>