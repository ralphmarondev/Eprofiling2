<?php
session_start();

// Include database connection
// require_once "config/database.php";

// Handle form submission
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	// Get form data
	$family_name = trim($_POST['family_name'] ?? '');
	$head_of_family = trim($_POST['head_of_family'] ?? '');
	$contact_number = trim($_POST['contact_number'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$address = trim($_POST['address'] ?? '');
	$city = trim($_POST['city'] ?? '');
	$province = trim($_POST['province'] ?? '');
	$notes = trim($_POST['notes'] ?? '');
	$member_names = $_POST['member_name'] ?? [];
	$member_roles = $_POST['member_role'] ?? [];
	$member_genders = $_POST['member_gender'] ?? [];

	// Validation
	if (empty($family_name)) {
		$errors['family_name'] = "Family name is required";
	}
	if (empty($head_of_family)) {
		$errors['head_of_family'] = "Head of family is required";
	}
	if (empty($address)) {
		$errors['address'] = "Address is required";
	}
	if (empty($city)) {
		$errors['city'] = "City is required";
	}
	if (empty($province)) {
		$errors['province'] = "Province is required";
	}
	if (empty($member_names) || count(array_filter($member_names)) === 0) {
		$errors['members'] = "At least one family member is required";
	}

	// Validate email if provided
	if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Invalid email address";
	}

	// If no errors, process the registration
	if (empty($errors)) {
		// Here you would insert into database
		$success = true;

		// Clear form data after success
		$_POST = [];
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="./assets/images/favicon.svg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register Family - EProfile</title>
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

		/* Main Content */
		.main-content {
			flex: 1;
			padding: 2rem 0 3rem;
		}

		.registration-card {
			background: white;
			border-radius: 12px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
			padding: 2rem;
			max-width: 800px;
			margin: 0 auto;
		}

		.registration-card .card-title {
			font-size: 1.5rem;
			font-weight: 700;
			color: #212529;
			margin-bottom: 0.25rem;
		}

		.registration-card .card-subtitle {
			color: #6c757d;
			margin-bottom: 1.5rem;
		}

		.info-box {
			background: #f8f9fa;
			border-left: 3px solid #0d6efd;
			padding: 1rem 1.25rem;
			border-radius: 4px;
			margin-bottom: 1.5rem;
			font-size: 0.95rem;
			color: #495057;
		}

		.info-box i {
			color: #0d6efd;
			margin-right: 0.5rem;
		}

		.form-section {
			border-bottom: 1px solid #e9ecef;
			padding-bottom: 1.5rem;
			margin-bottom: 1.5rem;
		}

		.form-section:last-child {
			border-bottom: none;
			margin-bottom: 0;
			padding-bottom: 0;
		}

		.form-section-title {
			font-weight: 600;
			color: #212529;
			margin-bottom: 1rem;
			font-size: 1rem;
		}

		.form-section-title i {
			color: #0d6efd;
			margin-right: 0.5rem;
		}

		.required-field::after {
			content: " *";
			color: #dc3545;
		}

		.member-entry {
			background: #f8f9fa;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			padding: 1rem;
			margin-bottom: 0.75rem;
		}

		.member-entry:hover {
			background: #f1f3f5;
		}

		.btn-add-member {
			border: 1px dashed #0d6efd;
			color: #0d6efd;
			background: transparent;
			transition: all 0.2s;
		}

		.btn-add-member:hover {
			background: #0d6efd;
			color: white;
		}

		.btn-submit {
			background: #0d6efd;
			border: none;
			padding: 0.6rem 2rem;
			font-weight: 600;
			border-radius: 50rem;
		}

		.btn-submit:hover {
			background: #0b5ed7;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
		}

		.btn-outline-secondary {
			border-radius: 50rem;
		}

		.success-icon {
			font-size: 4rem;
			color: #198754;
		}

		.login-link {
			color: #0d6efd;
			text-decoration: none;
			font-weight: 500;
		}

		.login-link:hover {
			text-decoration: underline;
		}

		/* Footer */
		footer {
			background: #f8f9fa;
			border-top: 1px solid #dee2e6;
			padding: 1.5rem 0;
			margin-top: auto;
		}

		@media (max-width: 768px) {
			.registration-card {
				padding: 1.25rem;
			}

			.registration-card .card-title {
				font-size: 1.25rem;
			}

			.member-entry .remove-member {
				margin-top: 0.5rem;
			}
		}
	</style>
</head>

<body>
	<!-- Header -->
	<nav class="navbar">
		<div class="container">
			<div class="navbar-brand">
				EProfile
			</div>
			<a href="login.php" class="btn btn-outline-primary">
				Login
			</a>
		</div>
	</nav>

	<!-- Main Content -->
	<main class="main-content">
		<div class="container">
			<div class="registration-card">
				<?php if ($success): ?>
					<!-- Success Message -->
					<div class="text-center py-4">
						<i class="bi bi-check-circle-fill success-icon"></i>
						<h4 class="mt-3">Registration Successful!</h4>
						<p class="text-muted">
							Your family has been registered and is pending approval.
							You will be notified once approved.
						</p>
						<div class="info-box text-start mt-3">
							<i class="bi bi-info-circle"></i>
							Please allow up to 30 days for approval. If not approved within 30 days,
							your registration will be automatically removed.
						</div>
						<a href="index.php" class="btn btn-submit mt-3">
							<i class="bi bi-house me-2"></i>Return Home
						</a>
					</div>
				<?php else: ?>
					<!-- Registration Form -->
					<h5 class="card-title">Family Registration</h5>
					<p class="card-subtitle">Register your family in the Eprofiling System</p>

					<div class="info-box">
						<i class="bi bi-info-circle"></i>
						After registration, your family will be reviewed by our staff.
						Approval typically takes 1-2 business days.
					</div>

					<form method="POST" action="" id="registrationForm" novalidate>
						<!-- Family Information -->
						<div class="form-section">
							<h6 class="form-section-title">
								<i class="bi bi-people-fill"></i>Family Information
							</h6>

							<div class="row">
								<div class="col-md-12 mb-3">
									<label for="familyName" class="form-label fw-semibold required-field">
										Family Name
									</label>
									<input type="text" class="form-control <?= isset($errors['family_name']) ? 'is-invalid' : '' ?>"
										id="familyName" name="family_name" placeholder="Enter family name"
										value="<?= htmlspecialchars($_POST['family_name'] ?? '') ?>" required>
									<?php if (isset($errors['family_name'])): ?>
										<div class="invalid-feedback"><?= $errors['family_name'] ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="headOfFamily" class="form-label fw-semibold required-field">
										Head of Family
									</label>
									<input type="text" class="form-control <?= isset($errors['head_of_family']) ? 'is-invalid' : '' ?>"
										id="headOfFamily" name="head_of_family" placeholder="Full name of head"
										value="<?= htmlspecialchars($_POST['head_of_family'] ?? '') ?>" required>
									<?php if (isset($errors['head_of_family'])): ?>
										<div class="invalid-feedback"><?= $errors['head_of_family'] ?></div>
									<?php endif; ?>
								</div>

								<div class="col-md-6 mb-3">
									<label for="contactNumber" class="form-label fw-semibold">
										Contact Number
									</label>
									<input type="tel" class="form-control" id="contactNumber" name="contact_number"
										placeholder="e.g., 09123456789" value="<?= htmlspecialchars($_POST['contact_number'] ?? '') ?>">
								</div>
							</div>

							<div class="mb-3">
								<label for="email" class="form-label fw-semibold">
									Email Address
								</label>
								<input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email"
									name="email" placeholder="family@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
								<?php if (isset($errors['email'])): ?>
									<div class="invalid-feedback"><?= $errors['email'] ?></div>
								<?php endif; ?>
							</div>
						</div>

						<!-- Address Information -->
						<div class="form-section">
							<h6 class="form-section-title">
								<i class="bi bi-geo-alt-fill"></i>Address Information
							</h6>

							<div class="mb-3">
								<label for="address" class="form-label fw-semibold required-field">
									Complete Address
								</label>
								<textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" id="address"
									name="address" rows="2" placeholder="House number, street, barangay"
									required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
								<?php if (isset($errors['address'])): ?>
									<div class="invalid-feedback"><?= $errors['address'] ?></div>
								<?php endif; ?>
							</div>

							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="city" class="form-label fw-semibold required-field">
										City/Municipality
									</label>
									<input type="text" class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>" id="city"
										name="city" placeholder="Enter city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required>
									<?php if (isset($errors['city'])): ?>
										<div class="invalid-feedback"><?= $errors['city'] ?></div>
									<?php endif; ?>
								</div>

								<div class="col-md-6 mb-3">
									<label for="province" class="form-label fw-semibold required-field">
										Province
									</label>
									<input type="text" class="form-control <?= isset($errors['province']) ? 'is-invalid' : '' ?>"
										id="province" name="province" placeholder="Enter province"
										value="<?= htmlspecialchars($_POST['province'] ?? '') ?>" required>
									<?php if (isset($errors['province'])): ?>
										<div class="invalid-feedback"><?= $errors['province'] ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="mb-3">
								<label for="notes" class="form-label fw-semibold">
									Additional Notes
								</label>
								<textarea class="form-control" id="notes" name="notes" rows="2"
									placeholder="Any additional information"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
							</div>
						</div>

						<!-- Family Members -->
						<div class="form-section">
							<h6 class="form-section-title">
								<i class="bi bi-person-lines-fill"></i>Family Members
								<span class="text-danger">*</span>
							</h6>

							<?php if (isset($errors['members'])): ?>
								<div class="alert alert-danger alert-sm"><?= $errors['members'] ?></div>
							<?php endif; ?>

							<div id="membersContainer">
								<?php
								$member_names = $_POST['member_name'] ?? [''];
								$member_roles = $_POST['member_role'] ?? ['head'];
								$member_genders = $_POST['member_gender'] ?? [''];

								foreach ($member_names as $index => $name):
									?>
									<div class="member-entry">
										<div class="row g-2">
											<div class="col-md-5">
												<input type="text" class="form-control form-control-sm" placeholder="Full name" name="member_name[]"
													value="<?= htmlspecialchars($name) ?>">
											</div>
											<div class="col-md-3">
												<select class="form-select form-select-sm" name="member_role[]">
													<option value="head" <?= ($member_roles[$index] ?? '') == 'head' ? 'selected' : '' ?>>Head</option>
													<option value="spouse" <?= ($member_roles[$index] ?? '') == 'spouse' ? 'selected' : '' ?>>Spouse
													</option>
													<option value="child" <?= ($member_roles[$index] ?? '') == 'child' ? 'selected' : '' ?>>Child
													</option>
													<option value="relative" <?= ($member_roles[$index] ?? '') == 'relative' ? 'selected' : '' ?>>
														Relative</option>
												</select>
											</div>
											<div class="col-md-3">
												<select class="form-select form-select-sm" name="member_gender[]">
													<option value="">Gender</option>
													<option value="male" <?= ($member_genders[$index] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
													<option value="female" <?= ($member_genders[$index] ?? '') == 'female' ? 'selected' : '' ?>>Female
													</option>
												</select>
											</div>
											<div class="col-md-1">
												<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-member">
													<i class="bi bi-x"></i>
												</button>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>

							<button type="button" class="btn btn-add-member btn-sm mt-2" id="addMemberBtn">
								<i class="bi bi-plus-circle me-1"></i> Add Member
							</button>

							<small class="text-muted d-block mt-2">
								<i class="bi bi-info-circle"></i> At least one member is required
							</small>
						</div>

						<!-- Submit Buttons -->
						<div class="d-flex justify-content-between align-items-center mt-4">
							<a href="index.php" class="btn btn-outline-secondary">
								<i class="bi bi-arrow-left me-1"></i> Back
							</a>
							<button type="submit" class="btn btn-submit">
								<i class="bi bi-check-circle me-1"></i> Register
							</button>
						</div>
					</form>

					<div class="text-center mt-4">
						<small class="text-muted">
							Already have an account? <a href="login.php" class="login-link">Login here</a>
						</small>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<footer>
		<div class="container text-center">
			<h6 class="fw-semibold mb-1">Profiling Management System</h6>
			<small class="text-muted">© 2026 Municipality of Gonzaga, Cagayan. All Rights Reserved.</small>
		</div>
	</footer>

	<script src="./assets/js/jquery.min.js"></script>
	<script src="./assets/js/bootstrap.bundle.min.js"></script>
	<script>
		$(document).ready(function () {
			// Add member row
			$('#addMemberBtn').on('click', function () {
				const memberHTML = `
										<div class="member-entry">
												<div class="row g-2">
														<div class="col-md-5">
																<input type="text" class="form-control form-control-sm" 
																			 placeholder="Full name" name="member_name[]">
														</div>
														<div class="col-md-3">
																<select class="form-select form-select-sm" name="member_role[]">
																		<option value="head">Head</option>
																		<option value="spouse">Spouse</option>
																		<option value="child">Child</option>
																		<option value="relative">Relative</option>
																</select>
														</div>
														<div class="col-md-3">
																<select class="form-select form-select-sm" name="member_gender[]">
																		<option value="">Gender</option>
																		<option value="male">Male</option>
																		<option value="female">Female</option>
																</select>
														</div>
														<div class="col-md-1">
																<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-member">
																		<i class="bi bi-x"></i>
																</button>
														</div>
												</div>
										</div>
								`;
				$('#membersContainer').append(memberHTML);
			});

			// Remove member row
			$(document).on('click', '.remove-member', function () {
				const memberEntries = $('.member-entry');
				if (memberEntries.length > 1) {
					$(this).closest('.member-entry').remove();
				} else {
					alert('At least one member is required.');
				}
			});

			// Form validation
			$('#registrationForm').on('submit', function (e) {
				const form = this;

				let hasMember = false;
				$('input[name="member_name[]"]').each(function () {
					if ($(this).val().trim() !== '') {
						hasMember = true;
					}
				});

				if (!hasMember) {
					e.preventDefault();
					alert('Please add at least one family member.');
					return false;
				}

				if (form.checkValidity() === false) {
					e.preventDefault();
					e.stopPropagation();
				}

				form.classList.add('was-validated');
			});
		});
	</script>
</body>

</html>