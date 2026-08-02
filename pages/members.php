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
				<input type="text" class="form-control" placeholder="Search members by name or family code..."
					id="searchMember">
			</div>
			<div class="col-md-6 text-md-end">
				<button class="btn btn-outline-secondary btn-sm" onclick="loadMembers()">
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
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone Number</th>
						<th>Age</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="membersTableBody">
					<tr>
						<td colspan="6" class="text-center text-muted">No members found</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready(function () {
		// ============================================
		// LOAD MEMBERS ON PAGE LOAD
		// ============================================
		loadMembers();

		// ============================================
		// SEARCH & REFRESH
		// ============================================
		$('#searchMember').on('keyup', function () {
			const searchTerm = $(this).val().toLowerCase();
			filterMembers(searchTerm);
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
			resultDiv.html(`
						<div class="alert ${alertClass} alert-dismissible fade show py-2 mb-0" role="alert">
								${message}
								<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
						</div>
				`);
		}
	});

	// ============================================
	// LOAD MEMBERS FUNCTION
	// ============================================
	function loadMembers(search = '') {
		const tbody = $('#membersTableBody');
		tbody.html(`
				<tr>
						<td colspan="6" class="text-center text-muted py-4">
								<div class="spinner-border spinner-border-sm text-primary me-2" role="status">
										<span class="visually-hidden">Loading...</span>
								</div>
								Loading members...
						</td>
				</tr>
		`);

		const url = search ? 'api/member_list.php?search=' + encodeURIComponent(search) : 'api/member_list.php';

		$.ajax({
			url: url,
			method: 'GET',
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

	function filterMembers(searchTerm) {
		$('.table tbody tr').each(function () {
			const text = $(this).text().toLowerCase();
			$(this).toggle(text.indexOf(searchTerm) > -1);
		});
	}

	function renderMembers(members) {
		const tbody = $('#membersTableBody');
		tbody.empty();

		if (!members || members.length === 0) {
			tbody.html(`
						<tr>
								<td colspan="6" class="text-center text-muted">
										<i class="bi bi-inbox me-2"></i>No members found
								</td>
						</tr>
				`);
			return;
		}

		members.forEach((member, index) => {
			const row = `
						<tr>
								<td>${index + 1}</td>
								<td><strong>${member.first_name || '-'}</strong></td>
								<td><strong>${member.last_name || '-'}</strong></td>
								<td>${member.family_contact || '-'}</td>
								<td>${member.age || 'N/A'}</td>
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

	// ============================================
	// GLOBAL FUNCTIONS
	// ============================================
	function viewMember(id) {
		console.log('View member:', id);
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