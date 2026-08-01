<!-- Families Page Content -->
<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Families</h5>
		<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFamilyModal">
			<i class="bi bi-plus-circle me-1"></i> Add Family
		</button>
	</div>
	<div class="card-body">
		<!-- Search/Filter Bar -->
		<div class="row mb-3">
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Search families..." id="searchFamily">
			</div>
			<div class="col-md-6 text-md-end">
				<button class="btn btn-outline-secondary btn-sm">
					<i class="bi bi-funnel"></i> Filter
				</button>
				<button class="btn btn-outline-secondary btn-sm">
					<i class="bi bi-arrow-repeat"></i> Refresh
				</button>
			</div>
		</div>

		<!-- Families Table -->
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Family Code</th>
						<th>Family Name</th>
						<th>Head</th>
						<th>Status</th>
						<th>Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Sample data - replace with database queries -->
					<tr>
						<td>1</td>
						<td><span class="badge bg-secondary">FAM-SANTOS</span></td>
						<td><strong>Santos Family</strong></td>
						<td>Juan Santos</td>
						<td><span class="badge bg-success">Approved</span></td>
						<td>2026-01-15</td>
						<td>
							<button class="btn btn-sm btn-outline-primary" title="View">
								<i class="bi bi-eye"></i>
							</button>
							<button class="btn btn-sm btn-outline-warning" title="Edit">
								<i class="bi bi-pencil"></i>
							</button>
							<button class="btn btn-sm btn-outline-danger" title="Delete">
								<i class="bi bi-trash"></i>
							</button>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><span class="badge bg-secondary">FAM-REYES</span></td>
						<td><strong>Reyes Family</strong></td>
						<td>Maria Reyes</td>
						<td><span class="badge bg-warning">Pending</span></td>
						<td>2026-01-20</td>
						<td>
							<button class="btn btn-sm btn-outline-primary" title="View">
								<i class="bi bi-eye"></i>
							</button>
							<button class="btn btn-sm btn-outline-warning" title="Edit">
								<i class="bi bi-pencil"></i>
							</button>
							<button class="btn btn-sm btn-outline-danger" title="Delete">
								<i class="bi bi-trash"></i>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<nav aria-label="Page navigation">
			<ul class="pagination justify-content-end mb-0">
				<li class="page-item disabled">
					<a class="page-link" href="#" tabindex="-1">Previous</a>
				</li>
				<li class="page-item active"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item">
					<a class="page-link" href="#">Next</a>
				</li>
			</ul>
		</nav>
	</div>
</div>

<!-- Create Family Modal - Multi-step with Account -->
<div class="modal fade" id="createFamilyModal" tabindex="-1" aria-labelledby="createFamilyModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createFamilyModalLabel">
					<i class="bi bi-people-fill me-2"></i>Register New Family
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="createFamilyForm" method="POST" action="api/family_create.php">
				<!-- Progress Steps -->
				<div class="px-4 pt-3">
					<div class="d-flex justify-content-between align-items-center">
						<div class="step-indicator d-flex align-items-center" style="flex: 1;">
							<div class="step active" data-step="1">
								<span class="step-number">1</span>
								<span class="step-label">Family Info</span>
							</div>
							<div class="step-line"></div>
							<div class="step" data-step="2">
								<span class="step-number">2</span>
								<span class="step-label">Address</span>
							</div>
							<div class="step-line"></div>
							<div class="step" data-step="3">
								<span class="step-number">3</span>
								<span class="step-label">Head Details</span>
							</div>
							<div class="step-line"></div>
							<div class="step" data-step="4">
								<span class="step-number">4</span>
								<span class="step-label">Account</span>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-body">
					<!-- Step 1: Family Information -->
					<div class="step-content" data-step="1">
						<h6 class="fw-semibold mb-3">
							<i class="bi bi-info-circle me-2"></i>Family Information
						</h6>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="familyCode" class="form-label fw-semibold">
										Family Code <span class="text-danger">*</span>
									</label>
									<div class="input-group">
										<input type="text" class="form-control" id="familyCode" name="family_code"
											placeholder="FAM-FAMILYNAME" required>
										<button type="button" class="btn btn-outline-secondary" id="regenerateCodeBtn"
											title="Generate Code">
											<i class="bi bi-arrow-clockwise"></i>
										</button>
									</div>
									<small class="text-muted">Auto-generated from family name</small>
									<div class="invalid-feedback">Please enter a family code</div>
								</div>

								<div class="mb-3">
									<label for="familyName" class="form-label fw-semibold">
										Family Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="familyName" name="family_name"
										placeholder="Enter family name" required>
									<div class="invalid-feedback">Please enter a family name</div>
								</div>

								<div class="mb-3">
									<label for="householdNumber" class="form-label fw-semibold">
										Household Number <span class="text-muted">(Optional - Barangay numbering)</span>
									</label>
									<input type="text" class="form-control" id="householdNumber" name="household_number"
										placeholder="e.g., 001, 002, or 1">
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label for="householdType" class="form-label fw-semibold">
										Household Type <span class="text-muted">(Optional)</span>
									</label>
									<select class="form-select" id="householdType" name="household_type">
										<option value="">Select type...</option>
										<option value="nuclear">Nuclear</option>
										<option value="extended">Extended</option>
										<option value="single_parent">Single Parent</option>
									</select>
								</div>

								<div class="mb-3">
									<label for="housingOwnership" class="form-label fw-semibold">
										Housing Ownership <span class="text-muted">(Optional)</span>
									</label>
									<select class="form-select" id="housingOwnership" name="housing_ownership">
										<option value="">Select ownership...</option>
										<option value="owned">Owned</option>
										<option value="rented">Rented</option>
										<option value="informal_settler">Informal Settler</option>
									</select>
								</div>

								<div class="mb-3">
									<label for="contactNumber" class="form-label fw-semibold">
										Contact Number <span class="text-muted">(Optional - Mobile/Landline)</span>
									</label>
									<input type="tel" class="form-control" id="contactNumber" name="contact_number"
										placeholder="e.g., 09123456789 or (02) 8123-4567">
								</div>
							</div>
						</div>
					</div>

					<!-- Step 2: Address Details -->
					<div class="step-content" data-step="2" style="display: none;">
						<h6 class="fw-semibold mb-3">
							<i class="bi bi-geo-alt me-2"></i>Address Details
						</h6>
						<div class="row">
							<div class="col-12">
								<div class="mb-3">
									<label for="houseNo" class="form-label fw-semibold">
										House No./Street <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="houseNo" name="house_no"
										placeholder="e.g., 123 Main St, or Blk 5 Lot 8" required>
									<div class="invalid-feedback">Please enter house number or street</div>
								</div>

								<div class="mb-3">
									<label for="barangay" class="form-label fw-semibold">
										Barangay <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter barangay"
										required>
									<div class="invalid-feedback">Please enter barangay</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="municipality" class="form-label fw-semibold">
												Municipality/City <span class="text-danger">*</span>
											</label>
											<input type="text" class="form-control" id="municipality" name="municipality"
												placeholder="Enter municipality/city" required>
											<div class="invalid-feedback">Please enter municipality/city</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="province" class="form-label fw-semibold">
												Province <span class="text-danger">*</span>
											</label>
											<input type="text" class="form-control" id="province" name="province" placeholder="Enter province"
												required>
											<div class="invalid-feedback">Please enter province</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Step 3: Head of Family -->
					<div class="step-content" data-step="3" style="display: none;">
						<h6 class="fw-semibold mb-3">
							<i class="bi bi-person-badge me-2"></i>Head of Family Information
						</h6>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="firstName" class="form-label fw-semibold">
										First Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="firstName" name="first_name"
										placeholder="Enter first name" required>
									<div class="invalid-feedback">Please enter first name</div>
								</div>

								<div class="mb-3">
									<label for="middleName" class="form-label fw-semibold">
										Middle Name <span class="text-muted">(Optional)</span>
									</label>
									<input type="text" class="form-control" id="middleName" name="middle_name"
										placeholder="Enter middle name">
								</div>

								<div class="mb-3">
									<label for="lastName" class="form-label fw-semibold">
										Last Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name"
										required>
									<div class="invalid-feedback">Please enter last name</div>
								</div>

								<div class="mb-3">
									<label for="suffix" class="form-label fw-semibold">
										Suffix <span class="text-muted">(Optional)</span>
									</label>
									<select class="form-select" id="suffix" name="suffix">
										<option value="">None</option>
										<option value="Jr.">Jr.</option>
										<option value="Sr.">Sr.</option>
										<option value="II">II</option>
										<option value="III">III</option>
										<option value="IV">IV</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="religion" class="form-label fw-semibold">
										Religion <span class="text-muted">(Optional)</span>
									</label>
									<input type="text" class="form-control" id="religion" name="religion" placeholder="Enter religion">
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label for="sex" class="form-label fw-semibold">
										Sex <span class="text-danger">*</span>
									</label>
									<select class="form-select" id="sex" name="sex" required>
										<option value="">Select sex...</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
									<div class="invalid-feedback">Please select sex</div>
								</div>

								<div class="mb-3">
									<label for="dateOfBirth" class="form-label fw-semibold">
										Date of Birth <span class="text-danger">*</span>
									</label>
									<input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
									<div class="invalid-feedback">Please enter date of birth</div>
								</div>

								<div class="mb-3">
									<label for="placeOfBirth" class="form-label fw-semibold">
										Place of Birth <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="placeOfBirth" name="place_of_birth"
										placeholder="City/Municipality, Province" required>
									<div class="invalid-feedback">Please enter place of birth</div>
								</div>

								<div class="mb-3">
									<label for="civilStatus" class="form-label fw-semibold">
										Civil Status <span class="text-danger">*</span>
									</label>
									<select class="form-select" id="civilStatus" name="civil_status" required>
										<option value="">Select status...</option>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="widowed">Widowed</option>
										<option value="separated">Separated</option>
										<option value="divorced">Divorced</option>
									</select>
									<div class="invalid-feedback">Please select civil status</div>
								</div>

								<div class="mb-3">
									<label for="nationality" class="form-label fw-semibold">
										Nationality <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="nationality" name="nationality"
										placeholder="e.g., Filipino" required>
									<div class="invalid-feedback">Please enter nationality</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Step 4: Account Information -->
					<div class="step-content" data-step="4" style="display: none;">
						<h6 class="fw-semibold mb-3">
							<i class="bi bi-person-lock me-2"></i>Head of Family Account
						</h6>
						<div class="alert alert-info">
							<i class="bi bi-info-circle me-2"></i>
							Create an account for the head of family to access the system.
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="username" class="form-label fw-semibold">
										Username <span class="text-danger">*</span>
									</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-person"></i></span>
										<input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
											required>
									</div>
									<small class="text-muted">Minimum 3 characters, alphanumeric and underscore only</small>
									<div class="invalid-feedback">Please enter a valid username (min 3 characters, alphanumeric)</div>
								</div>

								<div class="mb-3">
									<label for="email" class="form-label fw-semibold">
										Email Address <span class="text-muted">(Optional)</span>
									</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-envelope"></i></span>
										<input type="email" class="form-control" id="email" name="email"
											placeholder="Enter email address (optional)">
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label for="password" class="form-label fw-semibold">
										Password <span class="text-danger">*</span>
									</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-key"></i></span>
										<input type="password" class="form-control" id="password" name="password"
											placeholder="Enter password" required>
										<button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
											<i class="bi bi-eye"></i>
										</button>
									</div>
									<small class="text-muted">Minimum 6 characters</small>
									<div class="invalid-feedback">Please enter a password (min 6 characters)</div>
								</div>

								<div class="mb-3">
									<label for="confirmPassword" class="form-label fw-semibold">
										Confirm Password <span class="text-danger">*</span>
									</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-check-circle"></i></span>
										<input type="password" class="form-control" id="confirmPassword" name="confirm_password"
											placeholder="Confirm password" required>
										<button type="button" class="btn btn-outline-secondary toggle-password"
											data-target="confirmPassword">
											<i class="bi bi-eye"></i>
										</button>
									</div>
									<div class="invalid-feedback">Passwords do not match</div>
								</div>

								<div class="mb-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="showPasswords" name="show_passwords">
										<label class="form-check-label" for="showPasswords">
											Show passwords
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-primary" id="prevStepBtn" style="display: none;">
						<i class="bi bi-arrow-left me-1"></i> Previous
					</button>
					<button type="button" class="btn btn-primary" id="nextStepBtn">
						Next <i class="bi bi-arrow-right ms-1"></i>
					</button>
					<button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
						<i class="bi bi-check-circle me-1"></i> Register Family
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	/* Step Indicator Styles */
	.step-indicator {
		position: relative;
		margin-bottom: 20px;
	}

	.step {
		display: flex;
		align-items: center;
		gap: 8px;
		cursor: pointer;
		position: relative;
		z-index: 2;
	}

	.step-number {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 32px;
		height: 32px;
		border-radius: 50%;
		background: #e9ecef;
		color: #6c757d;
		font-weight: 600;
		font-size: 14px;
		transition: all 0.3s;
	}

	.step.active .step-number {
		background: #0d6efd;
		color: white;
	}

	.step.completed .step-number {
		background: #198754;
		color: white;
	}

	.step-label {
		font-size: 13px;
		font-weight: 500;
		color: #6c757d;
		transition: all 0.3s;
	}

	.step.active .step-label {
		color: #0d6efd;
	}

	.step.completed .step-label {
		color: #198754;
	}

	.step-line {
		flex: 1;
		height: 2px;
		background: #e9ecef;
		margin: 0 10px;
		position: relative;
		z-index: 1;
		transition: all 0.3s;
	}

	.step-line.completed {
		background: #198754;
	}

	/* Step Content Styles */
	.step-content {
		padding: 10px 0;
		animation: fadeIn 0.3s ease;
	}

	.modal-loading {
		position: relative;
	}

	.modal-loading::after {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(255, 255, 255, 0.7);
		z-index: 999;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(10px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	/* Password toggle button */
	.toggle-password {
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}

	/* Responsive adjustments */
	@media (max-width: 768px) {
		.step-label {
			display: none;
		}
	}
</style>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
	// Add this to your families page script
	$(document).ready(function () {
		loadFamilies();

		// Handle search
		$('#searchFamily').on('keyup', function () {
			const searchTerm = $(this).val().toLowerCase();
			filterFamilies(searchTerm);
		});
	});

	function loadFamilies() {
		$.ajax({
			url: 'api/family_list.php',
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					renderFamilies(response.families);
				} else {
					showError('Failed to load families: ' + response.message);
				}
			},
			error: function () {
				showError('Failed to load families. Please try again.');
			}
		});
	}

	function renderFamilies(families) {
		const tbody = $('.table tbody');
		tbody.empty();

		if (families.length === 0) {
			tbody.html(`
						<tr>
								<td colspan="7" class="text-center text-muted">
										<i class="bi bi-inbox me-2"></i>No families registered yet
								</td>
						</tr>
				`);
			return;
		}

		families.forEach((family, index) => {
			const statusBadge = getBadgeHtml(family.registration_status, family.registration_status_badge);
			const row = `
						<tr>
								<td>${index + 1}</td>
								<td><span class="badge bg-secondary">${family.family_code}</span></td>
								<td><strong>${family.family_name}</strong></td>
								<td>${family.head_name}</td>
								<td>${statusBadge}</td>
								<td>${family.created_at_formatted}</td>
								<td>
										<button class="btn btn-sm btn-outline-primary" title="View" onclick="viewFamily(${family.id})">
												<i class="bi bi-eye"></i>
										</button>
										<button class="btn btn-sm btn-outline-warning" title="Edit" onclick="editFamily(${family.id})">
												<i class="bi bi-pencil"></i>
										</button>
										<button class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteFamily(${family.id})">
												<i class="bi bi-trash"></i>
										</button>
								</td>
						</tr>
				`;
			tbody.append(row);
		});

		// Update pagination or show count
		updatePagination(families.length);
	}

	function filterFamilies(searchTerm) {
		$('.table tbody tr').each(function () {
			const text = $(this).text().toLowerCase();
			$(this).toggle(text.indexOf(searchTerm) > -1);
		});
	}

	function getBadgeHtml(status, badgeClass) {
		const labels = {
			'pending': 'Pending',
			'approved': 'Approved',
			'rejected': 'Rejected'
		};
		return `<span class="badge bg-${badgeClass}">${labels[status] || status}</span>`;
	}

	function updatePagination(count) {
		// You can implement pagination here
		$('.pagination .total-count').text(`${count} families found`);
	}

	function viewFamily(id) {
		// Implement view family details
		console.log('View family:', id);
	}

	function editFamily(id) {
		// Implement edit family
		console.log('Edit family:', id);
	}

	function deleteFamily(id) {
		if (confirm('Are you sure you want to delete this family?')) {
			// Implement delete
			console.log('Delete family:', id);
		}
	}

	function showError(message) {
		// Show error message
		alert(message);
	}
	$(document).ready(function () {
		let currentStep = 1;
		const totalSteps = 4;

		// Function to generate family code from family name
		function generateFamilyCodeFromName(name) {
			if (!name || name.trim() === '') {
				return 'FAM-';
			}
			let cleanName = name.replace(/\s*Family\s*/i, '').trim();
			cleanName = cleanName.replace(/[^a-zA-Z0-9]/g, '');
			cleanName = cleanName.toUpperCase();

			if (cleanName === '') {
				return 'FAM-' + Math.random().toString(36).substring(2, 6).toUpperCase();
			}

			return `FAM-${cleanName}`;
		}

		// Auto-generate family code when family name is typed
		$('#familyName').on('input', function () {
			const familyName = $(this).val();
			const code = generateFamilyCodeFromName(familyName);
			$('#familyCode').val(code);
		});

		// Regenerate code on button click
		$('#regenerateCodeBtn').on('click', function () {
			const familyName = $('#familyName').val();
			if (familyName && familyName.trim() !== '') {
				const code = generateFamilyCodeFromName(familyName);
				$('#familyCode').val(code);

				const icon = $(this).find('i');
				icon.addClass('bi-arrow-clockwise').css('animation', 'spin 0.5s linear');
				setTimeout(() => {
					icon.css('animation', '');
				}, 500);
			} else {
				alert('Please enter a family name first.');
			}
		});

		// Toggle password visibility
		$('.toggle-password').on('click', function () {
			const targetId = $(this).data('target');
			const input = $(`#${targetId}`);
			const icon = $(this).find('i');

			if (input.attr('type') === 'password') {
				input.attr('type', 'text');
				icon.removeClass('bi-eye').addClass('bi-eye-slash');
			} else {
				input.attr('type', 'password');
				icon.removeClass('bi-eye-slash').addClass('bi-eye');
			}
		});

		// Show/hide all passwords
		$('#showPasswords').on('change', function () {
			const show = $(this).is(':checked');
			$('#password, #confirmPassword').each(function () {
				if (show) {
					$(this).attr('type', 'text');
				} else {
					$(this).attr('type', 'password');
				}
			});
			// Update toggle button icons
			$('.toggle-password i').each(function () {
				if (show) {
					$(this).removeClass('bi-eye').addClass('bi-eye-slash');
				} else {
					$(this).removeClass('bi-eye-slash').addClass('bi-eye');
				}
			});
		});

		// Validate password match in real-time
		$('#confirmPassword').on('input', function () {
			const password = $('#password').val();
			const confirm = $(this).val();
			if (password && confirm && password !== confirm) {
				$(this).addClass('is-invalid');
				$(this).removeClass('is-valid');
			} else if (password && confirm && password === confirm) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-invalid is-valid');
			}
		});

		// Navigation functions
		function updateStepUI() {
			// Update step indicators
			$('.step').each(function () {
				const stepNum = parseInt($(this).data('step'));
				$(this).removeClass('active completed');
				if (stepNum === currentStep) {
					$(this).addClass('active');
				} else if (stepNum < currentStep) {
					$(this).addClass('completed');
				}
			});

			// Update step lines
			$('.step-line').each(function (index) {
				$(this).removeClass('completed');
				if (index < currentStep - 1) {
					$(this).addClass('completed');
				}
			});

			// Show/hide step content
			$('.step-content').each(function () {
				const stepNum = parseInt($(this).data('step'));
				if (stepNum === currentStep) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});

			// Update buttons
			if (currentStep === 1) {
				$('#prevStepBtn').hide();
			} else {
				$('#prevStepBtn').show();
			}

			if (currentStep === totalSteps) {
				$('#nextStepBtn').hide();
				$('#submitBtn').show();
			} else {
				$('#nextStepBtn').show();
				$('#submitBtn').hide();
			}
		}

		// Next step
		$('#nextStepBtn').on('click', function () {
			// Validate current step
			const currentStepContent = $(`.step-content[data-step="${currentStep}"]`);
			const inputs = currentStepContent.find('input[required], select[required], textarea[required]');
			let isValid = true;

			inputs.each(function () {
				if (!this.checkValidity()) {
					$(this).addClass('is-invalid');
					isValid = false;
				} else {
					$(this).removeClass('is-invalid');
				}
			});

			// Special validation for step 4 (password match)
			if (currentStep === 4) {
				const password = $('#password').val();
				const confirm = $('#confirmPassword').val();
				if (password && confirm && password !== confirm) {
					$('#confirmPassword').addClass('is-invalid');
					isValid = false;
				}
				if (password && password.length < 6) {
					$('#password').addClass('is-invalid');
					isValid = false;
				}
			}

			if (!isValid) {
				// Show first invalid field
				const firstInvalid = inputs.filter('.is-invalid').first();
				if (firstInvalid.length) {
					firstInvalid.focus();
				}
				return;
			}

			if (currentStep < totalSteps) {
				currentStep++;
				updateStepUI();
			}
		});

		// Previous step
		$('#prevStepBtn').on('click', function () {
			if (currentStep > 1) {
				currentStep--;
				updateStepUI();
			}
		});

		// Step indicator click - allow navigation only to completed steps
		$('.step').on('click', function () {
			const stepNum = parseInt($(this).data('step'));
			if (stepNum <= currentStep) {
				currentStep = stepNum;
				updateStepUI();
			}
		});

		// Form submission 
		$('#createFamilyForm').on('submit', function (e) {
			e.preventDefault();

			// Ensure family code is uppercase
			const code = $('#familyCode').val();
			$('#familyCode').val(code.toUpperCase());

			// Validate all steps
			let allValid = true;
			let firstErrorStep = 1;

			$('.step-content').each(function () {
				const stepNum = parseInt($(this).data('step'));
				const inputs = $(this).find('input[required], select[required], textarea[required]');
				inputs.each(function () {
					if (!this.checkValidity()) {
						$(this).addClass('is-invalid');
						allValid = false;
						if (firstErrorStep === 1) firstErrorStep = stepNum;
					} else {
						$(this).removeClass('is-invalid');
					}
				});
			});

			// Special validation for password match
			const password = $('#password').val();
			const confirm = $('#confirmPassword').val();
			if (password && confirm && password !== confirm) {
				$('#confirmPassword').addClass('is-invalid');
				allValid = false;
			}
			if (password && password.length < 6) {
				$('#password').addClass('is-invalid');
				allValid = false;
			}

			if (!allValid) {
				// Go to first step with errors
				currentStep = firstErrorStep;
				updateStepUI();
				const firstInvalid = $(`.step-content[data-step="${firstErrorStep}"]`).find('.is-invalid').first();
				if (firstInvalid.length) {
					firstInvalid.focus();
				}
				return;
			}

			// Disable submit button
			const submitBtn = $('#submitBtn');
			submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Registering...');

			// Get form data
			const formData = $(this).serialize();

			// Submit to API
			$.ajax({
				url: 'api/family_create.php',
				method: 'POST',
				data: formData,
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// Show success message
						Swal.fire({
							icon: 'success',
							title: 'Success!',
							text: response.message,
							confirmButtonText: 'OK'
						}).then(() => {
							$('#createFamilyModal').modal('hide');
							location.reload(); // Refresh to show new family
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Registration Failed',
							text: response.message,
							confirmButtonText: 'OK'
						});
						submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Register Family');
					}
				},
				error: function (xhr) {
					const response = xhr.responseJSON;
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response?.message || 'An error occurred. Please try again.',
						confirmButtonText: 'OK'
					});
					submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Register Family');
				}
			});
		});

		// Reset form when modal is closed
		$('#createFamilyModal').on('hidden.bs.modal', function () {
			$('#createFamilyForm')[0].reset();
			$('#createFamilyForm').removeClass('was-validated');
			$('.is-invalid').removeClass('is-invalid');
			$('.is-valid').removeClass('is-valid');
			$('#familyCode').val('');
			$('#password, #confirmPassword').attr('type', 'password');
			$('.toggle-password i').removeClass('bi-eye-slash').addClass('bi-eye');
			$('#showPasswords').prop('checked', false);
			currentStep = 1;
			updateStepUI();
		});

		// Initialize
		updateStepUI();
	});

	// Add spin animation for the regenerate button
	const style = document.createElement('style');
	style.textContent = `
		@keyframes spin {
				from { transform: rotate(0deg); }
				to { transform: rotate(360deg); }
		}
	`;
	document.head.appendChild(style);
</script>