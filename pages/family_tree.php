<!-- Family Tree Page Content -->
<?php
// Get family ID from URL parameter
$family_id = isset($_GET['family_id']) ? intval($_GET['family_id']) : 0;

// If no family ID provided, redirect to families page
if ($family_id === 0) {
	header("Location: ?page=families");
	exit;
}
?>

<div class="card shadow-sm">
	<div class="card-header">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
			<div>
				<h5 class="mb-0">
					<span id="familyNameDisplay">Loading...</span>
					Family
				</h5>
			</div>
			<div class="mt-2 mt-md-0">
				<button class="btn btn-primary btn-sm" id="addMemberBtn">
					<i class="bi bi-plus-circle me-1"></i> Add Member
				</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<!-- Family Info Bar -->
		<div class="row g-3 mb-4">
			<div class="col-md-4">
				<div class="border rounded p-2 bg-light">
					<small class="text-muted d-block">Family Code</small>
					<strong id="displayFamilyCode">Loading...</strong>
				</div>
			</div>
			<div class="col-md-4">
				<div class="border rounded p-2 bg-light">
					<small class="text-muted d-block">Family Name</small>
					<strong id="displayFamilyName">Loading...</strong>
				</div>
			</div>
			<div class="col-md-4">
				<div class="border rounded p-2 bg-light">
					<small class="text-muted d-block">Contact</small>
					<strong id="displayContact">Loading...</strong>
				</div>
			</div>
			<div class="col-md-12">
				<div class="border rounded p-2 bg-light">
					<small class="text-muted d-block">Address</small>
					<strong id="displayAddress">Loading...</strong>
				</div>
			</div>
		</div>

		<!-- Search/Filter Bar -->
		<div class="row mb-3">
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Search members by name or relationship..."
					id="searchMember">
			</div>
			<div class="col-md-6 text-md-end">
				<button class="btn btn-outline-secondary btn-sm" onclick="loadFamilyMembers(<?= $family_id ?>)">
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
						<th>Relationship to Head</th>
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

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<i class="bi bi-person-plus me-2"></i>
					Add Member to <span id="modalFamilyName">Family</span>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div id="step1">
					<div class="alert alert-success">
						<i class="bi bi-check-circle me-2"></i>
						Adding member to family: <strong id="modalFamilyNameDisplay">Family</strong>
						(Code: <span id="modalFamilyCode">---</span>)
					</div>
					<button class="btn btn-primary" id="continueToDetailsBtn">
						Continue to Member Details <i class="bi bi-arrow-right ms-1"></i>
					</button>
				</div>

				<div id="step2" style="display: none;">
					<form id="addMemberForm">
						<input type="hidden" name="family_id" id="modalFamilyId" value="<?= $family_id ?>">
						<input type="hidden" name="family_code" id="modalFamilyCodeHidden">

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="memberFirstName" class="form-label">First Name *</label>
								<input type="text" class="form-control" id="memberFirstName" required>
							</div>
							<div class="col-md-6 mb-3">
								<label for="memberMiddleName" class="form-label">Middle Name</label>
								<input type="text" class="form-control" id="memberMiddleName">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="memberLastName" class="form-label">Last Name *</label>
								<input type="text" class="form-control" id="memberLastName" required>
							</div>
							<div class="col-md-6 mb-3">
								<label for="memberSuffix" class="form-label">Suffix</label>
								<select class="form-select" id="memberSuffix">
									<option value="">None</option>
									<option value="Jr.">Jr.</option>
									<option value="Sr.">Sr.</option>
									<option value="II">II</option>
									<option value="III">III</option>
									<option value="IV">IV</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="memberSex" class="form-label">Sex *</label>
								<select class="form-select" id="memberSex" required>
									<option value="">Select sex</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="memberDateOfBirth" class="form-label">Date of Birth *</label>
								<input type="date" class="form-control" id="memberDateOfBirth" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="memberPlaceOfBirth" class="form-label">Place of Birth *</label>
								<input type="text" class="form-control" id="memberPlaceOfBirth" required>
							</div>
							<div class="col-md-6 mb-3">
								<label for="memberCivilStatus" class="form-label">Civil Status *</label>
								<select class="form-select" id="memberCivilStatus" required>
									<option value="">Select civil status</option>
									<option value="single">Single</option>
									<option value="married">Married</option>
									<option value="divorced">Divorced</option>
									<option value="widowed">Widowed</option>
									<option value="separated">Separated</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="memberNationality" class="form-label">Nationality *</label>
								<input type="text" class="form-control" id="memberNationality" value="Filipino" required>
							</div>
							<div class="col-md-6 mb-3">
								<label for="memberReligion" class="form-label">Religion</label>
								<input type="text" class="form-control" id="memberReligion">
							</div>
						</div>

						<div class="mb-3">
							<label for="memberRelationship" class="form-label">Relationship to Head *</label>
							<select class="form-select" id="memberRelationship" required>
								<option value="">Select relationship</option>
								<option value="head">Head of Family</option>
								<option value="spouse">Spouse</option>
								<option value="child">Child</option>
							</select>
						</div>

						<div id="headWarning" class="alert alert-warning" style="display: none;">
							<i class="bi bi-exclamation-triangle me-2"></i>
							This family already has a head. Adding a new head will replace the existing one.
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="backToStep1Btn" style="display: none;">
					<i class="bi bi-arrow-left me-1"></i> Back
				</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="submitMemberBtn" style="display: none;">
					<i class="bi bi-plus-circle me-1"></i> Add Member
				</button>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>

<script>
	$(document).ready(function () {
		const familyId = <?= $family_id ?>;

		// ============================================
		// LOAD FAMILY INFO AND MEMBERS ON PAGE LOAD
		// ============================================
		loadFamilyInfo(familyId);
		loadFamilyMembers(familyId);

		// ============================================
		// SEARCH & REFRESH
		// ============================================
		let searchTimeout;
		$('#searchMember').on('keyup', function () {
			clearTimeout(searchTimeout);
			const searchTerm = $(this).val();
			searchTimeout = setTimeout(function () {
				loadFamilyMembers(familyId, searchTerm);
			}, 300);
		});

		// ============================================
		// ADD MEMBER MODAL HANDLING
		// ============================================
		$('#addMemberBtn').on('click', function () {
			resetMemberForm();
			$('#addMemberModal').modal('show');
		});

		$('#addMemberModal').on('hidden.bs.modal', function () {
			resetMemberForm();
		});

		$('#continueToDetailsBtn').on('click', function () {
			$('#step1').hide();
			$('#step2').show();
			$('#backToStep1Btn').show();
			$('#submitMemberBtn').show();
		});

		$('#backToStep1Btn').on('click', function () {
			$('#step2').hide();
			$('#step1').show();
			$('#backToStep1Btn').hide();
			$('#submitMemberBtn').hide();
		});

		// Check relationship selection
		$('#memberRelationship').on('change', function () {
			const value = $(this).val();
			if (value === 'head') {
				$.ajax({
					url: 'api/family_check_head.php',
					method: 'GET',
					data: { family_id: familyId },
					dataType: 'json',
					success: function (response) {
						if (response.has_head) {
							$('#headWarning').show();
						} else {
							$('#headWarning').hide();
						}
					},
					error: function () {
						$('#headWarning').hide();
					}
				});
			} else {
				$('#headWarning').hide();
			}
		});

		// Submit member form
		$('#submitMemberBtn').on('click', function () {
			const form = $('#addMemberForm');

			let isValid = true;
			const inputs = form.find('input[required], select[required]');
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

			const formData = {
				family_id: familyId,
				first_name: $('#memberFirstName').val().trim(),
				middle_name: $('#memberMiddleName').val().trim(),
				last_name: $('#memberLastName').val().trim(),
				suffix: $('#memberSuffix').val(),
				sex: $('#memberSex').val().toLowerCase(),
				date_of_birth: $('#memberDateOfBirth').val(),
				place_of_birth: $('#memberPlaceOfBirth').val().trim(),
				civil_status: $('#memberCivilStatus').val().toLowerCase(),
				nationality: $('#memberNationality').val().trim(),
				religion: $('#memberReligion').val().trim(),
				relationship_to_head: $('#memberRelationship').val().toLowerCase()
			};

			const btn = $(this);
			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Adding...');

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
							text: response.message || 'Member added successfully!',
							confirmButtonText: 'OK'
						}).then(() => {
							$('#addMemberModal').modal('hide');
							loadFamilyMembers(familyId);
							loadFamilyInfo(familyId);
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: response.message || 'Failed to add member.',
							confirmButtonText: 'OK'
						});
						btn.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
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
					btn.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
				}
			});
		});

		// ============================================
		// HELPER FUNCTIONS
		// ============================================
		function resetMemberForm() {
			$('#addMemberForm')[0].reset();
			$('#addMemberForm').removeClass('was-validated');
			$('.is-invalid').removeClass('is-invalid');
			$('.is-valid').removeClass('is-valid');
			$('#step1').show();
			$('#step2').hide();
			$('#backToStep1Btn').hide();
			$('#submitMemberBtn').hide();
			$('#headWarning').hide();
			$('#submitMemberBtn').prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
		}
	});

	// ============================================
	// LOAD FAMILY INFO FUNCTION
	// ============================================
	function loadFamilyInfo(familyId) {
		$.ajax({
			url: 'api/family_view.php',
			method: 'GET',
			data: { id: familyId },
			dataType: 'json',
			success: function (response) {
				if (response.success && response.data) {
					const data = response.data;

					// Update header
					$('#familyNameDisplay').text(data.family_name || 'Family');

					// Update info bar
					$('#displayFamilyCode').text(data.family_code || '-');
					$('#displayFamilyName').text(data.family_name || '-');
					$('#displayAddress').text(data.address || 'Not specified');
					$('#displayContact').text(data.contact_number || 'Not specified');

					// Update modal
					$('#modalFamilyName').text(data.family_name || 'Family');
					$('#modalFamilyNameDisplay').text(data.family_name || 'Family');
					$('#modalFamilyCode').text(data.family_code || '---');
					$('#modalFamilyCodeHidden').val(data.family_code || '');
					$('#modalFamilyId').val(data.id || familyId);
				}
			},
			error: function () {
				console.error('Failed to load family info');
			}
		});
	}

	// ============================================
	// LOAD FAMILY MEMBERS FUNCTION
	// ============================================
	function loadFamilyMembers(familyId, search = '') {
		const tbody = $('#membersTableBody');
		tbody.html(`
				<tr>
						<td colspan="6" class="text-center text-muted py-4">
								<div class="spinner-border spinner-border-sm text-primary me-2" role="status">
										<span class="visually-hidden">Loading...</span>
								</div>
								Loading family members...
						</td>
				</tr>
		`);

		let url = `api/family_members.php?family_id=${familyId}`;
		if (search && search.trim() !== '') {
			url += `&search=${encodeURIComponent(search.trim())}`;
		}

		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					renderFamilyMembers(response.members);
				} else {
					showError(response.message || 'Failed to load members.');
				}
			},
			error: function (xhr) {
				const response = xhr.responseJSON;
				showError(response?.message || 'Failed to load members. Please try again.');
			}
		});
	}

	function renderFamilyMembers(members) {
		const tbody = $('#membersTableBody');
		tbody.empty();

		if (!members || members.length === 0) {
			tbody.html(`
						<tr>
								<td colspan="6" class="text-center text-muted py-4">
										<i class="bi bi-inbox me-2"></i>No members found in this family
								</td>
						</tr>
				`);
			return;
		}

		members.forEach((member, index) => {
			const isHead = member.is_head == 1;
			const relationshipDisplay = isHead ? 'Head' : (member.relationship_display || member.relationship_to_head || '-');

			const row = `
						<tr>
								<td>${index + 1}</td>
								<td><strong>${member.first_name || '-'}</strong></td>
								<td><strong>${member.last_name || '-'}</strong></td>
								<td>
										${isHead ? '<span class="badge bg-primary">Head</span>' :
					`<span class="badge bg-${member.role_badge || 'secondary'}">${relationshipDisplay}</span>`}
								</td>
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
		Swal.fire({
			icon: 'info',
			title: 'Member Details',
			text: 'View functionality coming soon!',
			confirmButtonText: 'OK'
		});
	}

	function editMember(id) {
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

<style>
	.table td {
		vertical-align: middle;
	}

	.badge {
		font-size: 0.75rem;
		padding: 0.35em 0.65em;
	}
</style>