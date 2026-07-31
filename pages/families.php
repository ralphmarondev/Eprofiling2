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
						<th>Family Name</th>
						<th>Members</th>
						<th>Head of Family</th>
						<th>Status</th>
						<th>Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Sample data - replace with database queries -->
					<tr>
						<td>1</td>
						<td><strong>Santos Family</strong></td>
						<td><span class="badge bg-info">5</span></td>
						<td>Juan Santos</td>
						<td><span class="badge bg-success">Active</span></td>
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
						<td><strong>Reyes Family</strong></td>
						<td><span class="badge bg-info">3</span></td>
						<td>Maria Reyes</td>
						<td><span class="badge bg-success">Active</span></td>
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
					<tr>
						<td>3</td>
						<td><strong>Garcia Family</strong></td>
						<td><span class="badge bg-info">2</span></td>
						<td>Pedro Garcia</td>
						<td><span class="badge bg-secondary">Inactive</span></td>
						<td>2026-01-25</td>
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

<!-- Create Family Modal -->
<div class="modal fade" id="createFamilyModal" tabindex="-1" aria-labelledby="createFamilyModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createFamilyModalLabel">
					<i class="bi bi-people-fill me-2"></i>Create New Family
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="createFamilyForm" method="POST" action="api/family_create.php">
				<div class="modal-body">
					<!-- Family Information -->
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="familyName" class="form-label fw-semibold">
								Family Name <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="familyName" name="family_name" placeholder="Enter family name"
								required>
							<div class="invalid-feedback">Please enter a family name</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="headOfFamily" class="form-label fw-semibold">
								Head of Family <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="headOfFamily" name="head_of_family"
								placeholder="Full name of head" required>
							<div class="invalid-feedback">Please enter the head of family</div>
						</div>

						<div class="col-md-6 mb-3">
							<label for="contactNumber" class="form-label fw-semibold">
								Contact Number
							</label>
							<input type="tel" class="form-control" id="contactNumber" name="contact_number"
								placeholder="e.g., 09123456789">
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="email" class="form-label fw-semibold">
								Email Address
							</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="family@example.com">
						</div>

						<div class="col-md-6 mb-3">
							<label for="status" class="form-label fw-semibold">
								Status <span class="text-danger">*</span>
							</label>
							<select class="form-select" id="status" name="status" required>
								<option value="">Select status...</option>
								<option value="active">Active</option>
								<option value="inactive">Inactive</option>
							</select>
							<div class="invalid-feedback">Please select a status</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="address" class="form-label fw-semibold">
							Address <span class="text-danger">*</span>
						</label>
						<textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter complete address"
							required></textarea>
						<div class="invalid-feedback">Please enter an address</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="city" class="form-label fw-semibold">
								City/Municipality <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
							<div class="invalid-feedback">Please enter a city</div>
						</div>

						<div class="col-md-6 mb-3">
							<label for="province" class="form-label fw-semibold">
								Province <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="province" name="province" placeholder="Enter province"
								required>
							<div class="invalid-feedback">Please enter a province</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="notes" class="form-label fw-semibold">
							Additional Notes
						</label>
						<textarea class="form-control" id="notes" name="notes" rows="2"
							placeholder="Any additional information about the family"></textarea>
					</div>

					<!-- Divider -->
					<hr>

					<!-- Family Members Section -->
					<h6 class="fw-semibold mb-3">
						<i class="bi bi-person-lines-fill me-2"></i>Family Members
					</h6>

					<div id="membersContainer">
						<div class="member-entry border rounded p-3 mb-2">
							<div class="row g-2">
								<div class="col-md-4">
									<input type="text" class="form-control form-control-sm" placeholder="Full name" name="member_name[]">
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
										<option value="">Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-member">
										<i class="bi bi-x-circle"></i>
									</button>
								</div>
							</div>
						</div>
					</div>

					<button type="button" class="btn btn-outline-primary btn-sm" id="addMemberBtn">
						<i class="bi bi-plus-circle me-1"></i> Add Member
					</button>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-check-circle me-1"></i> Create Family
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	/* Member entry styling */
	.member-entry {
		background-color: #f8f9fa;
		transition: all 0.2s;
	}

	.member-entry:hover {
		background-color: #f1f3f5;
	}

	/* Form validation styling */
	.was-validated .form-control:invalid,
	.was-validated .form-select:invalid {
		border-color: #dc3545;
	}
</style>

<script>
	$(document).ready(function () {
		// Add member row
		$('#addMemberBtn').on('click', function () {
			const memberHTML = `
			<div class="member-entry border rounded p-3 mb-2">
				<div class="row g-2">
					<div class="col-md-4">
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
							<option value="">Select Gender</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-member">
							<i class="bi bi-x-circle"></i>
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
				// Show warning if trying to remove last member
				alert('At least one member is required. If you want to remove this member, please add another one first.');
			}
		});

		// Form validation
		$('#createFamilyForm').on('submit', function (e) {
			// Add was-validated class for Bootstrap validation
			if (this.checkValidity() === false) {
				e.preventDefault();
				e.stopPropagation();
				$(this).addClass('was-validated');
			} else {
				// Form is valid - you can add AJAX submission here
				// For now, we'll let it submit normally
				console.log('Form is valid, submitting...');
				// Remove this line when you have the API endpoint ready
				// e.preventDefault();
			}
		});

		// Reset form when modal is closed
		$('#createFamilyModal').on('hidden.bs.modal', function () {
			$('#createFamilyForm')[0].reset();
			$('#createFamilyForm').removeClass('was-validated');
		});
	});
</script>