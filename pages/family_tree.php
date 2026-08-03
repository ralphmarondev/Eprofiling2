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

<!-- Add Member Modal -Multi-step with Steps on Left -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
		<div class="modal-dialog modal-xl">
				<div class="modal-content">
						<div class="modal-header">
								<h5 class="modal-title">
										<i class="bi bi-person-plus me-2"></i>
										Add Member to <span id="modalFamilyName">Family</span>
								</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<form id="addMemberForm">
								<div class="modal-body">
										<div class="row g-0">
												<!-- Left Side: Steps -->
												<div class="col-md-3">
														<div class="steps-vertical">
																<div class="step-item active" data-step="1">
																		<div class="step-indicator">
																				<span class="step-number">1</span>
																				<span class="step-check"><i class="bi bi-check"></i></span>
																		</div>
																		<div class="step-info">
																				<span class="step-title">Personal Info</span>
																		</div>
																</div>
																<div class="step-connector"></div>

																<div class="step-item" data-step="2">
																		<div class="step-indicator">
																				<span class="step-number">2</span>
																				<span class="step-check"><i class="bi bi-check"></i></span>
																		</div>
																		<div class="step-info">
																				<span class="step-title">Beneficiary Info</span>
																		</div>
																</div>
														</div>
												</div>

												<!-- Divider Line -->
												<div class="col-md-1 d-none d-md-block p-0">
														<div class="step-divider"></div>
												</div>

												<!-- Right Side: Step Content -->
												<div class="col-md-8">
														<div class="step-content-wrapper">
																<input type="hidden" name="family_id" id="modalFamilyId" value="<?= $family_id ?>">
																<input type="hidden" name="family_code" id="modalFamilyCodeHidden">
																<input type="hidden" name="program_ids" id="programIds" value="">

																<!-- Step 1: Personal Information -->
																<div class="step-content active" data-step="1">
																		<div class="alert alert-info">
																				<i class="bi bi-info-circle me-2"></i>
																				Adding member to family: <strong id="modalFamilyNameDisplay">Family</strong>
																				(Code: <span id="modalFamilyCode">---</span>)
																		</div>

																		<h6 class="fw-semibold mb-3">
																				<i class="bi bi-person-badge me-2"></i>Personal Information
																		</h6>
																		<div class="row">
																				<div class="col-md-6">
																						<div class="mb-3">
																								<label for="memberFirstName" class="form-label fw-semibold">
																										First Name <span class="text-danger">*</span>
																								</label>
																								<input type="text" class="form-control" id="memberFirstName" 
																										placeholder="Enter first name" required>
																						</div>

																						<div class="mb-3">
																								<label for="memberMiddleName" class="form-label fw-semibold">
																										Middle Name <span class="text-muted">(Optional)</span>
																								</label>
																								<input type="text" class="form-control" id="memberMiddleName" 
																										placeholder="Enter middle name">
																						</div>

																						<div class="mb-3">
																								<label for="memberLastName" class="form-label fw-semibold">
																										Last Name <span class="text-danger">*</span>
																								</label>
																								<input type="text" class="form-control" id="memberLastName" 
																										placeholder="Enter last name" required>
																						</div>

																						<div class="mb-3">
																								<label for="memberSuffix" class="form-label fw-semibold">
																										Suffix <span class="text-muted">(Optional)</span>
																								</label>
																								<select class="form-select" id="memberSuffix">
																										<option value="">None</option>
																										<option value="Jr.">Jr.</option>
																										<option value="Sr.">Sr.</option>
																										<option value="II">II</option>
																										<option value="III">III</option>
																										<option value="IV">IV</option>
																								</select>
																						</div>

																						<div class="mb-3">
																								<label for="memberSex" class="form-label fw-semibold">
																										Sex <span class="text-danger">*</span>
																								</label>
																								<select class="form-select" id="memberSex" required>
																										<option value="">Select sex...</option>
																										<option value="male">Male</option>
																										<option value="female">Female</option>
																								</select>
																						</div>

																						<div class="mb-3">
																								<label for="memberDateOfBirth" class="form-label fw-semibold">
																										Date of Birth <span class="text-danger">*</span>
																								</label>
																								<input type="date" class="form-control" id="memberDateOfBirth" required>
																						</div>

																						<div class="mb-3">
																								<label for="memberPlaceOfBirth" class="form-label fw-semibold">
																										Place of Birth <span class="text-danger">*</span>
																								</label>
																								<input type="text" class="form-control" id="memberPlaceOfBirth" 
																										placeholder="City/Municipality, Province" required>
																						</div>
																				</div>

																				<div class="col-md-6">
																						<div class="mb-3">
																								<label for="memberCivilStatus" class="form-label fw-semibold">
																										Civil Status <span class="text-danger">*</span>
																								</label>
																								<select class="form-select" id="memberCivilStatus" required>
																										<option value="">Select status...</option>
																										<option value="single">Single</option>
																										<option value="married">Married</option>
																										<option value="widowed">Widowed</option>
																										<option value="separated">Separated</option>
																										<option value="divorced">Divorced</option>
																								</select>
																						</div>

																						<div class="mb-3">
																								<label for="memberNationality" class="form-label fw-semibold">
																										Nationality <span class="text-danger">*</span>
																								</label>
																								<input type="text" class="form-control" id="memberNationality" 
																										value="Filipino" placeholder="e.g., Filipino" required>
																						</div>

																						<div class="mb-3">
																								<label for="memberReligion" class="form-label fw-semibold">
																										Religion <span class="text-muted">(Optional)</span>
																								</label>
																								<input type="text" class="form-control" id="memberReligion" 
																										placeholder="Enter religion">
																						</div>

																						<div class="mb-3">
																								<label for="memberOccupation" class="form-label fw-semibold">
																										Occupation <span class="text-muted">(Optional)</span>
																								</label>
																								<input type="text" class="form-control" id="memberOccupation" 
																										placeholder="Enter occupation">
																						</div>

																						<div class="mb-3">
																								<label for="memberEducationalAttainment" class="form-label fw-semibold">
																										Educational Attainment <span class="text-muted">(Optional)</span>
																								</label>
																								<input type="text" class="form-control" id="memberEducationalAttainment" 
																										placeholder="e.g., College Graduate">
																						</div>

																						<div class="mb-3">
																								<label for="memberRelationship" class="form-label fw-semibold">
																										Relationship to Head <span class="text-danger">*</span>
																								</label>
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
																				</div>
																		</div>
																</div>

																<!-- Step 2: Beneficiary Information -->
																<div class="step-content" data-step="2" style="display: none;">
																		<h6 class="fw-semibold mb-3">
																				<i class="bi bi-gift me-2"></i>Beneficiary Information
																		</h6>

																		<div class="mb-4">
																				<label for="memberIsIndigenous" class="form-label fw-semibold">
																						Is the member part of an Indigenous Group? <span class="text-danger">*</span>
																				</label>
																				<select class="form-select" id="memberIsIndigenous" name="is_indigenous" required>
																						<option value="">Select...</option>
																						<option value="1">Yes</option>
																						<option value="0">No</option>
																				</select>
																		</div>

																		<div id="indigenousGroupContainer" style="display: none;">
																				<div class="mb-3">
																						<label for="memberIndigenousGroup" class="form-label fw-semibold">
																								Indigenous Group <span class="text-danger">*</span>
																						</label>
																						<input type="text" class="form-control" id="memberIndigenousGroup" name="indigenous_group"
																								placeholder="e.g., Igorot, Lumad, Mangyan" required>
																						<small class="text-muted">Please specify the indigenous group</small>
																				</div>
																		</div>

																		<hr class="my-4">

																		<div class="mb-4">
																				<label class="form-label fw-semibold">
																						Is the member a beneficiary of any program? <span class="text-danger">*</span>
																				</label>
																				<select class="form-select" id="memberIsBeneficiary" name="is_beneficiary" required>
																						<option value="">Select...</option>
																						<option value="1">Yes</option>
																						<option value="0">No</option>
																				</select>
																		</div>

																		<div id="beneficiaryProgramsContainer" style="display: none;">
																				<div class="alert alert-info">
																						<i class="bi bi-info-circle me-2"></i>
																						Select the programs the member is enrolled in. You can select multiple programs.
																				</div>

																				<div class="mb-3">
																						<label class="form-label fw-semibold">
																								<i class="bi bi-check-square me-1"></i>Select Programs
																						</label>
																						<div class="beneficiary-list" id="beneficiaryList">
																								<!-- Will be populated dynamically -->
																						</div>
																				</div>
																		</div>

																		<div class="mb-3">
																				<label for="memberIsVoter" class="form-label fw-semibold">
																						Is the member a registered voter? <span class="text-danger">*</span>
																				</label>
																				<select class="form-select" id="memberIsVoter" name="is_voter" required>
																						<option value="">Select...</option>
																						<option value="1">Yes</option>
																						<option value="0">No</option>
																				</select>
																		</div>
																</div>
														</div>
												</div>
										</div>
								</div>

								<div class="modal-footer">
										<button type="button" class="btn btn-outline-secondary" id="prevStepBtn" style="display: none;">
												<i class="bi bi-arrow-left me-1"></i> Previous
										</button>
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
										<button type="button" class="btn btn-primary" id="nextStepBtn">
												Next <i class="bi bi-arrow-right ms-1"></i>
										</button>
										<button type="button" class="btn btn-success" id="submitBtn" style="display: none;">
												<i class="bi bi-plus-circle me-1"></i> Add Member
										</button>
								</div>
						</form>
				</div>
		</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
		const familyId = <?= $family_id ?>;
		let currentStep = 1;
		const totalSteps = 2;
		let selectedPrograms = [];

		// ============================================
		// LOAD FAMILY INFO AND MEMBERS ON PAGE LOAD
		// ============================================
		loadFamilyInfo(familyId);
		loadFamilyMembers(familyId);
		loadBeneficiaryPrograms();

		// ============================================
		// SEARCH & REFRESH
		// ============================================
		let searchTimeout;
		$('#searchMember').on('keyup', function() {
				clearTimeout(searchTimeout);
				const searchTerm = $(this).val();
				searchTimeout = setTimeout(function() {
						loadFamilyMembers(familyId, searchTerm);
				}, 300);
		});

		// ============================================
		// ADD MEMBER MODAL HANDLING
		// ============================================
		$('#addMemberBtn').on('click', function() {
				resetMemberForm();
				currentStep = 1;
				updateStepUI();
				$('#addMemberModal').modal('show');
		});

		$('#addMemberModal').on('hidden.bs.modal', function() {
				resetMemberForm();
		});

		// Toggle indigenous group field
		$('#memberIsIndigenous').on('change', function() {
				if ($(this).val() === '1') {
						$('#indigenousGroupContainer').slideDown();
						$('#memberIndigenousGroup').prop('required', true);
				} else {
						$('#indigenousGroupContainer').slideUp();
						$('#memberIndigenousGroup').prop('required', false).val('');
				}
		});

		// Toggle beneficiary programs visibility
		$('#memberIsBeneficiary').on('change', function() {
				if ($(this).val() === '1') {
						$('#beneficiaryProgramsContainer').slideDown();
						if ($('#beneficiaryList').children().length === 0) {
								loadBeneficiaryPrograms();
						}
				} else {
						$('#beneficiaryProgramsContainer').slideUp();
						selectedPrograms = [];
						$('#beneficiaryList .form-check-input').prop('checked', false);
						$('#beneficiaryList .beneficiary-item').removeClass('selected');
						updateProgramIds();
				}
		});

		// Function to load beneficiary programs
		function loadBeneficiaryPrograms() {
				$.ajax({
						url: 'api/beneficiary_programs_list.php',
						method: 'GET',
						dataType: 'json',
						success: function(response) {
								if (response.success) {
										renderBeneficiaryPrograms(response.programs);
								}
						},
						error: function() {
								console.error('Failed to load beneficiary programs');
						}
				});
		}

		function renderBeneficiaryPrograms(programs) {
				const container = $('#beneficiaryList');
				container.empty();

				if (programs.length === 0) {
						container.html('<p class="text-muted text-center">No programs available</p>');
						return;
				}

				programs.forEach(function(program) {
						const item = `
								<div class="beneficiary-item" data-id="${program.id}">
										<div class="form-check">
												<input class="form-check-input" type="checkbox" id="program_${program.id}" 
														value="${program.id}">
												<label class="form-check-label" for="program_${program.id}">
														${program.name}
												</label>
												<span class="program-desc">${program.description || ''}</span>
										</div>
								</div>
						`;
						container.append(item);
				});

				container.find('.form-check-input').on('change', function() {
						const id = parseInt($(this).val());
						const name = $(this).closest('.beneficiary-item').find('.form-check-label').text().trim();

						if ($(this).is(':checked')) {
								if (!selectedPrograms.find(p => p.id === id)) {
										selectedPrograms.push({ id, name });
								}
								$(this).closest('.beneficiary-item').addClass('selected');
						} else {
								selectedPrograms = selectedPrograms.filter(p => p.id !== id);
								$(this).closest('.beneficiary-item').removeClass('selected');
						}
						updateProgramIds();
				});
		}

		function updateProgramIds() {
				const ids = selectedPrograms.map(p => p.id).join(',');
				$('#programIds').val(ids);
		}

		// Check relationship selection
		$('#memberRelationship').on('change', function() {
				const value = $(this).val();
				if (value === 'head') {
						$.ajax({
								url: 'api/family_check_head.php',
								method: 'GET',
								data: { family_id: familyId },
								dataType: 'json',
								success: function(response) {
										if (response.has_head) {
												$('#headWarning').show();
										} else {
												$('#headWarning').hide();
										}
								},
								error: function() {
										$('#headWarning').hide();
								}
						});
				} else {
						$('#headWarning').hide();
				}
		});

		// ============================================
		// STEP NAVIGATION
		// ============================================
		function updateStepUI() {
				// Update step indicators
				$('.step-item[data-step]').each(function() {
						const stepNum = parseInt($(this).data('step'));
						$(this).removeClass('active completed');
						if (stepNum === currentStep) {
								$(this).addClass('active');
						} else if (stepNum < currentStep) {
								$(this).addClass('completed');
						}
				});

				// Update step content
				$('.step-content[data-step]').each(function() {
						const stepNum = parseInt($(this).data('step'));
						$(this).toggle(stepNum === currentStep);
				});

				// Update buttons
				$('#prevStepBtn').toggle(currentStep > 1);
				$('#nextStepBtn').toggle(currentStep < totalSteps);
				$('#submitBtn').toggle(currentStep === totalSteps);
		}

		function validateStep(step) {
				const content = $(`.step-content[data-step="${step}"]`);
				const inputs = content.find('input[required], select[required]');
				let isValid = true;

				inputs.each(function() {
						if (!this.checkValidity()) {
								$(this).addClass('is-invalid');
								isValid = false;
						} else {
								$(this).removeClass('is-invalid');
						}
				});

				// Validate beneficiary programs on step 2
				if (step === 2) {
						const isBeneficiary = $('#memberIsBeneficiary').val();
						if (isBeneficiary === '1' && selectedPrograms.length === 0) {
								$('#beneficiaryList').addClass('is-invalid');
								isValid = false;
						} else {
								$('#beneficiaryList').removeClass('is-invalid');
						}
				}

				return isValid;
		}

		$('#nextStepBtn').on('click', function() {
				if (!validateStep(currentStep)) {
						const firstInvalid = $(`.step-content[data-step="${currentStep}"]`).find('.is-invalid').first();
						if (firstInvalid.length) firstInvalid.focus();
						return;
				}
				if (currentStep < totalSteps) {
						currentStep++;
						updateStepUI();
				}
		});

		$('#prevStepBtn').on('click', function() {
				if (currentStep > 1) {
						currentStep--;
						updateStepUI();
				}
		});

		$('.step-item[data-step]').on('click', function() {
				const stepNum = parseInt($(this).data('step'));
				if (stepNum <= currentStep) {
						currentStep = stepNum;
						updateStepUI();
				}
		});

		// ============================================
		// SUBMIT FORM
		// ============================================
		$('#submitBtn').on('click', function() {
				// Validate all steps
				let allValid = true;
				for (let step = 1; step <= totalSteps; step++) {
						if (!validateStep(step)) {
								allValid = false;
								currentStep = step;
								updateStepUI();
								const firstInvalid = $(`.step-content[data-step="${step}"]`).find('.is-invalid').first();
								if (firstInvalid.length) firstInvalid.focus();
								return;
						}
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
						occupation: $('#memberOccupation').val().trim(),
						educational_attainment: $('#memberEducationalAttainment').val().trim(),
						relationship_to_head: $('#memberRelationship').val().toLowerCase(),
						is_indigenous: $('#memberIsIndigenous').val(),
						indigenous_group: $('#memberIndigenousGroup').val().trim(),
						is_beneficiary: $('#memberIsBeneficiary').val(),
						is_voter: $('#memberIsVoter').val(),
						program_ids: $('#programIds').val()
				};

				const btn = $(this);
				btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Adding...');

				$.ajax({
						url: 'api/member_create.php',
						method: 'POST',
						data: formData,
						dataType: 'json',
						success: function(response) {
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
						error: function(xhr) {
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
				$('#headWarning').hide();
				$('#indigenousGroupContainer').hide();
				$('#memberIndigenousGroup').prop('required', false);
				$('#beneficiaryProgramsContainer').hide();
				selectedPrograms = [];
				$('#beneficiaryList .form-check-input').prop('checked', false);
				$('#beneficiaryList .beneficiary-item').removeClass('selected');
				$('#beneficiaryList').removeClass('is-invalid');
				updateProgramIds();
				$('#submitBtn').prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Add Member');
				currentStep = 1;
				updateStepUI();
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
				success: function(response) {
						if (response.success && response.data) {
								const data = response.data;

								$('#familyNameDisplay').text(data.family_name || 'Family');
								$('#displayFamilyCode').text(data.family_code || '-');
								$('#displayFamilyName').text(data.family_name || '-');
								$('#displayAddress').text(data.address || 'Not specified');
								$('#displayContact').text(data.contact_number || 'Not specified');

								$('#modalFamilyName').text(data.family_name || 'Family');
								$('#modalFamilyNameDisplay').text(data.family_name || 'Family');
								$('#modalFamilyCode').text(data.family_code || '---');
								$('#modalFamilyCodeHidden').val(data.family_code || '');
								$('#modalFamilyId').val(data.id || familyId);
						}
				},
				error: function() {
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
				success: function(response) {
						if (response.success) {
								renderFamilyMembers(response.members);
						} else {
								showError(response.message || 'Failed to load members.');
						}
				},
				error: function(xhr) {
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

/* Vertical Steps Styles */
.modal-body {
		padding: 0;
}

.steps-vertical {
		padding: 30px 20px 30px 30px;
		position: relative;
		background: #f8f9fa;
		min-height: 100%;
		border-radius: 0 0 0 8px;
}

.step-item {
		display: flex;
		align-items: center;
		gap: 15px;
		padding: 12px 15px;
		cursor: pointer;
		border-radius: 8px;
		transition: all 0.3s ease;
		position: relative;
}

.step-item:hover {
		background: rgba(13, 110, 253, 0.05);
}

.step-item.active {
		background: rgba(13, 110, 253, 0.1);
}

.step-item.completed {
		background: rgba(25, 135, 84, 0.08);
}

.step-indicator {
		position: relative;
		flex-shrink: 0;
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
		font-size: 13px;
		transition: all 0.3s;
}

.step-item.active .step-number {
		background: #0d6efd;
		color: white;
		box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
}

.step-item.completed .step-number {
		background: #198754;
		color: white;
}

.step-check {
		display: none;
		position: absolute;
		bottom: -4px;
		right: -4px;
		font-size: 12px;
		color: white;
		background: #198754;
		border-radius: 50%;
		width: 18px;
		height: 18px;
		align-items: center;
		justify-content: center;
		border: 2px solid white;
}

.step-item.completed .step-check {
		display: flex;
}

.step-check i {
		font-size: 10px;
}

.step-info {
		flex: 1;
		min-width: 0;
}

.step-title {
		font-size: 14px;
		font-weight: 500;
		color: #495057;
		transition: all 0.3s;
}

.step-item.active .step-title {
		color: #0d6efd;
		font-weight: 600;
}

.step-item.completed .step-title {
		color: #198754;
}

.step-connector {
		height: 20px;
		width: 2px;
		background: #dee2e6;
		margin-left: 15px;
		transition: all 0.3s;
}

.step-item.completed + .step-connector {
		background: #198754;
}

.step-divider {
		height: 100%;
		width: 1px;
		background: #dee2e6;
		margin: 0 auto;
}

.step-content-wrapper {
		padding: 30px 30px 20px 30px;
}

.step-content {
		animation: fadeIn 0.3s ease;
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

/* Beneficiary List Styles */
.beneficiary-list {
		max-height: 300px;
		overflow-y: auto;
		border: 1px solid #dee2e6;
		border-radius: 8px;
		padding: 8px;
}

.beneficiary-list::-webkit-scrollbar {
		width: 6px;
}

.beneficiary-list::-webkit-scrollbar-track {
		background: #f1f1f1;
		border-radius: 10px;
}

.beneficiary-list::-webkit-scrollbar-thumb {
		background: #c1c7cd;
		border-radius: 10px;
}

.beneficiary-list::-webkit-scrollbar-thumb:hover {
		background: #a8b0b8;
}

.beneficiary-item {
		padding: 8px 12px;
		margin-bottom: 2px;
		border-radius: 6px;
		cursor: pointer;
		transition: all 0.2s;
}

.beneficiary-item:hover {
		background: #f8f9fa;
}

.beneficiary-item.selected {
		background: #e7f1ff;
		border-left: 3px solid #0d6efd;
}

.beneficiary-item .form-check {
		margin: 0;
}

.beneficiary-item .form-check-label {
		cursor: pointer;
		font-weight: 500;
		font-size: 13px;
}

.beneficiary-item .program-desc {
		font-size: 11px;
		color: #6c757d;
		margin-left: 28px;
		display: block;
}

.beneficiary-list.is-invalid {
		border-color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 768px) {
		.steps-vertical {
				padding: 15px;
				border-radius: 0;
		}
		.step-item {
				padding: 8px 12px;
				gap: 10px;
		}
		.step-title {
				font-size: 12px;
		}
		.step-number {
				width: 28px;
				height: 28px;
				font-size: 12px;
		}
		.step-connector {
				height: 15px;
				margin-left: 13px;
		}
		.step-content-wrapper {
				padding: 20px 15px;
		}
		.step-divider {
				display: none;
		}
}
</style>