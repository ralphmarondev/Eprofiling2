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
				<button class="btn btn-outline-secondary btn-sm" onclick="loadFamilies()">
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
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="6" class="text-center text-muted">No family found</td>
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

<!-- Create Family Modal - Multi-step with Steps on Left -->
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
										<span class="step-title">Family Info</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-step="2">
									<div class="step-indicator">
										<span class="step-number">2</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Address</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-step="3">
									<div class="step-indicator">
										<span class="step-number">3</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Head Details</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-step="4">
									<div class="step-indicator">
										<span class="step-number">4</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Beneficiary</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-step="5">
									<div class="step-indicator">
										<span class="step-number">5</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Account</span>
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
								<!-- Step 1: Family Information -->
								<div class="step-content active" data-step="1">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-info-circle me-2"></i>Family Information
									</h6>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="familyCode" class="form-label fw-semibold">
													Family Code <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="familyCode" name="family_code" readonly>
											</div>

											<div class="mb-3">
												<label for="familyName" class="form-label fw-semibold">
													Family Name <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="familyName" name="family_name"
													placeholder="Enter family name" required>
											</div>

											<div class="mb-3">
												<label for="householdNumber" class="form-label fw-semibold">
													Household Number <span class="text-muted">(Optional)</span>
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
													<option value="childless">Childless</option>
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
													<option value="shared">Shared</option>
													<option value="government">Government</option>
													<option value="informal_settler">Informal Settler</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="contactNumber" class="form-label fw-semibold">
													Contact Number <span class="text-muted">(Optional)</span>
												</label>
												<input type="tel" class="form-control" id="contactNumber" name="contact_number"
													placeholder="e.g., 09123456789">
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
										<div class="col-md-6">
											<div class="mb-3">
												<label for="barangay" class="form-label fw-semibold">
													Barangay <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="barangay" name="barangay"
													placeholder="Enter barangay" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="municipality" class="form-label fw-semibold">
													Municipality/City <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="municipality" name="municipality"
													placeholder="Enter municipality/city" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="province" class="form-label fw-semibold">
													Province <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="province" name="province"
													placeholder="Enter province" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="houseNo" class="form-label fw-semibold">
													House No./Street <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="houseNo" name="house_no"
													placeholder="e.g., 123 Main St, or Blk 5 Lot 8" required>
											</div>
										</div>
									</div>
									<!-- Hidden full address field that will be combined before submission -->
									<input type="hidden" name="address" id="fullAddress">
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
												<input type="text" class="form-control" id="lastName" name="last_name"
													placeholder="Enter last name" required>
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
												<input type="text" class="form-control" id="religion" name="religion"
													placeholder="Enter religion">
											</div>

											<div class="mb-3">
												<label for="relationshipToHead" class="form-label fw-semibold">
													Relationship to Head <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="relationshipToHead" name="relationship_to_head" required>
													<option value="head">Head</option>
												</select>
												<small class="text-muted">This is the head of family</small>
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
											</div>

											<div class="mb-3">
												<label for="dateOfBirth" class="form-label fw-semibold">
													Date of Birth <span class="text-danger">*</span>
												</label>
												<input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
											</div>

											<div class="mb-3">
												<label for="placeOfBirth" class="form-label fw-semibold">
													Place of Birth <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="placeOfBirth" name="place_of_birth"
													placeholder="City/Municipality, Province" required>
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
											</div>

											<div class="mb-3">
												<label for="nationality" class="form-label fw-semibold">
													Nationality <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="nationality" name="nationality"
													placeholder="e.g., Filipino" required>
											</div>

											<div class="mb-3">
												<label for="occupation" class="form-label fw-semibold">
													Occupation <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="occupation" name="occupation"
													placeholder="Enter occupation">
											</div>

											<div class="mb-3">
												<label for="educationalAttainment" class="form-label fw-semibold">
													Educational Attainment <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="educationalAttainment" name="educational_attainment"
													placeholder="e.g., College Graduate">
											</div>

											<div class="mb-3">
												<label for="isVoter" class="form-label fw-semibold">
													Is a registered voter? <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="isVoter" name="is_voter" required>
													<option value="">Select...</option>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<!-- Step 4: Beneficiary Programs -->
								<div class="step-content" data-step="4" style="display: none;">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-gift me-2"></i>Beneficiary Information
									</h6>

									<!-- Indigenous Group Field - Moved to top -->
									<div class="mb-4">
										<label for="isIndigenous" class="form-label fw-semibold">
											Is the head of family part of an Indigenous Group? <span class="text-danger">*</span>
										</label>
										<select class="form-select" id="isIndigenous" name="is_indigenous" required>
											<option value="">Select...</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>

									<div id="indigenousGroupContainer" style="display: none;">
										<div class="mb-3">
											<label for="indigenousGroup" class="form-label fw-semibold">
												Indigenous Group <span class="text-danger">*</span>
											</label>
											<input type="text" class="form-control" id="indigenousGroup" name="indigenous_group"
												placeholder="e.g., Igorot, Lumad, Mangyan" required>
											<small class="text-muted">Please specify the indigenous group</small>
										</div>
									</div>

									<hr class="my-4">

									<!-- Beneficiary Question -->
									<div class="mb-4">
										<label class="form-label fw-semibold">
											Is the family head a beneficiary of any program? <span class="text-danger">*</span>
										</label>
										<select class="form-select" id="isBeneficiary" name="is_beneficiary" required>
											<option value="">Select...</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>

									<div id="beneficiaryProgramsContainer" style="display: none;">
										<div class="alert alert-info">
											<i class="bi bi-info-circle me-2"></i>
											Select the programs the family head is enrolled in. You can select multiple programs.
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="mb-3">
													<label class="form-label fw-semibold">
														<i class="bi bi-check-square me-1"></i>Select Programs
													</label>
													<div class="beneficiary-list" id="beneficiaryList">
														<!-- Will be populated dynamically -->
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Hidden field for selected program IDs -->
									<input type="hidden" name="program_ids" id="programIds" value="">
								</div>

								<!-- Step 5: Account Information -->
								<div class="step-content" data-step="5" style="display: none;">
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
													<input type="text" class="form-control" id="username" name="username"
														placeholder="Enter username" required>
												</div>
												<small class="text-muted">Minimum 3 characters, alphanumeric and underscore only</small>
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
													<button type="button" class="btn btn-outline-secondary toggle-password"
														data-target="password">
														<i class="bi bi-eye"></i>
													</button>
												</div>
												<small class="text-muted">Minimum 6 characters</small>
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
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" id="prevStepBtn" style="display: none;">
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

<!-- View Family Modal - Read Only -->
<div class="modal fade" id="viewFamilyModal" tabindex="-1" aria-labelledby="viewFamilyModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewFamilyModalLabel">
					<i class="bi bi-eye me-2"></i>Family Information
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<div class="row g-0">
					<!-- Left Side: Tabs/Sections -->
					<div class="col-md-3">
						<div class="steps-vertical">
							<div class="step-item active" data-section="1">
								<div class="step-indicator">
									<span class="step-number">1</span>
								</div>
								<div class="step-info">
									<span class="step-title">Family Info</span>
								</div>
							</div>
							<div class="step-connector"></div>
							<div class="step-item" data-section="2">
								<div class="step-indicator">
									<span class="step-number">2</span>
								</div>
								<div class="step-info">
									<span class="step-title">Address</span>
								</div>
							</div>
							<div class="step-connector"></div>
							<div class="step-item" data-section="3">
								<div class="step-indicator">
									<span class="step-number">3</span>
								</div>
								<div class="step-info">
									<span class="step-title">Head Details</span>
								</div>
							</div>
							<div class="step-connector"></div>
							<div class="step-item" data-section="4">
								<div class="step-indicator">
									<span class="step-number">4</span>
								</div>
								<div class="step-info">
									<span class="step-title">Beneficiary</span>
								</div>
							</div>
							<div class="step-connector"></div>
							<div class="step-item" data-section="5">
								<div class="step-indicator">
									<span class="step-number">5</span>
								</div>
								<div class="step-info">
									<span class="step-title">Account</span>
								</div>
							</div>
						</div>
					</div>

					<!-- Divider Line -->
					<div class="col-md-1 d-none d-md-block p-0">
						<div class="step-divider"></div>
					</div>

					<!-- Right Side: Content -->
					<div class="col-md-8">
						<div class="step-content-wrapper">
							<!-- Section 1: Family Information -->
							<div class="step-content active" data-section="1">
								<h6 class="fw-semibold mb-3">
									<i class="bi bi-info-circle me-2"></i>Family Information
								</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Family Code</label>
											<p class="form-control-plaintext" id="view_familyCode">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Family Name</label>
											<p class="form-control-plaintext" id="view_familyName">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Household Number</label>
											<p class="form-control-plaintext" id="view_householdNumber">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Household Type</label>
											<p class="form-control-plaintext" id="view_householdType">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Housing Ownership</label>
											<p class="form-control-plaintext" id="view_housingOwnership">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Contact Number</label>
											<p class="form-control-plaintext" id="view_contactNumber">-</p>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Status</label>
											<p class="form-control-plaintext" id="view_status">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Registration Status</label>
											<p class="form-control-plaintext" id="view_registrationStatus">-</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Section 2: Address -->
							<div class="step-content" data-section="2" style="display: none;">
								<h6 class="fw-semibold mb-3">
									<i class="bi bi-geo-alt me-2"></i>Address Details
								</h6>
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Complete Address</label>
									<p class="form-control-plaintext" id="view_address">-</p>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Barangay</label>
											<p class="form-control-plaintext" id="view_barangay">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Municipality/City</label>
											<p class="form-control-plaintext" id="view_municipality">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Province</label>
											<p class="form-control-plaintext" id="view_province">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">House No./Street</label>
											<p class="form-control-plaintext" id="view_houseNo">-</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Section 3: Head Details -->
							<div class="step-content" data-section="3" style="display: none;">
								<h6 class="fw-semibold mb-3">
									<i class="bi bi-person-badge me-2"></i>Head of Family Information
								</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">First Name</label>
											<p class="form-control-plaintext" id="view_firstName">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Middle Name</label>
											<p class="form-control-plaintext" id="view_middleName">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Last Name</label>
											<p class="form-control-plaintext" id="view_lastName">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Suffix</label>
											<p class="form-control-plaintext" id="view_suffix">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Religion</label>
											<p class="form-control-plaintext" id="view_religion">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Relationship to Head</label>
											<p class="form-control-plaintext" id="view_relationshipToHead">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Sex</label>
											<p class="form-control-plaintext" id="view_sex">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Date of Birth</label>
											<p class="form-control-plaintext" id="view_dateOfBirth">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Place of Birth</label>
											<p class="form-control-plaintext" id="view_placeOfBirth">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Civil Status</label>
											<p class="form-control-plaintext" id="view_civilStatus">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Nationality</label>
											<p class="form-control-plaintext" id="view_nationality">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Occupation</label>
											<p class="form-control-plaintext" id="view_occupation">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Educational Attainment</label>
											<p class="form-control-plaintext" id="view_educationalAttainment">-</p>
										</div>
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Registered Voter</label>
											<p class="form-control-plaintext" id="view_isVoter">-</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Section 4: Beneficiary -->
							<div class="step-content" data-section="4" style="display: none;">
								<h6 class="fw-semibold mb-3">
									<i class="bi bi-gift me-2"></i>Beneficiary Information
								</h6>
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Is a Beneficiary?</label>
									<p class="form-control-plaintext" id="view_isBeneficiary">-</p>
								</div>
								<div id="view_beneficiaryPrograms">
									<div class="mb-3">
										<label class="form-label fw-semibold text-muted">Enrolled Programs</label>
										<div id="view_programsList">
											<p class="text-muted">No programs enrolled</p>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Indigenous Group</label>
									<p class="form-control-plaintext" id="view_isIndigenous">-</p>
								</div>
								<div id="view_indigenousGroupContainer">
									<div class="mb-3">
										<label class="form-label fw-semibold text-muted">Indigenous Group Name</label>
										<p class="form-control-plaintext" id="view_indigenousGroup">-</p>
									</div>
								</div>
							</div>

							<!-- Section 5: Account -->
							<div class="step-content" data-section="5" style="display: none;">
								<h6 class="fw-semibold mb-3">
									<i class="bi bi-person-lock me-2"></i>Account Information
								</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Username</label>
											<p class="form-control-plaintext" id="view_username">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Email</label>
											<p class="form-control-plaintext" id="view_email">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Role</label>
											<p class="form-control-plaintext" id="view_role">-</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label fw-semibold text-muted">Account Status</label>
											<p class="form-control-plaintext" id="view_accountStatus">-</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-circle me-1"></i> Close
				</button>
				<button type="button" class="btn btn-primary" onclick="editFamilyFromView()">
					<i class="bi bi-pencil me-1"></i> Edit
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Update Family Modal - Multi-step with Steps on Left -->
<div class="modal fade" id="updateFamilyModal" tabindex="-1" aria-labelledby="updateFamilyModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="updateFamilyModalLabel">
					<i class="bi bi-pencil-square me-2"></i>Update Family
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="updateFamilyForm" method="POST" action="api/family_update.php">
				<input type="hidden" name="family_id" id="update_familyId">

				<div class="modal-body">
					<div class="row g-0">
						<!-- Left Side: Steps -->
						<div class="col-md-3">
							<div class="steps-vertical">
								<div class="step-item active" data-update-step="1">
									<div class="step-indicator">
										<span class="step-number">1</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Family Info</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-update-step="2">
									<div class="step-indicator">
										<span class="step-number">2</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Address</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-update-step="3">
									<div class="step-indicator">
										<span class="step-number">3</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Head Details</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-update-step="4">
									<div class="step-indicator">
										<span class="step-number">4</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Beneficiary</span>
									</div>
								</div>
								<div class="step-connector"></div>

								<div class="step-item" data-update-step="5">
									<div class="step-indicator">
										<span class="step-number">5</span>
										<span class="step-check"><i class="bi bi-check"></i></span>
									</div>
									<div class="step-info">
										<span class="step-title">Account</span>
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
								<!-- Step 1: Family Information -->
								<div class="step-content active" data-update-step="1">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-info-circle me-2"></i>Family Information
									</h6>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_familyCode" class="form-label fw-semibold">
													Family Code <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_familyCode" name="family_code" readonly>
											</div>

											<div class="mb-3">
												<label for="update_familyName" class="form-label fw-semibold">
													Family Name <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_familyName" name="family_name"
													placeholder="Enter family name" required>
											</div>

											<div class="mb-3">
												<label for="update_householdNumber" class="form-label fw-semibold">
													Household Number <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="update_householdNumber" name="household_number"
													placeholder="e.g., 001, 002, or 1">
											</div>
										</div>

										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_householdType" class="form-label fw-semibold">
													Household Type <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_householdType" name="household_type" required>
													<option value="">Select type...</option>
													<option value="nuclear">Nuclear</option>
													<option value="extended">Extended</option>
													<option value="single_parent">Single Parent</option>
													<option value="childless">Childless</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="update_housingOwnership" class="form-label fw-semibold">
													Housing Ownership <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_housingOwnership" name="housing_ownership" required>
													<option value="">Select ownership...</option>
													<option value="owned">Owned</option>
													<option value="rented">Rented</option>
													<option value="shared">Shared</option>
													<option value="government">Government</option>
													<option value="informal_settler">Informal Settler</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="update_contactNumber" class="form-label fw-semibold">
													Contact Number <span class="text-muted">(Optional)</span>
												</label>
												<input type="tel" class="form-control" id="update_contactNumber" name="contact_number"
													placeholder="e.g., 09123456789">
											</div>
										</div>
									</div>

									<!-- Status and Registration Status -->
									<div class="row mt-2">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_status" class="form-label fw-semibold">
													Status <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_status" name="status" required>
													<option value="active">Active</option>
													<option value="inactive">Inactive</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_registrationStatus" class="form-label fw-semibold">
													Registration Status <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_registrationStatus" name="registration_status" required>
													<option value="pending">Pending</option>
													<option value="approved">Approved</option>
													<option value="rejected">Rejected</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<!-- Step 2: Address Details -->
								<div class="step-content" data-update-step="2" style="display: none;">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-geo-alt me-2"></i>Address Details
									</h6>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_barangay" class="form-label fw-semibold">
													Barangay <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_barangay" name="barangay"
													placeholder="Enter barangay" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_municipality" class="form-label fw-semibold">
													Municipality/City <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_municipality" name="municipality"
													placeholder="Enter municipality/city" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_province" class="form-label fw-semibold">
													Province <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_province" name="province"
													placeholder="Enter province" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_houseNo" class="form-label fw-semibold">
													House No./Street <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_houseNo" name="house_no"
													placeholder="e.g., 123 Main St, or Blk 5 Lot 8" required>
											</div>
										</div>
									</div>
									<input type="hidden" name="address" id="update_fullAddress">
								</div>

								<!-- Step 3: Head of Family -->
								<div class="step-content" data-update-step="3" style="display: none;">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-person-badge me-2"></i>Head of Family Information
									</h6>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_firstName" class="form-label fw-semibold">
													First Name <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_firstName" name="first_name"
													placeholder="Enter first name" required>
											</div>

											<div class="mb-3">
												<label for="update_middleName" class="form-label fw-semibold">
													Middle Name <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="update_middleName" name="middle_name"
													placeholder="Enter middle name">
											</div>

											<div class="mb-3">
												<label for="update_lastName" class="form-label fw-semibold">
													Last Name <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_lastName" name="last_name"
													placeholder="Enter last name" required>
											</div>

											<div class="mb-3">
												<label for="update_suffix" class="form-label fw-semibold">
													Suffix <span class="text-muted">(Optional)</span>
												</label>
												<select class="form-select" id="update_suffix" name="suffix">
													<option value="">None</option>
													<option value="Jr.">Jr.</option>
													<option value="Sr.">Sr.</option>
													<option value="II">II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="update_religion" class="form-label fw-semibold">
													Religion <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="update_religion" name="religion"
													placeholder="Enter religion">
											</div>

											<div class="mb-3">
												<label for="update_relationshipToHead" class="form-label fw-semibold">
													Relationship to Head <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_relationshipToHead" name="relationship_to_head" required>
													<option value="head">Head</option>
												</select>
												<small class="text-muted">This is the head of family</small>
											</div>
										</div>

										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_sex" class="form-label fw-semibold">
													Sex <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_sex" name="sex" required>
													<option value="">Select sex...</option>
													<option value="male">Male</option>
													<option value="female">Female</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="update_dateOfBirth" class="form-label fw-semibold">
													Date of Birth <span class="text-danger">*</span>
												</label>
												<input type="date" class="form-control" id="update_dateOfBirth" name="date_of_birth" required>
											</div>

											<div class="mb-3">
												<label for="update_placeOfBirth" class="form-label fw-semibold">
													Place of Birth <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_placeOfBirth" name="place_of_birth"
													placeholder="City/Municipality, Province" required>
											</div>

											<div class="mb-3">
												<label for="update_civilStatus" class="form-label fw-semibold">
													Civil Status <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_civilStatus" name="civil_status" required>
													<option value="">Select status...</option>
													<option value="single">Single</option>
													<option value="married">Married</option>
													<option value="widowed">Widowed</option>
													<option value="separated">Separated</option>
													<option value="divorced">Divorced</option>
												</select>
											</div>

											<div class="mb-3">
												<label for="update_nationality" class="form-label fw-semibold">
													Nationality <span class="text-danger">*</span>
												</label>
												<input type="text" class="form-control" id="update_nationality" name="nationality"
													placeholder="e.g., Filipino" required>
											</div>

											<div class="mb-3">
												<label for="update_occupation" class="form-label fw-semibold">
													Occupation <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="update_occupation" name="occupation"
													placeholder="Enter occupation">
											</div>

											<div class="mb-3">
												<label for="update_educationalAttainment" class="form-label fw-semibold">
													Educational Attainment <span class="text-muted">(Optional)</span>
												</label>
												<input type="text" class="form-control" id="update_educationalAttainment"
													name="educational_attainment" placeholder="e.g., College Graduate">
											</div>

											<div class="mb-3">
												<label for="update_isVoter" class="form-label fw-semibold">
													Is a registered voter? <span class="text-danger">*</span>
												</label>
												<select class="form-select" id="update_isVoter" name="is_voter" required>
													<option value="">Select...</option>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<!-- Step 4: Beneficiary Programs -->
								<div class="step-content" data-update-step="4" style="display: none;">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-gift me-2"></i>Beneficiary Information
									</h6>

									<div class="mb-4">
										<label for="update_isIndigenous" class="form-label fw-semibold">
											Is the head of family part of an Indigenous Group? <span class="text-danger">*</span>
										</label>
										<select class="form-select" id="update_isIndigenous" name="is_indigenous" required>
											<option value="">Select...</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>

									<div id="update_indigenousGroupContainer" style="display: none;">
										<div class="mb-3">
											<label for="update_indigenousGroup" class="form-label fw-semibold">
												Indigenous Group <span class="text-danger">*</span>
											</label>
											<input type="text" class="form-control" id="update_indigenousGroup" name="indigenous_group"
												placeholder="e.g., Igorot, Lumad, Mangyan" required>
											<small class="text-muted">Please specify the indigenous group</small>
										</div>
									</div>

									<hr class="my-4">

									<div class="mb-4">
										<label class="form-label fw-semibold">
											Is the family head a beneficiary of any program? <span class="text-danger">*</span>
										</label>
										<select class="form-select" id="update_isBeneficiary" name="is_beneficiary" required>
											<option value="">Select...</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>

									<div id="update_beneficiaryProgramsContainer" style="display: none;">
										<div class="alert alert-info">
											<i class="bi bi-info-circle me-2"></i>
											Select the programs the family head is enrolled in. You can select multiple programs.
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="mb-3">
													<label class="form-label fw-semibold">
														<i class="bi bi-check-square me-1"></i>Select Programs
													</label>
													<div class="beneficiary-list" id="update_beneficiaryList">
														<!-- Will be populated dynamically -->
													</div>
												</div>
											</div>
										</div>
									</div>

									<input type="hidden" name="program_ids" id="update_programIds" value="">
								</div>

								<!-- Step 5: Account Information -->
								<div class="step-content" data-update-step="5" style="display: none;">
									<h6 class="fw-semibold mb-3">
										<i class="bi bi-person-lock me-2"></i>Account Information
									</h6>
									<div class="alert alert-info">
										<i class="bi bi-info-circle me-2"></i>
										Update account credentials for the head of family.
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_username" class="form-label fw-semibold">
													Username <span class="text-danger">*</span>
												</label>
												<div class="input-group">
													<span class="input-group-text"><i class="bi bi-person"></i></span>
													<input type="text" class="form-control" id="update_username" name="username"
														placeholder="Enter username" required>
												</div>
												<small class="text-muted">Minimum 3 characters, alphanumeric and underscore only</small>
											</div>

											<div class="mb-3">
												<label for="update_email" class="form-label fw-semibold">
													Email Address <span class="text-muted">(Optional)</span>
												</label>
												<div class="input-group">
													<span class="input-group-text"><i class="bi bi-envelope"></i></span>
													<input type="email" class="form-control" id="update_email" name="email"
														placeholder="Enter email address (optional)">
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="mb-3">
												<label for="update_password" class="form-label fw-semibold">
													New Password <span class="text-muted">(Leave blank to keep current)</span>
												</label>
												<div class="input-group">
													<span class="input-group-text"><i class="bi bi-key"></i></span>
													<input type="password" class="form-control" id="update_password" name="password"
														placeholder="Enter new password">
													<button type="button" class="btn btn-outline-secondary toggle-password-update"
														data-target="update_password">
														<i class="bi bi-eye"></i>
													</button>
												</div>
												<small class="text-muted">Minimum 6 characters. Leave blank to keep current password.</small>
											</div>

											<div class="mb-3">
												<label for="update_confirmPassword" class="form-label fw-semibold">
													Confirm New Password
												</label>
												<div class="input-group">
													<span class="input-group-text"><i class="bi bi-check-circle"></i></span>
													<input type="password" class="form-control" id="update_confirmPassword"
														name="confirm_password" placeholder="Confirm new password">
													<button type="button" class="btn btn-outline-secondary toggle-password-update"
														data-target="update_confirmPassword">
														<i class="bi bi-eye"></i>
													</button>
												</div>
											</div>

											<div class="mb-3">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" id="update_showPasswords"
														name="show_passwords">
													<label class="form-check-label" for="update_showPasswords">
														Show passwords
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" id="update_prevStepBtn" style="display: none;">
						<i class="bi bi-arrow-left me-1"></i> Previous
					</button>
					<button type="button" class="btn btn-primary" id="update_nextStepBtn">
						Next <i class="bi bi-arrow-right ms-1"></i>
					</button>
					<button type="submit" class="btn btn-success" id="update_submitBtn" style="display: none;">
						<i class="bi bi-check-circle me-1"></i> Update Family
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Delete Family Modal -->
<div class="modal fade" id="deleteFamilyModal" tabindex="-1" aria-labelledby="deleteFamilyModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteFamilyModalLabel">
					<i class="bi bi-trash3 me-2"></i>Delete Family
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" style="padding: 30px 30px 20px 30px;">
				<div class="alert alert-warning">
					<i class="bi bi-info-circle me-2"></i>
					<strong>Warning:</strong> This action cannot be undone. All related data including members, accounts, and
					beneficiary records will be permanently deleted.
				</div>

				<div class="card">
					<div class="card-body">
						<h6 class="card-title fw-semibold mb-3">
							<i class="bi bi-info-circle me-2"></i>Family Information
						</h6>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Family Code</label>
									<input type="text" class="form-control" id="delete_familyCode" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Family Name</label>
									<input type="text" class="form-control" id="delete_familyName" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Head of Family</label>
									<input type="text" class="form-control" id="delete_headName" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Status</label>
									<input type="text" class="form-control" id="delete_status" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Household Number</label>
									<input type="text" class="form-control" id="delete_householdNumber" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label fw-semibold text-muted">Registration Status</label>
									<input type="text" class="form-control" id="delete_registrationStatus" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="mt-4">
					<label class="fw-semibold">
						Type the <strong>Family Code</strong> to confirm deletion:
					</label>
					<div class="input-group mt-2">
						<span class="input-group-text"><i class="bi bi-key"></i></span>
						<input type="text" class="form-control" id="delete_confirmInput" placeholder="Enter family code here"
							autocomplete="off">
					</div>
					<small class="text-muted mt-1 d-block">
						Family code: <strong id="delete_confirmCodeDisplay">-</strong>
					</small>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-circle me-1"></i> Cancel
				</button>
				<button type="button" class="btn btn-danger" id="delete_confirmBtn" disabled>
					<i class="bi bi-trash3 me-1"></i> Delete Family
				</button>
			</div>
		</div>
	</div>
</div>

<style>
	/* Vertical Steps Styles - Improved */
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
		display: none;
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

	.step-item.completed+.step-connector {
		background: #198754;
	}

	/* Divider between steps and content */
	.step-divider {
		height: 100%;
		width: 1px;
		background: #dee2e6;
		margin: 0 auto;
	}

	/* Step Content Wrapper */
	.step-content-wrapper {
		padding: 30px 30px 20px 30px;
	}

	/* Step Content Styles */
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

	/* Password toggle button */
	.toggle-password {
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}

	/* Read-only field style */
	#familyCode {
		background-color: #e9ecef;
		cursor: not-allowed;
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

<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
	$(document).ready(function () {
		// ============================================
		// CREATE FAMILY MODAL
		// ============================================
		let currentStep = 1;
		const totalSteps = 5;
		let selectedPrograms = [];

		// Load families
		loadFamilies();

		// Load beneficiary programs
		loadBeneficiaryPrograms();

		// Auto-generate family code
		function generateFamilyCode() {
			const timestamp = Date.now().toString(36).toUpperCase();
			const random = Math.random().toString(36).substring(2, 6).toUpperCase();
			return `FAM-${timestamp.slice(-4)}${random}`;
		}

		// Set initial family code
		$('#familyCode').val(generateFamilyCode());

		// Handle search
		$('#searchFamily').on('keyup', function () {
			const searchTerm = $(this).val().toLowerCase();
			filterFamilies(searchTerm);
		});

		// Toggle indigenous group field
		$('#isIndigenous').on('change', function () {
			if ($(this).val() === '1') {
				$('#indigenousGroupContainer').slideDown();
				$('#indigenousGroup').prop('required', true);
			} else {
				$('#indigenousGroupContainer').slideUp();
				$('#indigenousGroup').prop('required', false).val('');
			}
		});

		// Toggle beneficiary programs visibility
		$('#isBeneficiary').on('change', function () {
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
				success: function (response) {
					if (response.success) {
						renderBeneficiaryPrograms(response.programs);
					}
				},
				error: function () {
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

			programs.forEach(function (program) {
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

			container.find('.form-check-input').on('change', function () {
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

		// Combine address fields before submission
		function combineAddress() {
			const barangay = $('#barangay').val();
			const municipality = $('#municipality').val();
			const province = $('#province').val();
			const houseNo = $('#houseNo').val();
			const fullAddress = `${houseNo}, ${barangay}, ${municipality}, ${province}`;
			$('#fullAddress').val(fullAddress);
		}

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

		$('#showPasswords').on('change', function () {
			const show = $(this).is(':checked');
			$('#password, #confirmPassword').each(function () {
				$(this).attr('type', show ? 'text' : 'password');
			});
			$('.toggle-password i').each(function () {
				$(this).toggleClass('bi-eye bi-eye-slash');
			});
		});

		// Validate password match
		$('#confirmPassword').on('input', function () {
			const password = $('#password').val();
			const confirm = $(this).val();
			if (password && confirm && password !== confirm) {
				$(this).addClass('is-invalid').removeClass('is-valid');
			} else if (password && confirm && password === confirm) {
				$(this).removeClass('is-invalid').addClass('is-valid');
			} else {
				$(this).removeClass('is-invalid is-valid');
			}
		});

		// Navigation functions
		function updateStepUI() {
			$('.step-item[data-step]').each(function () {
				const stepNum = parseInt($(this).data('step'));
				$(this).removeClass('active completed');
				if (stepNum === currentStep) {
					$(this).addClass('active');
				} else if (stepNum < currentStep) {
					$(this).addClass('completed');
				}
			});

			$('.step-content[data-step]').each(function () {
				const stepNum = parseInt($(this).data('step'));
				$(this).toggle(stepNum === currentStep);
			});

			$('#prevStepBtn').toggle(currentStep > 1);
			$('#nextStepBtn').toggle(currentStep < totalSteps);
			$('#submitBtn').toggle(currentStep === totalSteps);
		}

		function validateStep(step) {
			const content = $(`.step-content[data-step="${step}"]`);
			const inputs = content.find('input[required], select[required], textarea[required]');
			let isValid = true;

			inputs.each(function () {
				if (!this.checkValidity()) {
					$(this).addClass('is-invalid');
					isValid = false;
				} else {
					$(this).removeClass('is-invalid');
				}
			});

			if (step === 4) {
				const isBeneficiary = $('#isBeneficiary').val();
				if (isBeneficiary === '1' && selectedPrograms.length === 0) {
					$('#beneficiaryList').addClass('is-invalid');
					isValid = false;
				} else {
					$('#beneficiaryList').removeClass('is-invalid');
				}
			}

			if (step === 5) {
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

			return isValid;
		}

		$('#nextStepBtn').on('click', function () {
			if (currentStep === 2) {
				combineAddress();
			}

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

		$('#prevStepBtn').on('click', function () {
			if (currentStep > 1) {
				currentStep--;
				updateStepUI();
			}
		});

		$('.step-item[data-step]').on('click', function () {
			const stepNum = parseInt($(this).data('step'));
			if (stepNum <= currentStep) {
				currentStep = stepNum;
				updateStepUI();
			}
		});

		// Form submission
		$('#createFamilyForm').on('submit', function (e) {
			e.preventDefault();
			combineAddress();

			let allValid = true;
			let firstErrorStep = 1;

			for (let step = 1; step <= totalSteps; step++) {
				if (!validateStep(step)) {
					allValid = false;
					if (firstErrorStep === 1) firstErrorStep = step;
				}
			}

			if (!allValid) {
				currentStep = firstErrorStep;
				updateStepUI();
				const firstInvalid = $(`.step-content[data-step="${firstErrorStep}"]`).find('.is-invalid').first();
				if (firstInvalid.length) firstInvalid.focus();
				return;
			}

			const submitBtn = $('#submitBtn');
			submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Registering...');

			const formData = $(this).serialize();

			$.ajax({
				url: 'api/family_create.php',
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
							$('#createFamilyModal').modal('hide');
							loadFamilies();
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
			$('.is-invalid').removeClass('is-invalid');
			$('.is-valid').removeClass('is-valid');
			$('#familyCode').val(generateFamilyCode());
			$('#password, #confirmPassword').attr('type', 'password');
			$('.toggle-password i').removeClass('bi-eye-slash').addClass('bi-eye');
			$('#showPasswords').prop('checked', false);
			selectedPrograms = [];
			$('#beneficiaryList .form-check-input').prop('checked', false);
			$('#beneficiaryList .beneficiary-item').removeClass('selected');
			$('#beneficiaryList').removeClass('is-invalid');
			updateProgramIds();
			$('#indigenousGroupContainer').hide();
			$('#indigenousGroup').prop('required', false);
			$('#beneficiaryProgramsContainer').hide();
			$('#isBeneficiary').val('');
			$('#isIndigenous').val('');
			currentStep = 1;
			updateStepUI();
		});

		// ============================================
		// VIEW MODAL SECTION NAVIGATION
		// ============================================
		$('.step-item[data-section]').on('click', function () {
			const sectionNum = parseInt($(this).data('section'));

			// Update active state
			$('.step-item[data-section]').removeClass('active');
			$(this).addClass('active');

			// Show corresponding content
			$('.step-content[data-section]').hide();
			$(`.step-content[data-section="${sectionNum}"]`).show();
		});

		// Initialize
		updateStepUI();
	});

	// ============================================
	// FAMILY LIST FUNCTIONS
	// ============================================

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
								<td colspan="6" class="text-center text-muted">
										<i class="bi bi-inbox me-2"></i>No families registered yet
								</td>
						</tr>
				`);
			return;
		}

		families.forEach((family, index) => {
			const statusBadge = getStatusBadge(family.status);
			const row = `
						<tr>
								<td>${index + 1}</td>
								<td><span class="badge bg-secondary">${family.family_code}</span></td>
								<td><strong>${family.family_name}</strong></td>
								<td>${family.head_name}</td>
								<td>${statusBadge}</td>
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
	}

	function filterFamilies(searchTerm) {
		$('.table tbody tr').each(function () {
			const text = $(this).text().toLowerCase();
			$(this).toggle(text.indexOf(searchTerm) > -1);
		});
	}

	// ============================================
	// VIEW FAMILY FUNCTIONS
	// ============================================

	function viewFamily(id) {
		console.log('Viewing family with ID:', id);

		Swal.fire({
			title: 'Loading...',
			text: 'Please wait while we fetch the family details.',
			allowOutsideClick: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'api/family_view.php?id=' + id,
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				console.log('API Response:', response);
				Swal.close();

				if (response.success && response.data) {
					populateViewModal(response.data);
					$('#viewFamilyModal').modal('show');
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message || 'Failed to load family details.',
						confirmButtonText: 'OK'
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error:', {
					status: status,
					error: error,
					response: xhr.responseText
				});
				Swal.close();

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Failed to load family details. Please try again.',
					confirmButtonText: 'OK'
				});
			}
		});
	}

	function populateViewModal(data) {
		console.log('Populating view modal with data:', data);

		if (!data) {
			console.error('No data provided to populateViewModal');
			return;
		}

		// SECTION 1: FAMILY INFORMATION
		$('#view_familyCode').text(data.family_code || '-');
		$('#view_familyName').text(data.family_name || '-');
		$('#view_householdNumber').text(data.household_number || '-');
		$('#view_householdType').text(formatHouseholdType(data.household_type));
		$('#view_housingOwnership').text(formatHousingOwnership(data.housing_ownership));
		$('#view_contactNumber').text(data.contact_number || '-');
		$('#view_status').html(getStatusBadge(data.status));
		$('#view_registrationStatus').html(getRegistrationBadge(data.registration_status));

		// SECTION 2: ADDRESS
		$('#view_address').text(data.address || '-');
		$('#view_barangay').text(data.barangay || '-');
		$('#view_municipality').text(data.municipality || '-');
		$('#view_province').text(data.province || '-');
		$('#view_houseNo').text(data.house_no || '-');

		// SECTION 3: HEAD DETAILS
		$('#view_firstName').text(data.first_name || '-');
		$('#view_middleName').text(data.middle_name || '-');
		$('#view_lastName').text(data.last_name || '-');
		$('#view_suffix').text(data.suffix || '-');
		$('#view_sex').text(formatSex(data.sex));
		$('#view_dateOfBirth').text(formatDate(data.date_of_birth));
		$('#view_placeOfBirth').text(data.place_of_birth || '-');
		$('#view_civilStatus').text(formatCivilStatus(data.civil_status));
		$('#view_nationality').text(data.nationality || '-');
		$('#view_religion').text(data.religion || '-');
		$('#view_occupation').text(data.occupation || '-');
		$('#view_educationalAttainment').text(data.educational_attainment || '-');
		$('#view_relationshipToHead').text(formatRelationship(data.relationship_to_head));
		$('#view_isVoter').text(data.is_voter ? 'Yes' : 'No');

		// SECTION 4: BENEFICIARY
		$('#view_isBeneficiary').text(data.is_beneficiary ? 'Yes' : 'No');

		if (data.is_beneficiary && data.programs && data.programs.length > 0) {
			let programsHtml = '';
			data.programs.forEach(function (program) {
				programsHtml += `
								<div class="selected-program-item" style="padding: 6px 10px; margin-bottom: 4px; background: #f8f9fa; border-radius: 4px; border-left: 3px solid #198754;">
										<i class="bi bi-check-circle-fill text-success me-1"></i>
										<strong>${program.name}</strong>
										<small class="text-muted d-block ms-4">${program.description || ''}</small>
								</div>
						`;
			});
			$('#view_programsList').html(programsHtml);
		} else {
			$('#view_programsList').html('<p class="text-muted mb-0">No programs enrolled</p>');
		}

		// Indigenous
		$('#view_isIndigenous').text(data.is_indigenous ? 'Yes' : 'No');
		if (data.is_indigenous) {
			$('#view_indigenousGroup').text(data.indigenous_group || '-');
			$('#view_indigenousGroupContainer').show();
		} else {
			$('#view_indigenousGroupContainer').hide();
		}

		// SECTION 5: ACCOUNT
		$('#view_username').text(data.username || '-');
		$('#view_email').text(data.email || '-');
		$('#view_role').text(data.role_name || '-');
		$('#view_accountStatus').html(getAccountStatusBadge(data.account_status));

		// Store family ID for edit button
		$('#viewFamilyModal').data('family-id', data.id);

		console.log('View modal populated successfully');
	}

	function editFamilyFromView() {
		const familyId = $('#viewFamilyModal').data('family-id');
		$('#viewFamilyModal').modal('hide');
		editFamily(familyId);
	}

	// ============================================
	// HELPER FUNCTIONS
	// ============================================

	function formatHouseholdType(type) {
		const types = {
			'nuclear': 'Nuclear',
			'extended': 'Extended',
			'single_parent': 'Single Parent',
			'childless': 'Childless'
		};
		return types[type] || type || '-';
	}

	function formatHousingOwnership(type) {
		const types = {
			'owned': 'Owned',
			'rented': 'Rented',
			'shared': 'Shared',
			'government': 'Government',
			'informal_settler': 'Informal Settler'
		};
		return types[type] || type || '-';
	}

	function formatSex(sex) {
		if (!sex) return '-';
		return sex.charAt(0).toUpperCase() + sex.slice(1);
	}

	function formatDate(date) {
		if (!date || date === '-') return '-';
		try {
			const d = new Date(date);
			return d.toLocaleDateString('en-US', {
				year: 'numeric',
				month: 'long',
				day: 'numeric'
			});
		} catch (e) {
			return date;
		}
	}

	function formatCivilStatus(status) {
		const statuses = {
			'single': 'Single',
			'married': 'Married',
			'widowed': 'Widowed',
			'separated': 'Separated',
			'divorced': 'Divorced'
		};
		return statuses[status] || status || '-';
	}

	function formatRelationship(rel) {
		const relationships = {
			'head': 'Head',
			'spouse': 'Spouse',
			'child': 'Child'
		};
		return relationships[rel] || rel || '-';
	}

	function getStatusBadge(status) {
		const badges = {
			'active': '<span class="badge bg-success">Active</span>',
			'inactive': '<span class="badge bg-secondary">Inactive</span>'
		};
		return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
	}

	function getRegistrationBadge(status) {
		const badges = {
			'pending': '<span class="badge bg-warning">Pending</span>',
			'approved': '<span class="badge bg-success">Approved</span>',
			'rejected': '<span class="badge bg-danger">Rejected</span>'
		};
		return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
	}

	function getAccountStatusBadge(status) {
		if (status === 'Active') {
			return '<span class="badge bg-success">Active</span>';
		} else if (status === 'Deleted') {
			return '<span class="badge bg-danger">Deleted</span>';
		}
		return '<span class="badge bg-secondary">Unknown</span>';
	}

	function showError(message) {
		console.error(message);
	}

	// ============================================
	// UPDATE FAMILY FUNCTIONS
	// ============================================
	function editFamily(id) {
		console.log('Edit family with ID:', id);

		Swal.fire({
			title: 'Loading...',
			text: 'Please wait while we fetch the family details.',
			allowOutsideClick: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'api/family_view.php?id=' + id,
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				console.log('API Response:', response);
				Swal.close();

				if (response.success && response.data) {
					populateUpdateModal(response.data);
					$('#updateFamilyModal').modal('show');
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message || 'Failed to load family details.',
						confirmButtonText: 'OK'
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error:', {
					status: status,
					error: error,
					response: xhr.responseText
				});
				Swal.close();

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Failed to load family details. Please try again.',
					confirmButtonText: 'OK'
				});
			}
		});
	}

	function populateUpdateModal(data) {
		console.log('Populating update modal with data:', data);

		if (!data) {
			console.error('No data provided to populateUpdateModal');
			return;
		}

		// Set family ID
		$('#update_familyId').val(data.id);

		// ============================================
		// SECTION 1: FAMILY INFORMATION
		// ============================================
		$('#update_familyCode').val(data.family_code || '');
		$('#update_familyName').val(data.family_name || '');
		$('#update_householdNumber').val(data.household_number || '');
		$('#update_householdType').val(data.household_type || '');
		$('#update_housingOwnership').val(data.housing_ownership || '');
		$('#update_contactNumber').val(data.contact_number || '');
		$('#update_status').val(data.status || 'active');
		$('#update_registrationStatus').val(data.registration_status || 'pending');

		// ============================================
		// SECTION 2: ADDRESS
		// ============================================
		$('#update_barangay').val(data.barangay || '');
		$('#update_municipality').val(data.municipality || '');
		$('#update_province').val(data.province || '');
		$('#update_houseNo').val(data.house_no || '');

		// ============================================
		// SECTION 3: HEAD DETAILS
		// ============================================
		$('#update_firstName').val(data.first_name || '');
		$('#update_middleName').val(data.middle_name || '');
		$('#update_lastName').val(data.last_name || '');
		$('#update_suffix').val(data.suffix || '');
		$('#update_sex').val(data.sex || '');
		$('#update_dateOfBirth').val(data.date_of_birth || '');
		$('#update_placeOfBirth').val(data.place_of_birth || '');
		$('#update_civilStatus').val(data.civil_status || '');
		$('#update_nationality').val(data.nationality || '');
		$('#update_religion').val(data.religion || '');
		$('#update_occupation').val(data.occupation || '');
		$('#update_educationalAttainment').val(data.educational_attainment || '');
		$('#update_relationshipToHead').val(data.relationship_to_head || 'head');
		$('#update_isVoter').val(data.is_voter ? '1' : '0');

		// ============================================
		// SECTION 4: BENEFICIARY
		// ============================================
		$('#update_isIndigenous').val(data.is_indigenous ? '1' : '0');
		if (data.is_indigenous) {
			$('#update_indigenousGroup').val(data.indigenous_group || '');
			$('#update_indigenousGroupContainer').show();
		} else {
			$('#update_indigenousGroupContainer').hide();
		}

		$('#update_isBeneficiary').val(data.is_beneficiary ? '1' : '0');
		if (data.is_beneficiary && data.programs && data.programs.length > 0) {
			$('#update_beneficiaryProgramsContainer').show();
			// Load and select programs
			loadUpdateBeneficiaryPrograms(data.programs);
		} else {
			$('#update_beneficiaryProgramsContainer').hide();
		}

		// ============================================
		// SECTION 5: ACCOUNT
		// ============================================
		$('#update_username').val(data.username || '');
		$('#update_email').val(data.email || '');
		$('#update_password').val('');
		$('#update_confirmPassword').val('');

		// Store family ID for reference
		$('#updateFamilyModal').data('family-id', data.id);

		// Reset update step to 1
		updateCurrentStep = 1;
		updateStepUI();

		console.log('Update modal populated successfully');
	}

	// ============================================
	// UPDATE MODAL NAVIGATION
	// ============================================

	let updateCurrentStep = 1;
	const updateTotalSteps = 5;
	let updateSelectedPrograms = [];

	function loadUpdateBeneficiaryPrograms(selectedPrograms) {
		$.ajax({
			url: 'api/beneficiary_programs_list.php',
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					renderUpdateBeneficiaryPrograms(response.programs, selectedPrograms);
				}
			},
			error: function () {
				console.error('Failed to load beneficiary programs');
			}
		});
	}

	function renderUpdateBeneficiaryPrograms(programs, selectedPrograms) {
		const container = $('#update_beneficiaryList');
		container.empty();

		if (programs.length === 0) {
			container.html('<p class="text-muted text-center">No programs available</p>');
			return;
		}

		// Store selected program IDs for checking
		const selectedIds = selectedPrograms.map(p => p.id);

		programs.forEach(function (program) {
			const isChecked = selectedIds.includes(program.id) ? 'checked' : '';
			const isSelected = selectedIds.includes(program.id) ? 'selected' : '';

			const item = `
						<div class="beneficiary-item ${isSelected}" data-id="${program.id}">
								<div class="form-check">
										<input class="form-check-input" type="checkbox" id="update_program_${program.id}" 
												value="${program.id}" ${isChecked}>
										<label class="form-check-label" for="update_program_${program.id}">
												${program.name}
										</label>
										<span class="program-desc">${program.description || ''}</span>
								</div>
						</div>
				`;
			container.append(item);
		});

		// Initialize selected programs
		updateSelectedPrograms = selectedPrograms.map(p => ({ id: p.id, name: p.name }));

		// Add event listeners
		container.find('.form-check-input').on('change', function () {
			const id = parseInt($(this).val());
			const name = $(this).closest('.beneficiary-item').find('.form-check-label').text().trim();

			if ($(this).is(':checked')) {
				if (!updateSelectedPrograms.find(p => p.id === id)) {
					updateSelectedPrograms.push({ id, name });
				}
				$(this).closest('.beneficiary-item').addClass('selected');
			} else {
				updateSelectedPrograms = updateSelectedPrograms.filter(p => p.id !== id);
				$(this).closest('.beneficiary-item').removeClass('selected');
			}
			updateUpdateProgramIds();
		});

		// Show/hide beneficiary programs based on selection
		updateUpdateProgramIds();
	}

	function updateUpdateProgramIds() {
		const ids = updateSelectedPrograms.map(p => p.id).join(',');
		$('#update_programIds').val(ids);
	}

	function updateStepUI() {
		// Update step indicators
		$('.step-item[data-update-step]').each(function () {
			const stepNum = parseInt($(this).data('update-step'));
			$(this).removeClass('active completed');
			if (stepNum === updateCurrentStep) {
				$(this).addClass('active');
			} else if (stepNum < updateCurrentStep) {
				$(this).addClass('completed');
			}
		});

		// Update step lines
		$('.step-item[data-update-step] + .step-connector').each(function (index) {
			const stepNum = index + 1;
			$(this).removeClass('completed');
			if (stepNum < updateCurrentStep) {
				$(this).addClass('completed');
			}
		});

		// Show/hide step content
		$('.step-content[data-update-step]').each(function () {
			const stepNum = parseInt($(this).data('update-step'));
			if (stepNum === updateCurrentStep) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});

		// Update buttons
		$('#update_prevStepBtn').toggle(updateCurrentStep > 1);
		$('#update_nextStepBtn').toggle(updateCurrentStep < updateTotalSteps);
		$('#update_submitBtn').toggle(updateCurrentStep === updateTotalSteps);
	}

	function validateUpdateStep(step) {
		const content = $(`.step-content[data-update-step="${step}"]`);
		const inputs = content.find('input[required], select[required], textarea[required]');
		let isValid = true;

		inputs.each(function () {
			if (!this.checkValidity()) {
				$(this).addClass('is-invalid');
				isValid = false;
			} else {
				$(this).removeClass('is-invalid');
			}
		});

		// Special validation for step 4 - if beneficiary is Yes, must select at least one program
		if (step === 4) {
			const isBeneficiary = $('#update_isBeneficiary').val();
			if (isBeneficiary === '1' && updateSelectedPrograms.length === 0) {
				$('#update_beneficiaryList').addClass('is-invalid');
				isValid = false;
			} else {
				$('#update_beneficiaryList').removeClass('is-invalid');
			}
		}

		// Special validation for step 5 - password confirmation
		if (step === 5) {
			const password = $('#update_password').val();
			const confirm = $('#update_confirmPassword').val();
			if (password && confirm && password !== confirm) {
				$('#update_confirmPassword').addClass('is-invalid');
				isValid = false;
			} else {
				$('#update_confirmPassword').removeClass('is-invalid');
			}
			if (password && password.length < 6) {
				$('#update_password').addClass('is-invalid');
				isValid = false;
			} else {
				$('#update_password').removeClass('is-invalid');
			}
		}

		return isValid;
	}

	function combineUpdateAddress() {
		const barangay = $('#update_barangay').val();
		const municipality = $('#update_municipality').val();
		const province = $('#update_province').val();
		const houseNo = $('#update_houseNo').val();
		const fullAddress = `${houseNo}, ${barangay}, ${municipality}, ${province}`;
		$('#update_fullAddress').val(fullAddress);
	}

	// ============================================
	// UPDATE MODAL EVENT BINDINGS
	// ============================================

	$(document).ready(function () {
		// Toggle indigenous group field for update
		$('#update_isIndigenous').on('change', function () {
			if ($(this).val() === '1') {
				$('#update_indigenousGroupContainer').slideDown();
				$('#update_indigenousGroup').prop('required', true);
			} else {
				$('#update_indigenousGroupContainer').slideUp();
				$('#update_indigenousGroup').prop('required', false).val('');
			}
		});

		// Toggle beneficiary programs visibility for update
		$('#update_isBeneficiary').on('change', function () {
			if ($(this).val() === '1') {
				$('#update_beneficiaryProgramsContainer').slideDown();
				// Load programs if not loaded yet
				if ($('#update_beneficiaryList').children().length === 0) {
					loadUpdateBeneficiaryPrograms([]);
				}
			} else {
				$('#update_beneficiaryProgramsContainer').slideUp();
				updateSelectedPrograms = [];
				$('#update_beneficiaryList .form-check-input').prop('checked', false);
				$('#update_beneficiaryList .beneficiary-item').removeClass('selected');
				updateUpdateProgramIds();
			}
		});

		// Toggle password visibility for update
		$('.toggle-password-update').on('click', function () {
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

		// Show/hide all passwords for update
		$('#update_showPasswords').on('change', function () {
			const show = $(this).is(':checked');
			$('#update_password, #update_confirmPassword').each(function () {
				$(this).attr('type', show ? 'text' : 'password');
			});
			$('.toggle-password-update i').each(function () {
				$(this).toggleClass('bi-eye bi-eye-slash');
			});
		});

		// Validate password match for update
		$('#update_confirmPassword').on('input', function () {
			const password = $('#update_password').val();
			const confirm = $(this).val();
			if (password && confirm && password !== confirm) {
				$(this).addClass('is-invalid').removeClass('is-valid');
			} else if (password && confirm && password === confirm) {
				$(this).removeClass('is-invalid').addClass('is-valid');
			} else if (!password && !confirm) {
				$(this).removeClass('is-invalid is-valid');
			}
		});

		// Next step for update
		$('#update_nextStepBtn').on('click', function () {
			if (updateCurrentStep === 2) {
				combineUpdateAddress();
			}

			if (!validateUpdateStep(updateCurrentStep)) {
				const firstInvalid = $(`.step-content[data-update-step="${updateCurrentStep}"]`).find('.is-invalid').first();
				if (firstInvalid.length) firstInvalid.focus();
				return;
			}
			if (updateCurrentStep < updateTotalSteps) {
				updateCurrentStep++;
				updateStepUI();
			}
		});

		// Previous step for update
		$('#update_prevStepBtn').on('click', function () {
			if (updateCurrentStep > 1) {
				updateCurrentStep--;
				updateStepUI();
			}
		});

		// Step click navigation for update
		$('.step-item[data-update-step]').on('click', function () {
			const stepNum = parseInt($(this).data('update-step'));
			if (stepNum <= updateCurrentStep) {
				updateCurrentStep = stepNum;
				updateStepUI();
			}
		});

		// Form submission for update
		$('#updateFamilyForm').on('submit', function (e) {
			e.preventDefault();
			combineUpdateAddress();

			let allValid = true;
			let firstErrorStep = 1;

			for (let step = 1; step <= updateTotalSteps; step++) {
				if (!validateUpdateStep(step)) {
					allValid = false;
					if (firstErrorStep === 1) firstErrorStep = step;
				}
			}

			if (!allValid) {
				updateCurrentStep = firstErrorStep;
				updateStepUI();
				const firstInvalid = $(`.step-content[data-update-step="${firstErrorStep}"]`).find('.is-invalid').first();
				if (firstInvalid.length) firstInvalid.focus();
				return;
			}

			const submitBtn = $('#update_submitBtn');
			submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Updating...');

			const formData = $(this).serialize();

			$.ajax({
				url: 'api/family_update.php',
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
							$('#updateFamilyModal').modal('hide');
							loadFamilies();
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Update Failed',
							text: response.message,
							confirmButtonText: 'OK'
						});
						submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Update Family');
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
					submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Update Family');
				}
			});
		});

		// Reset form when modal is closed
		$('#updateFamilyModal').on('hidden.bs.modal', function () {
			$('#updateFamilyForm')[0].reset();
			$('.is-invalid').removeClass('is-invalid');
			$('.is-valid').removeClass('is-valid');
			$('#update_password, #update_confirmPassword').attr('type', 'password');
			$('.toggle-password-update i').removeClass('bi-eye-slash').addClass('bi-eye');
			$('#update_showPasswords').prop('checked', false);
			updateSelectedPrograms = [];
			$('#update_beneficiaryList .form-check-input').prop('checked', false);
			$('#update_beneficiaryList .beneficiary-item').removeClass('selected');
			$('#update_beneficiaryList').removeClass('is-invalid');
			updateUpdateProgramIds();
			$('#update_indigenousGroupContainer').hide();
			$('#update_indigenousGroup').prop('required', false);
			$('#update_beneficiaryProgramsContainer').hide();
			$('#update_isBeneficiary').val('');
			$('#update_isIndigenous').val('');
			updateCurrentStep = 1;
			updateStepUI();
		});

		// Initialize update step UI
		updateStepUI();
	});

	// ============================================
	// DELETE FAMILY FUNCTIONS
	// ============================================

	function deleteFamily(id) {
		console.log('Delete family with ID:', id);

		// Show loading
		Swal.fire({
			title: 'Loading...',
			text: 'Please wait while we fetch the family details.',
			allowOutsideClick: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'api/family_view.php?id=' + id,
			method: 'GET',
			dataType: 'json',
			success: function (response) {
				console.log('API Response:', response);
				Swal.close();

				if (response.success && response.data) {
					const data = response.data;

					// Populate delete modal with readonly inputs
					$('#delete_familyCode').val(data.family_code || '-');
					$('#delete_familyName').val(data.family_name || '-');
					$('#delete_headName').val(
						(data.first_name || '') + ' ' + (data.last_name || '')
					);
					$('#delete_status').val(formatStatus(data.status));
					$('#delete_householdNumber').val(data.household_number || '-');
					$('#delete_registrationStatus').val(formatRegistrationStatus(data.registration_status));

					// Store family code for confirmation display
					$('#delete_confirmCodeDisplay').text(data.family_code || '-');

					// Store family ID
					$('#deleteFamilyModal').data('family-id', id);
					$('#deleteFamilyModal').data('family-code', data.family_code);

					// Reset confirmation input
					$('#delete_confirmInput').val('');
					$('#delete_confirmBtn').prop('disabled', true);

					// Show modal
					$('#deleteFamilyModal').modal('show');
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message || 'Failed to load family details.',
						confirmButtonText: 'OK'
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error:', {
					status: status,
					error: error,
					response: xhr.responseText
				});
				Swal.close();

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Failed to load family details. Please try again.',
					confirmButtonText: 'OK'
				});
			}
		});
	}

	// Helper functions for formatting
	function formatStatus(status) {
		const statuses = {
			'active': 'Active',
			'inactive': 'Inactive'
		};
		return statuses[status] || status || '-';
	}

	function formatRegistrationStatus(status) {
		const statuses = {
			'pending': 'Pending',
			'approved': 'Approved',
			'rejected': 'Rejected'
		};
		return statuses[status] || status || '-';
	}

	// ============================================
	// DELETE MODAL EVENT BINDINGS
	// ============================================

	$(document).ready(function () {
		// Enable/disable delete button based on confirmation input
		$('#delete_confirmInput').on('input', function () {
			const inputValue = $(this).val();
			const familyCode = $('#deleteFamilyModal').data('family-code');

			if (inputValue === familyCode) {
				$('#delete_confirmBtn').prop('disabled', false);
			} else {
				$('#delete_confirmBtn').prop('disabled', true);
			}
		});

		// Handle Enter key on confirmation input
		$('#delete_confirmInput').on('keypress', function (e) {
			if (e.key === 'Enter') {
				const inputValue = $(this).val();
				const familyCode = $('#deleteFamilyModal').data('family-code');

				if (inputValue === familyCode) {
					$('#delete_confirmBtn').click();
				}
			}
		});

		// Delete button click handler
		$('#delete_confirmBtn').on('click', function () {
			const familyId = $('#deleteFamilyModal').data('family-id');
			const familyCode = $('#deleteFamilyModal').data('family-code');

			if (!familyId) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Family ID not found.',
					confirmButtonText: 'OK'
				});
				return;
			}

			// Close the modal
			$('#deleteFamilyModal').modal('hide');

			// Show confirmation dialog
			Swal.fire({
				icon: 'warning',
				title: 'Delete Family?',
				html: `
								You are about to delete <strong>${familyCode}</strong>. 
								This action cannot be undone!
						`,
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					// Show loading
					Swal.fire({
						title: 'Deleting...',
						text: 'Please wait while we delete the family.',
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading();
						}
					});

					// Call delete API
					$.ajax({
						url: 'api/family_delete.php',
						method: 'POST',
						data: { family_id: familyId },
						dataType: 'json',
						success: function (response) {
							Swal.close();

							if (response.success) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									confirmButtonText: 'OK'
								}).then(() => {
									// Reload the family list
									loadFamilies();
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: response.message || 'Failed to delete family.',
									confirmButtonText: 'OK'
								});
							}
						},
						error: function (xhr, status, error) {
							console.error('AJAX Error:', {
								status: status,
								error: error,
								response: xhr.responseText
							});
							Swal.close();

							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Failed to delete family. Please try again.',
								confirmButtonText: 'OK'
							});
						}
					});
				}
			});
		});

		// Reset delete modal when closed
		$('#deleteFamilyModal').on('hidden.bs.modal', function () {
			$('#delete_confirmInput').val('');
			$('#delete_confirmBtn').prop('disabled', true);
			$('#deleteFamilyModal').data('family-id', null);
			$('#deleteFamilyModal').data('family-code', null);
		});
	});
</script>