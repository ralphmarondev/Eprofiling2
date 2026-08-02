<?php
session_start();
if (!isset($_SESSION["account_id"])) {
	header("Location: login.php");
	exit;
}

// Get the page parameter, default to dashboard
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Define allowed pages for security
$allowed_pages = [
	'dashboard',
	'families',
	'members',
	'accounts',
	'reports',
	'settings',
	'family_tree'
];

// Validate page
if (!in_array($page, $allowed_pages)) {
	$page = 'dashboard';
}

// Page titles mapping
$page_titles = [
	'dashboard' => 'Dashboard',
	'families' => 'Families',
	'members' => 'Members',
	'accounts' => 'Accounts',
	'reports' => 'Reports',
	'settings' => 'Settings',
	'family_tree' => 'Family Tree'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="./assets/images/favicon.svg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $page_titles[$page] ?> - EProfile</title>
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/bootstrap-icons.css">
	<style>
		/* Mobile sidebar overlay */
		.sidebar-overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 1040;
		}

		.sidebar-overlay.active {
			display: block;
		}

		/* Sidebar for mobile */
		.sidebar-mobile {
			position: fixed;
			top: 0;
			left: -280px;
			width: 280px;
			height: 100%;
			background: white;
			z-index: 1050;
			transition: left 0.3s ease;
			overflow-y: auto;
			box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
		}

		.sidebar-mobile.active {
			left: 0;
		}

		.sidebar-mobile .close-btn {
			position: absolute;
			top: 10px;
			right: 10px;
			background: none;
			border: none;
			font-size: 1.5rem;
			cursor: pointer;
			color: #6c757d;
		}

		.sidebar-mobile .close-btn:hover {
			color: #343a40;
		}

		/* Hide desktop sidebar on mobile */
		@media (max-width: 767.98px) {
			.desktop-sidebar {
				display: none !important;
			}
		}

		/* Show mobile hamburger on mobile */
		@media (min-width: 768px) {
			.mobile-hamburger {
				display: none !important;
			}
		}

		/* Topbar adjustments */
		.topbar-brand {
			font-weight: 600;
		}

		@media (max-width: 767.98px) {
			.topbar-brand {
				font-size: 1rem;
			}

			.navbar .container-fluid {
				padding-left: 0.5rem;
				padding-right: 0.5rem;
			}
		}

		/* Active sidebar link styling */
		.list-group-item.active {
			background-color: #0d6efd;
			border-color: #0d6efd;
		}

		/* Content area */
		.main-content {
			min-height: calc(100vh - 72px);
		}
	</style>
</head>

<body class="bg-light">
	<!-- Mobile Sidebar Overlay -->
	<div class="sidebar-overlay" id="sidebarOverlay"></div>

	<!-- Mobile Sidebar -->
	<div class="sidebar-mobile" id="sidebarMobile">
		<button class="close-btn" id="closeSidebar">
			<i class="bi bi-x-lg"></i>
		</button>

		<div class="text-center py-4 border-bottom">
			<img src="assets/images/favicon.svg" alt="Logo" width="60">
			<h5 class="mt-3 mb-0">Eprofiling</h5>
			<small class="text-muted">System</small>
		</div>

		<div class="list-group list-group-flush">
			<a href="?page=dashboard"
				class="list-group-item list-group-item-action <?= $page == 'dashboard' ? 'active' : '' ?>">
				<i class="bi bi-speedometer2 me-2"></i>
				Dashboard
			</a>
			<a href="?page=families"
				class="list-group-item list-group-item-action <?= $page == 'families' ? 'active' : '' ?>">
				<i class="bi bi-people-fill me-2"></i>
				Families
			</a>
			<a href="?page=members" class="list-group-item list-group-item-action <?= $page == 'members' ? 'active' : '' ?>">
				<i class="bi bi-person-lines-fill me-2"></i>
				Members
			</a>
			<a href="?page=accounts"
				class="list-group-item list-group-item-action <?= $page == 'accounts' ? 'active' : '' ?>">
				<i class="bi bi-person-badge-fill me-2"></i>
				Accounts
			</a>
			<a href="?page=reports" class="list-group-item list-group-item-action <?= $page == 'reports' ? 'active' : '' ?>">
				<i class="bi bi-file-earmark-bar-graph-fill me-2"></i>
				Reports
			</a>
			<a href="?page=settings"
				class="list-group-item list-group-item-action <?= $page == 'settings' ? 'active' : '' ?>">
				<i class="bi bi-gear-fill me-2"></i>
				Settings
			</a>
			<a href="api/account_logout.php" class="list-group-item list-group-item-action text-danger">
				<i class="bi bi-box-arrow-right me-2"></i>
				Logout
			</a>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<!-- Desktop Sidebar -->
			<div class="col-md-3 col-lg-2 bg-white border-end vh-100 p-0 shadow-sm desktop-sidebar">
				<div class="text-center py-4 border-bottom">
					<img src="assets/images/favicon.svg" alt="Logo" width="60">
					<h5 class="mt-3 mb-0">Eprofiling</h5>
					<small class="text-muted">System</small>
				</div>
				<div class="list-group list-group-flush">
					<a href="?page=dashboard"
						class="list-group-item list-group-item-action <?= $page == 'dashboard' ? 'active' : '' ?>">
						<i class="bi bi-speedometer2 me-2"></i>
						Dashboard
					</a>
					<a href="?page=families"
						class="list-group-item list-group-item-action <?= $page == 'families' ? 'active' : '' ?>">
						<i class="bi bi-people-fill me-2"></i>
						Families
					</a>
					<a href="?page=members"
						class="list-group-item list-group-item-action <?= $page == 'members' ? 'active' : '' ?>">
						<i class="bi bi-person-lines-fill me-2"></i>
						Members
					</a>
					<a href="?page=accounts"
						class="list-group-item list-group-item-action <?= $page == 'accounts' ? 'active' : '' ?>">
						<i class="bi bi-person-badge-fill me-2"></i>
						Accounts
					</a>
					<a href="?page=reports"
						class="list-group-item list-group-item-action <?= $page == 'reports' ? 'active' : '' ?>">
						<i class="bi bi-file-earmark-bar-graph-fill me-2"></i>
						Reports
					</a>
					<a href="?page=settings"
						class="list-group-item list-group-item-action <?= $page == 'settings' ? 'active' : '' ?>">
						<i class="bi bi-gear-fill me-2"></i>
						Settings
					</a>
					<a href="api/account_logout.php" class="list-group-item list-group-item-action text-danger">
						<i class="bi bi-box-arrow-right me-2"></i>
						Logout
					</a>
				</div>
			</div>

			<!-- Content -->
			<div class="col-md-9 col-lg-10 p-0">
				<!-- Topbar -->
				<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
					<div class="container-fluid">
						<!-- Hamburger Menu (Mobile) -->
						<button class="navbar-toggler border-0 mobile-hamburger" id="hamburgerBtn" type="button">
							<i class="bi bi-list fs-2"></i>
						</button>

						<span class="navbar-brand topbar-brand">
							<?= $page_titles[$page] ?>
						</span>

						<!-- Account Dropdown (Always on right) -->
						<div class="dropdown ms-auto">
							<a class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" href="#" role="button"
								data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-person-circle fs-3 me-2"></i>
								<span class="fw-semibold d-none d-sm-inline">
									<?= htmlspecialchars($_SESSION["username"]); ?>
								</span>
							</a>
							<ul class="dropdown-menu dropdown-menu-end shadow">
								<li class="px-3 py-2">
									<div class="fw-semibold">
										<?= htmlspecialchars($_SESSION["username"]); ?>
									</div>
									<div class="text-muted small">
										<?= htmlspecialchars($_SESSION["role"]); ?>
									</div>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li>
									<a class="dropdown-item text-danger" href="api/account_logout.php">
										<i class="bi bi-box-arrow-right me-2"></i>
										Logout
									</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>

				<!-- Main Content -->
				<div class="container-fluid p-4 main-content">
					<?php
					// Include the appropriate page content
					$page_file = "pages/{$page}.php";
					if (file_exists($page_file)) {
						include $page_file;
					} else {
						// Fallback to dashboard if page file doesn't exist
						include "pages/dashboard.php";
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script>
		// Mobile sidebar functionality
		$(document).ready(function () {
			const sidebar = $('#sidebarMobile');
			const overlay = $('#sidebarOverlay');
			const hamburgerBtn = $('#hamburgerBtn');
			const closeBtn = $('#closeSidebar');

			// Open sidebar
			function openSidebar() {
				sidebar.addClass('active');
				overlay.addClass('active');
				$('body').css('overflow', 'hidden');
			}

			// Close sidebar
			function closeSidebar() {
				sidebar.removeClass('active');
				overlay.removeClass('active');
				$('body').css('overflow', '');
			}

			// Event listeners
			hamburgerBtn.on('click', openSidebar);
			closeBtn.on('click', closeSidebar);
			overlay.on('click', closeSidebar);

			// Close sidebar when a link is clicked
			sidebar.find('.list-group-item').on('click', function () {
				if (!$(this).hasClass('active')) {
					closeSidebar();
				}
			});

			// Handle escape key
			$(document).on('keydown', function (e) {
				if (e.key === 'Escape' && sidebar.hasClass('active')) {
					closeSidebar();
				}
			});
		});
	</script>
</body>

</html>