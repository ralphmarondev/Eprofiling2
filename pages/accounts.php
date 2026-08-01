<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Accounts</h5>
		<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createAccountModal">
			<i class="bi bi-plus-circle me-1"></i> Create Account
		</button>
	</div>
	<div class="card-body">
		<!-- Search/Filter Bar -->
		<div class="row">
			<div class="col-md-4">
				<input type="text" class="form-control" placeholder="Search accounts..." id="searchAccount">
			</div>
			<div class="col-md-4">
				<select class="form-select" id="searchAccountRole" required>
					<option value="">Search role...</option>
					<option value="1">Administrator</option>
					<option value="2">Staff</option>
					<option value="3">Family Head</option>
					<option value="4">User</option>
				</select>
			</div>
			<div class="col-md-4 text-md-end">
				<button class="btn btn-outline-secondary btn-sm">
					<i class="bi bi-funnel"></i> Filter
				</button>
				<button class="btn btn-outline-secondary btn-sm">
					<i class="bi bi-arrow-repeat"></i> Refresh
				</button>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Username</th>
						<th>Role</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$userbase = [
							[
								"id" => 1,
								"username" => "Username1",
								"roleid" => "1",
								"is_deleted" => "0",
								"member_id" => NULL
							],
							[
								"id" => 2,
								"username" => "Username1",
								"roleid" => "2",
								"is_deleted" => "0",
								"member_id" => NULL
							],
							[
								"id" => 3,
								"username" => "Username1",
								"roleid" => "3",
								"is_deleted" => "1",
								"member_id" => "2"
							],
						];

						$userbaseSize = count($userbase);

						$increment = 0;

						if ($userbaseSize > 0) {
							while ($increment < $userbaseSize) {
								echo '<tr>';
								echo '<td>' . $userbase[$increment]["id"] . '</td>';
								echo '<td>' . $userbase[$increment]["username"] . '</td>';
								if ($userbase[$increment]["roleid"] == 1) {
									echo '<td><span class="badge bg-success">Administrator</span></td>';
								} else if ($userbase[$increment]["roleid"] == 2) {
									echo '<td><span class="badge bg-primary">Staff</span></td>';
								} else if ($userbase[$increment]["roleid"] == 3) {
									echo '<td><span class="badge bg-info">Family Head</span></td>';
								} else if ($userbase[$increment]["roleid"] == 4) {
									echo '<td><span class="badge bg-secondary">User</span></td>';
								} else {
									echo '<td><span class="badge bg-dark">Not Applicable</span></td>';
								}

								if ($userbase[$increment]["is_deleted"] == 0) {
									echo '<td><span class="badge bg-success">Active</span></td>';
								} else { {
										echo '<td><span class="badge bg-secondary">Inactive</span></td>';
									}
								}

								echo
								'<td>
									<button class="btn btn-sm btn-outline-primary" title="View">
										<i class="bi bi-eye"></i>
									</button>
									<button class="btn btn-sm btn-outline-warning" title="Edit">
										<i class="bi bi-pencil"></i>
									</button>
									<button class="btn btn-sm btn-outline-danger" title="Delete">
										<i class="bi bi-trash"></i>
									</button>
								</td>';
								$increment = $increment + 1;
							}
						} else {
							echo '<td colspan="5" class="text-center text-muted">No accounts found</td>';
						}
						?>

					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createAccountModalLabel">
					<i class="bi bi-people-fill me-2"></i>Create New Account
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="createAccountForm" method="POST" action="api/account_create.php">
				<div class="modal-body">
					<!-- Account Information -->
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="createAccountUsername" class="form-label fw-semibold">
								Account Username <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="createAccountUsername" name="create_account_username" placeholder="Enter account username"
								required>
							<div class="invalid-feedback">Please enter a username.</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="createAccountRole" class="form-label fw-semibold">
								Account Role <span class="text-danger">*</span>
							</label>
							<select class="form-select" id="createAccountRole" name="status" required>
								<option value="">Select role...</option>
								<option value="1">Administrator</option>
								<option value="2">Staff</option>
								<option value="3">Family Head</option>
								<option value="4">User</option>
							</select>
						</div>

						<div class="col-md-6 mb-3">
							<label for="createAccountRole" class="form-label fw-semibold">
								Account Member
							</label>
							<select class="form-select" id="createAccountMember" name="status">
								<option value="">Select member...</option>
								<option value="1">Member1</option>
								<option value="2">Member2</option>
								<option value="3">Member3</option>
								<option value="4">Member4</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="createAccountEmail" class="form-label fw-semibold">
								Email Address <span class="text-danger">*</span>
							</label>
							<input type="email" class="form-control" id="createAccountEmail" name="create_account_email" placeholder="username@example.com" required>
						</div>

						<div class="col-md-6 mb-3">
							<label for="createAccountPassword" class="form-label fw-semibold">
								Password <span class="text-danger">*</span>
							</label>
							<input type="password" class="form-control" id="createAccountPassword" name="create_account_password" required>
						</div>
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

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-check-circle me-1"></i> Create Account
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#createAccountModal').on('hidden.bs.modal', function() {
			$('#createAccountForm')[0].reset();
			//$('#createAccountForm').removeClass('was-validated');
		});
	})
</script>