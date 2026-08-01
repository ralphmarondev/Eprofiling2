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
						<td><span class="badge bg-secondary">FAM-REYES</span></td>
						<td><strong>Reyes Family</strong></td>
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
						<td><span class="badge bg-secondary">FAM-GARCIA</span></td>
						<td><strong>Garcia Family</strong></td>
						<td><span class="badge bg-success">Active</span></td>
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
					<div class="row">
						<!-- Left Column -->
						<div class="col-md-6">
							<!-- Family Code -->
							<div class="mb-3">
								<label for="familyCode" class="form-label fw-semibold">
									Family Code <span class="text-danger">*</span>
								</label>
								<div class="input-group">
									<input type="text" class="form-control" id="familyCode" name="family_code"
										placeholder="FAM-FAMILYNAME" required>
									<button type="button" class="btn btn-outline-secondary" id="regenerateCodeBtn" title="Generate Code">
										<i class="bi bi-arrow-clockwise"></i>
									</button>
								</div>
								<small class="text-muted">Auto-generated from family name</small>
								<div class="invalid-feedback">Please enter a family code</div>
							</div>

							<!-- Family Name -->
							<div class="mb-3">
								<label for="familyName" class="form-label fw-semibold">
									Family Name <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control" id="familyName" name="name" placeholder="Enter family name"
									required>
								<div class="invalid-feedback">Please enter a family name</div>
							</div>

							<!-- Landline (Optional) -->
							<div class="mb-3">
								<label for="landline" class="form-label fw-semibold">
									Landline Number <span class="text-muted">(Optional)</span>
								</label>
								<input type="tel" class="form-control" id="landline" name="landline" placeholder="e.g., (02) 8123-4567">
							</div>
						</div>

						<!-- Right Column -->
						<div class="col-md-6">
							<!-- Address -->
							<div class="mb-3">
								<label for="address" class="form-label fw-semibold">
									Address <span class="text-danger">*</span>
								</label>
								<textarea class="form-control" id="address" name="address" rows="6" placeholder="Enter complete address"
									required></textarea>
								<div class="invalid-feedback">Please enter an address</div>
							</div>
						</div>
					</div>
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

<script>
	$(document).ready(function () {
		// Function to generate family code from family name
		function generateFamilyCodeFromName(name) {
			if (!name || name.trim() === '') {
				return 'FAM-';
			}
			// Remove "Family" suffix if present, uppercase, remove spaces
			let cleanName = name.replace(/\s*Family\s*/i, '').trim();
			// Remove special characters, keep letters and numbers
			cleanName = cleanName.replace(/[^a-zA-Z0-9]/g, '');
			// Convert to uppercase
			cleanName = cleanName.toUpperCase();

			// If empty after cleaning, use a default
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

		// Regenerate code on button click (based on current family name)
		$('#regenerateCodeBtn').on('click', function () {
			const familyName = $('#familyName').val();
			if (familyName && familyName.trim() !== '') {
				const code = generateFamilyCodeFromName(familyName);
				$('#familyCode').val(code);

				// Add visual feedback
				const icon = $(this).find('i');
				icon.addClass('bi-arrow-clockwise').css('animation', 'spin 0.5s linear');
				setTimeout(() => {
					icon.css('animation', '');
				}, 500);
			} else {
				alert('Please enter a family name first.');
			}
		});

		// Form validation
		$('#createFamilyForm').on('submit', function (e) {
			// Ensure family code is uppercase
			const code = $('#familyCode').val();
			$('#familyCode').val(code.toUpperCase());

			if (this.checkValidity() === false) {
				e.preventDefault();
				e.stopPropagation();
				$(this).addClass('was-validated');
			} else {
				// Form is valid - let it submit normally
				console.log('Form is valid, submitting...');
				// Remove this line to actually submit
				// e.preventDefault();
			}
		});

		// Reset form when modal is closed
		$('#createFamilyModal').on('hidden.bs.modal', function () {
			$('#createFamilyForm')[0].reset();
			$('#createFamilyForm').removeClass('was-validated');
			$('#familyCode').val('');
		});
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