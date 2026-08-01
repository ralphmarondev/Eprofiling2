<!-- Members Page Content -->
<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Members</h5>
		<button class="btn btn-primary btn-sm" id="addMemberBtn">
			<i class="bi bi-plus-circle me-1"></i> Add Member
		</button>
	</div>
	<div class="card-body">
		<!-- Search/Filter Bar -->
		<div class="row mb-3">
			<div class="col-md-6">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search members by name or family code..."
						id="searchMember">
					<button class="btn btn-outline-secondary" id="searchMemberBtn">
						<i class="bi bi-search"></i>
					</button>
				</div>
			</div>
			<div class="col-md-6 text-md-end">
				<button class="btn btn-outline-secondary btn-sm" id="refreshMembersBtn">
					<i class="bi bi-arrow-repeat"></i> Refresh
				</button>
			</div>
		</div>

		<!-- Members Table -->
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Family</th>
						<th>Role</th>
						<th>Age</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="membersTableBody">
					<tr>
						<td colspan="6" class="text-center text-muted py-4">
							<i class="bi bi-people fs-3 d-block mb-2"></i>
							No members found
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Member Modal - Two Steps -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addMemberModalLabel">
					<i class="bi bi-person-plus me-2"></i>Add New Member
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="addMemberForm">
				<!-- Step 1: Family Code Verification -->
				<div class="step-content" id="step1">
					<div class="modal-body">
						<div class="alert alert-info">
							<i class="bi bi-info-circle me-2"></i>
							Please enter the family code to add a member to an existing family.
						</div>

						<div class="mb-3">
							<label for="memberFamilyCode" class="form-label fw-semibold">
								Family Code <span class="text-danger">*</span>
							</label>
							<div class="input-group">
								<span class="input-group-text"><i class="bi bi-house"></i></span>
								<input type="text" class="form-control" id="memberFamilyCode"
									placeholder="Enter family code (e.g., FAM-DOE)" required>
								<button class="btn btn-primary" type="button" id="verifyFamilyBtn">
									<i class="bi bi-check-circle"></i> Verify
								</button>
							</div>
							<div id="familyVerificationResult" class="mt-2"></div>
							<small class="text-muted">Enter the family code to verify and continue</small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="continueToDetailsBtn" disabled>
							Continue <i class="bi bi-arrow-right ms-1"></i>
						</button>
					</div>
				</div>

				<!-- Step 2: Member Details -->
				<div class="step-content" id="step2" style="display: none;">
					<div class="modal-body">
						<!-- Family Info Display -->
						<div class="alert alert-success" id="verifiedFamilyInfo">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<strong><i class="bi bi-house-check me-2"></i>Family Verified</strong>
									<div id="familyInfoDisplay" class="mt-1">
										<span class="badge bg-primary me-2" id="verifiedFamilyCode">FAM-DOE</span>
										<span id="verifiedFamilyName">Doe Family</span>
										<span class="text-muted ms-2">| Head: <span id="verifiedHeadName">John Doe</span></span>
									</div>
								</div>
								<button type="button" class="btn btn-sm btn-outline-secondary" id="backToFamilyCodeBtn">
									<i class="bi bi-arrow-left"></i> Change
								</button>
							</div>
						</div>

						<hr>

						<h6 class="fw-semibold mb-3">
							<i class="bi bi-person-badge me-2"></i>Member Information
						</h6>

						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="memberFirstName" class="form-label fw-semibold">
										First Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="memberFirstName" name="first_name"
										placeholder="Enter first name" required>
									<div class="invalid-feedback">Please enter first name</div>
								</div>

								<div class="mb-3">
									<label for="memberMiddleName" class="form-label fw-semibold">
										Middle Name <span class="text-muted">(Optional)</span>
									</label>
									<input type="text" class="form-control" id="memberMiddleName" name="middle_name"
										placeholder="Enter middle name">
								</div>

								<div class="mb-3">
									<label for="memberLastName" class="form-label fw-semibold">
										Last Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="memberLastName" name="last_name"
										placeholder="Enter last name" required>
									<div class="invalid-feedback">Please enter last name</div>
								</div>

								<div class="mb-3">
									<label for="memberSuffix" class="form-label fw-semibold">
										Suffix <span class="text-muted">(Optional)</span>
									</label>
									<select class="form-select" id="memberSuffix" name="suffix">
										<option value="">None</option>
										<option value="Jr.">Jr.</option>
										<option value="Sr.">Sr.</option>
										<option value="II">II</option>
										<option value="III">III</option>
										<option value="IV">IV</option>
									</select>
								</div>

								<div class="mb-3">
									<label for="memberReligion" class="form-label fw-semibold">
										Religion <span class="text-muted">(Optional)</span>
									</label>
									<input type="text" class="form-control" id="memberReligion" name="religion"
										placeholder="Enter religion">
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label for="memberSex" class="form-label fw-semibold">
										Sex <span class="text-danger">*</span>
									</label>
									<select class="form-select" id="memberSex" name="sex" required>
										<option value="">Select sex...</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
									<div class="invalid-feedback">Please select sex</div>
								</div>

								<div class="mb-3">
									<label for="memberDateOfBirth" class="form-label fw-semibold">
										Date of Birth <span class="text-danger">*</span>
									</label>
									<input type="date" class="form-control" id="memberDateOfBirth" name="date_of_birth" required>
									<div class="invalid-feedback">Please enter date of birth</div>
								</div>

								<div class="mb-3">
									<label for="memberPlaceOfBirth" class="form-label fw-semibold">
										Place of Birth <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="memberPlaceOfBirth" name="place_of_birth"
										placeholder="City/Municipality, Province" required>
									<div class="invalid-feedback">Please enter place of birth</div>
								</div>

								<div class="mb-3">
									<label for="memberCivilStatus" class="form-label fw-semibold">
										Civil Status <span class="text-danger">*</span>
									</label>
									<select class="form-select" id="memberCivilStatus" name="civil_status" required>
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
									<label for="memberNationality" class="form-label fw-semibold">
										Nationality <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" id="memberNationality" name="nationality"
										placeholder="e.g., Filipino" required>
									<div class="invalid-feedback">Please enter nationality</div>
								</div>

								<div class="mb-3">
									<label for="memberRelationship" class="form-label fw-semibold">
										Relationship to Head <span class="text-danger">*</span>
									</label>
									<select class="form-select" id="memberRelationship" name="relationship_to_head" required>
										<option value="">Select relationship...</option>
										<option value="head">Head</option>
										<option value="spouse">Spouse</option>
										<option value="child">Child</option>
									</select>
									<div class="invalid-feedback">Please select relationship to head</div>
									<div id="headWarning" class="text-warning mt-1" style="display: none;">
										<i class="bi bi-exclamation-triangle me-1"></i>
										This family already has a head. If you select "Head", the existing head will be replaced.
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="backToStep1Btn">
							<i class="bi bi-arrow-left me-1"></i> Back
						</button>
						<button type="submit" class="btn btn-success" id="submitMemberBtn">
							<i class="bi bi-plus-circle me-1"></i> Add Member
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
	$(document).ready(function () {
		// ============================================
		// LOAD MEMBERS ON PAGE LOAD
		// ============================================
		loadMembers();

		// ============================================
		// SEARCH & REFRESH
		// ============================================
		$('#searchMemberBtn').on('click', function () {
			loadMembers($('#searchMember').val());
		});

		$('#searchMember').on('keyup', function (e) {
			if (e.key === 'Enter') {
				loadMembers($(this).val());
			}
		});

		$('#refreshMembersBtn').on('click', function () {
			$('#searchMember').val('');
			loadMembers();
		});

		// ============================================
		// ADD MEMBER MODAL HANDLING
		// ============================================
		let verifiedFamilyData = null;

		// Open modal
		$('#addMemberBtn').on('click', function () {
			resetMemberForm();
			$('#addMemberModal').modal('show');
		});

		// Reset form when modal is closed
		$('#addMemberModal').on('hidden.bs.modal', function () {
			resetMemberForm();
		});

		// Verify family code
		$('#verifyFamilyBtn').on('click', function () {
			const code = $('#memberFamilyCode').val().trim().toUpperCase();
			if (!code) {
				showVerificationResult('Please enter a family code.', 'danger');
				return;
			}

			// Show loading
			const btn = $(this);
			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Verifying...');
			$('#familyVerificationResult').html('');

			$.ajax({
				url: 'api/family_search.php',
				method: 'GET',
				data: { code: code },
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						verifiedFamilyData = response.family;
						showVerificationResult(
							`<i class="bi bi-check-circle me-1"></i> Family found! <strong>${verifiedFamilyData.family_name}</strong>`,
							'success'
						);
						$('#verifiedFamilyCode').text(verifiedFamilyData.family_code);
						$('#verifiedFamilyName').text(verifiedFamilyData.family_name);
						$('#verifiedHeadName').text(verifiedFamilyData.head_name || 'Not assigned');
						$('#continueToDetailsBtn').prop('disabled', false);

						// Check if family already has a head
						if (verifiedFamilyData.head_name !== 'Not assigned') {
							$('#headWarning').show();
						} else {
							$('#headWarning').hide();
						}
					} else {
						showVerificationResult(response.message || 'Family code not found.', 'danger');
						$('#continueToDetailsBtn').prop('disabled', true);
						verifiedFamilyData = null;
					}
				},
				error: function (xhr) {
					const response = xhr.responseJSON;
					showVerificationResult(response?.message || 'An error occurred. Please try again.', 'danger');
					$('#continueToDetailsBtn').prop('disabled', true);
					verifiedFamilyData = null;
				},
				complete: function () {
					btn.prop('disabled', false).html('<i class="bi bi-check-circle"></i> Verify');
				}
			});
		});

		// Continue to details
		$('#continueToDetailsBtn').on('click', function () {
			if (verifiedFamilyData) {
				$('#step1').hide();
				$('#step2').show();
			}
		});

		// Back to family code
		$('#backToStep1Btn, #backToFamilyCodeBtn').on('click', function () {
			$('#step2').hide();
			$('#step1').show();
		});

		// Check relationship selection
		$('#memberRelationship').on('change', function () {
			const value = $(this).val();
			if (value === 'head' && verifiedFamilyData && verifiedFamilyData.head_name !== 'Not assigned') {
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: 'This family already has a head. Adding a new head will replace the existing one. Continue?',
					showCancelButton: true,
					confirmButtonText: 'Yes, continue',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (!result.isConfirmed) {
						$(this).val('');
					}
				});
			}
		});

		// Submit member form
		$('#addMemberForm').on('submit', function (e) {
			e.preventDefault();

			// Validate form
			let isValid = true;
			const inputs = $('#step2 input[required], #step2 select[required]');
			inputs.each(function () {
				if (!this.checkValidity()) {
					$(this).addClass('is-invalid');
					isValid = false;
				} else {
					$(this).removeClass('is-invalid');
				}
			});

			if (!isValid) {
				const firstInvalid = inputs.filter('.is-invalid').first();
				if (firstInvalid.length) {
					firstInvalid.focus();
				}
				return;
			}

			// Prepare data
			const formData = {
				family_code: verifiedFamilyData.family_code,
				first_name: $('#memberFirstName').val().trim(),
				middle_name: $('#memberMiddleName').val().trim(),
				last_name: $('#memberLastName').val().trim(),
				suffix: $('#memberSuffix').val(),
				sex: $('#memberSex').val(),
				date_of_birth: $('#memberDateOfBirth').val(),
				place_of_birth: $('#memberPlaceOfBirth').val().trim(),
				civil_status: $('#memberCivilStatus').val(),
				nationality: $('#memberNationality').val().trim(),
				religion: $('#memberReligion').val().trim(),
				relationship_to_head: $('#memberRelationship').val()
			};

			// Disable submit button
			const submitBtn = $('#submitMemberBtn');
			submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Adding...');

			$.ajax({
				url: 'api/member_create.php',
				method: 'POST',
				data: formData,
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: 'success',
							title: 'Success!',
							text: response.message,
							confirmButtonText: 'OK'
						}).then(() => {
							$('#addMemberModal').modal('hide');
							loadMembers();
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: response.message,
							confirmButtonText: 'OK'
						});
						submitBtn.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
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
					submitBtn.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
				}
			});
		});

		// Enter key support for family code verification
		$('#memberFamilyCode').on('keyup', function (e) {
			if (e.key === 'Enter') {
				$('#verifyFamilyBtn').click();
			}
		});

		// ============================================
		// HELPER FUNCTIONS
		// ============================================
		function resetMemberForm() {
			$('#addMemberForm')[0].reset();
			$('#addMemberForm').removeClass('was-validated');
			$('.is-invalid').removeClass('is-invalid');
			$('.is-valid').removeClass('is-valid');
			$('#memberFamilyCode').val('');
			$('#familyVerificationResult').html('');
			$('#continueToDetailsBtn').prop('disabled', true);
			$('#step1').show();
			$('#step2').hide();
			verifiedFamilyData = null;
			$('#headWarning').hide();
			$('#submitMemberBtn').prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
		}

		function showVerificationResult(message, type) {
			const resultDiv = $('#familyVerificationResult');
			const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
			const icon = type === 'success' ? '<i class="bi bi-check-circle-fill me-1"></i>' : '<i class="bi bi-exclamation-circle-fill me-1"></i>';
			resultDiv.html(`
						<div class="alert ${alertClass} alert-dismissible fade show py-2 mb-0" role="alert">
								${icon} ${message}
								<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
						</div>
				`);
		}

		// ============================================
		// LOAD MEMBERS FUNCTION
		// ============================================
		function loadMembers(search = '') {
			const tbody = $('#membersTableBody');
			tbody.html(`
						<tr>
								<td colspan="6" class="text-center py-4">
										<div class="spinner-border spinner-border-sm text-primary me-2" role="status">
												<span class="visually-hidden">Loading...</span>
										</div>
										Loading members...
								</td>
						</tr>
				`);

			$.ajax({
				url: 'api/member_list.php',
				method: 'GET',
				data: search ? { search: search } : {},
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						renderMembers(response.members);
					} else {
						showError('Failed to load members: ' + response.message);
					}
				},
				error: function (xhr) {
					const response = xhr.responseJSON;
					showError(response?.message || 'Failed to load members. Please try again.');
				}
			});
		}

		function renderMembers(members) {
			const tbody = $('#membersTableBody');
			tbody.empty();

			if (!members || members.length === 0) {
				tbody.html(`
								<tr>
										<td colspan="6" class="text-center text-muted py-4">
												<i class="bi bi-people fs-3 d-block mb-2"></i>
												No members found
										</td>
								</tr>
						`);
				return;
			}

			members.forEach((member, index) => {
				const roleBadge = `
								<span class="badge bg-${member.role_badge}">
										${member.role_display}
								</span>
						`;

				const row = `
								<tr>
										<td>${index + 1}</td>
										<td>
												<strong>${member.full_name}</strong>
												${member.suffix ? `<small class="text-muted">${member.suffix}</small>` : ''}
												${member.is_head ? ' <i class="bi bi-crown text-warning" title="Head of Family"></i>' : ''}
										</td>
										<td>
												<span class="badge bg-secondary">${member.family_code}</span>
										</td>
										<td>${roleBadge}</td>
										<td>${member.age || 'N/A'} years</td>
										<td>
												<button class="btn btn-sm btn-outline-primary" title="View" onclick="viewMember(${member.id})">
														<i class="bi bi-eye"></i>
												</button>
												<button class="btn btn-sm btn-outline-warning" title="Edit" onclick="editMember(${member.id})">
														<i class="bi bi-pencil"></i>
												</button>
												<button class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteMember(${member.id})">
														<i class="bi bi-trash"></i>
												</button>
										</td>
								</tr>
						`;
				tbody.append(row);
			});
		}

		function showError(message) {
			const tbody = $('#membersTableBody');
			tbody.html(`
						<tr>
								<td colspan="6" class="text-center text-danger py-4">
										<i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
										${message}
								</td>
						</tr>
				`);
		}
	});

	// ============================================
	// GLOBAL FUNCTIONS
	// ============================================
	function viewMember(id) {
		console.log('View member:', id);
		// Implement view member details
		Swal.fire({
			icon: 'info',
			title: 'Member Details',
			text: 'View functionality coming soon!',
			confirmButtonText: 'OK'
		});
	}

	function editMember(id) {
		console.log('Edit member:', id);
		Swal.fire({
			icon: 'info',
			title: 'Edit Member',
			text: 'Edit functionality coming soon!',
			confirmButtonText: 'OK'
		});
	}

	function deleteMember(id) {
		Swal.fire({
			icon: 'warning',
			title: 'Delete Member',
			text: 'Are you sure you want to delete this member?',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete',
			cancelButtonText: 'Cancel',
			confirmButtonColor: '#dc3545'
		}).then((result) => {
			if (result.isConfirmed) {
				// Implement delete API call
				console.log('Delete member:', id);
				Swal.fire({
					icon: 'success',
					title: 'Deleted!',
					text: 'Member has been deleted.',
					confirmButtonText: 'OK'
				});
			}
		});
	}
</script>