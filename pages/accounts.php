<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Accounts</h5>
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

		<!-- Table -->
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
				<tbody id="accounts_data">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- View Account Modal -->
<div class="modal fade" id="viewAccountModal" tabindex="-1" aria-labelledby="viewAccountModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewAccountModalLabel">
					<i class="bi bi-eye-fill me-2"></i>View Account
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 mb-3">
						<label for="viewAccountUsername" class="form-label fw-semibold">
							Account Username
						</label>
						<input type="text" class="form-control" id="viewAccountUsername" name="view_account_username" placeholder="Account username"
							readonly>
						<div class="invalid-feedback">Please enter a username.</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="viewAccountRole" class="form-label fw-semibold">
							Account Role
						</label>
						<input type="text" class="form-control" id="viewAccountRole" name="view_account_role" placeholder="Account Role"
							readonly>
					</div>

					<div class="col-md-6 mb-3">
						<label for="viewAccountRole" class="form-label fw-semibold">
							Account Member
						</label>
						<input type="text" class="form-control" id="viewAccountMember" name="view_account_member" placeholder="Account Member"
							readonly>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="viewAccountEmail" class="form-label fw-semibold">
							Email Address
						</label>
						<input type="email" class="form-control" id="viewAccountEmail" name="view_account_email" placeholder="username@example.com" readonly>
					</div>
					<div class="col-md-6 mb-3">
						<label for="status" class="form-label fw-semibold">
							Status
						</label>
						<input type="text" class="form-control" id="viewAccountStatus" name="view_account_status" placeholder="Account Status"
							readonly>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Exit</button>
			</div>
		</div>
	</div>
</div>

<!-- Update Account Modal -->
<div class="modal fade" id="updateAccountModal" tabindex="-1" aria-labelledby="updateAccountModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="updateAccountModalLabel">
					<i class="bi bi-pencil-fill me-2"></i>Update Account
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="updateAccountForm" method="POST" action="api/account_update.php">
				<div class="modal-body">
					<!-- Account Information -->
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="updateAccountUsername" class="form-label fw-semibold">
								Account Username <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="updateAccountUsername" name="update_account_username" placeholder="Enter account username"
								required>
							<div class="invalid-feedback">Please enter a username.</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="updateAccountRole" class="form-label fw-semibold">
								Account Role <span class="text-danger">*</span>
							</label>
							<select class="form-select" id="updateAccountRole" name="update_account_role_id" required>
								<option value="">Select role...</option>
							</select>
						</div>

						<div class="col-md-6 mb-3">
							<label for="updateAccountMember" class="form-label fw-semibold">
								Account Member
							</label>
							<select class="form-select" id="updateAccountMember" name="update_account_member_id">
								<option value="">Select member...</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 md-3">
							<label for="updateAccountEmail" class="form-label fw-semibold">
								Email Address <span class="text-danger">*</span>
							</label>
							<input type="email" class="form-control" id="updateAccountEmail" name="update_account_email" placeholder="username@example.com" required>
						</div>
					</div>

					<div class="col-md-6 mb-3">
						<label for="update_account_status" class="form-label fw-semibold">
							Status <span class="text-danger">*</span>
						</label>
						<select class="form-select" id="updateAccountStatus" name="update_account_status" required>
							<option value="">Select status...</option>
							<option value='0'>Active</option>
							<option value='1'>Inactive</option>
						</select>
						<div class="invalid-feedback">Please select a status</div>
					</div>
				</div>

				<input type="hidden" id="updateAccountID" name="update_account_id">

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" id="updateAccountSubmitButton" class="btn btn-primary">
						<i class="bi bi-check-circle me-1"></i> Update Account
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordAccountModal" tabindex="-1" aria-labelledby="changePasswordAccountModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="changePasswordAccountModalLabel">
					<i class="bi bi-person-fill-gear me-2"></i>Change Password
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="changePasswordAccountForm" method="POST" action="api/account_changePassword.php">
				<div class="modal-body">
					<!-- Account Information -->
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="changePasswordAccountUsername" class="form-label fw-semibold">
								Account Username <span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="changePasswordAccountUsername" name="change_password_account_username" placeholder="Enter account username"
								readonly>
							<div class="invalid-feedback">Please enter a username.</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="changePasswordAccountPassword" class="form-label fw-semibold">
								New Password <span class="text-danger">*</span>
							</label>
							<input type="password" class="form-control" id="changePasswordAccountPassword" name="change_password_account_password" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="changePasswordAccountPassword" class="form-label fw-semibold">
								Confirm Password <span class="text-danger">*</span>
							</label>
							<input type="password" class="form-control" id="changePasswordAccountPasswordConfirm" name="change_password_account_confirm_password" required>
						</div>
					</div>

					<input type="hidden" id="changePasswordAccountID" name="change_password_account_id">

					<div class="row">
						<p id="changePasswordWarning" class="text-danger"></p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="changePasswordSubmitButton">
							<i class="bi bi-pencil me-1"></i> Change Password
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteAccountModalLabel">
					<i class="bi bi-trash-fill me-2"></i>Delete Account
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="deleteAccountForm" method="POST" action="api/account_delete.php">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="deleteAccountUsername" class="form-label fw-semibold">
								Account Username
							</label>
							<input type="text" class="form-control" id="deleteAccountUsername" name="delete_account_username" placeholder="Account username"
								readonly>
							<div class="invalid-feedback">Please enter a username.</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="deleteAccountRole" class="form-label fw-semibold">
								Account Role
							</label>
							<input type="text" class="form-control" id="deleteAccountRole" name="delete_account_role" placeholder="Account Role"
								readonly>
						</div>

						<div class="col-md-6 mb-3">
							<label for="deleteAccountRole" class="form-label fw-semibold">
								Account Member
							</label>
							<input type="text" class="form-control" id="deleteAccountMember" name="delete_account_member" placeholder="Account Member"
								readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="deleteAccountEmail" class="form-label fw-semibold">
								Email Address
							</label>
							<input type="email" class="form-control" id="deleteAccountEmail" name="delete_account_email" placeholder="username@example.com" readonly>
						</div>
						<div class="col-md-6 mb-3">
							<label for="status" class="form-label fw-semibold">
								Status
							</label>
							<input type="text" class="form-control" id="deleteAccountStatus" name="delete_account_status" placeholder="Account Status"
								readonly>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">
						<i class="bi bi-trash me-1"></i> Delete Account
					</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
	// On load 
	$(document).ready(function() {
		loadAccounts();
	});
	// populate table
	function loadAccounts() {
		$.ajax({
			url: 'api/accounts_select_all.php',
			method: 'GET',
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					renderAccounts(response.accounts);
				} else {
					showError('Failed to load accounts: ' + response.message);
				}
			},
			error: function() {
				showError('Failed to load accounts. Please try again.');
			}
		});
	}

	function renderAccounts(accounts) {
		const accountDataTable = $('#accounts_data');
		accountDataTable.empty();

		if (accounts.length === 0) {
			accountDataTable.html(`
				<tr>
					<td colspan="6" class="text-center text-muted">
						<i class="bi bi-inbox me-2"></i>No accounts added yet
					</td>
				</tr>
				`);
			return;
		}

		accounts.forEach((account) => {
			var text = "";

			text += "<tr>";
			text += `<td>${account.id}</td>`
			text += `<td>${account.username}</td>`
			if (account.role_id == 1) {
				text += `<td><span class="badge bg-success">${account.role_name}</span></td>`;
			} else if (account.role_id == 2) {
				text += `<td><span class="badge bg-primary">${account.role_name}</span></td>`;
			} else if (account.role_id == 3) {
				text += `<td><span class="badge bg-info">${account.role_name}</span></td>`;
			} else if (account.role_id == 4) {
				text += `<td><span class="badge bg-secondary">${account.role_name}</span></td>`;
			} else {
				text += `<td><span class="badge bg-dark">${account.role_name}</span></td>`;
			}

			if (account.is_deleted == 0) {
				text += '<td><span class="badge bg-success">Active</span></td>';
			} else {
				{
					text += '<td><span class="badge bg-secondary">Inactive</span></td>';
				}
			}

			text += `<td>
								<button class="btn btn-sm btn-outline-primary" title="View" data-bs-toggle="modal" data-bs-target="#viewAccountModal" 
								onclick="viewPopulateForm('${account.username}', '${account.role_name}', '${account.member_id}', '${account.member_full_name}', '${account.email}', '${account.is_deleted}')">
									<i class="bi bi-eye" ></i>
								</button>
								<button class="btn btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#updateAccountModal"
								onclick="updatePopulateForm('${account.id}','${account.username}', '${account.id}', '${account.member_id}', '${account.member_full_name}', '${account.email}', '${account.is_deleted}')">
									<i class="bi bi-pencil"></i>
								</button>
								<button class="btn btn-sm btn-outline-success" title="Password" data-bs-toggle="modal" data-bs-target="#changePasswordAccountModal"
								onclick="changePasswordPopulateForm('${account.id}','${account.username}')">
									<i class="bi bi-person-gear"></i>
								</button>
								<button class="btn btn-sm btn-outline-danger" title="Remove" data-bs-toggle="modal" data-bs-target="#deleteAccountModal"
								onclick="deletePopulateForm('${account.id}', '${account.username}', '${account.role_name}', '${account.member_full_name}', '${account.email}', '${account.is_deleted}')">
									<i class="bi bi-trash"></i>
								</button>
							</td>`
			text += "</tr>";

			accountDataTable.append(text);
		});
	}

	//Populate Role Dropdown Table
	fetch('api/accounts_fetch_roles.php')
		.then(res => res.json())
		.then(roles => {
			const options = $.map(roles, function(role) {
				return $('<option>', {
					value: role.id,
					text: role.name
				});
			});

			$('#updateAccountRole').append(options);
		})

	//Populate Members Dropdown Table
	fetch('api/accounts_fetch_members.php')
		.then(res => res.json())
		.then(members => {
			const options = $.map(members, function(member) {
				return $('<option>', {
					value: member.id,
					text: member.full_name
				});
			});

			$('#updateAccountMember').append(options);
		})


	//View Account Stuff
	function viewPopulateForm(accountUsername, accountRole, accountMemberFullName, accountMemberName, accountEmail, accountIsDeleted) {
		$('#viewAccountUsername').val(accountUsername);
		$('#viewAccountRole').val(accountRole);
		if (accountMemberFullName == 'null') {
			$('#viewAccountMember').val('Not Available');
		} else {
			$('#viewAccountMember').val(accountMemberFullName);
		}

		$('#viewAccountEmail').val(accountEmail);

		if (accountIsDeleted == 0) {
			$('#viewAccountStatus').val('Active');
		} else {
			$('#viewAccountStatus').val('Inactive');
		}
	}

	//Update Account Stuff
	function updatePopulateForm(accountID, accountUsername, accountRole, accountMemberID, accountMemberName, accountEmail, accountIsDeleted) {
		$('#updateAccountUsername').val(accountUsername);
		$('#updateAccountRole').val(accountRole);
		$('#updateAccountMember').val(accountMemberID);
		$('#updateAccountEmail').val(accountEmail);
		$('#updateAccountStatus').val(accountIsDeleted);
		$('#updateAccountID').val(accountID);
	}

	$('#updateAccountForm').on('submit', function(event) {
		event.preventDefault();

		const updateAccountFormData = new FormData(this);
		const updateAccountFormProps = Object.fromEntries(updateAccountFormData);

		const updateAccountSubmitButton = $('#updateAccountSubmitButton');
		updateAccountSubmitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Updating...');

		const formData = $(this).serialize();

		updateAccount(formData);
	});

	function updateAccount(formData) {
		$.ajax({
			url: 'api/account_update.php',
			method: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						text: response.message,
						confirmButtonText: 'OK'
					}).then(() => {
						$('#updateAccountModal').modal('hide');
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Update Failed',
						text: response.message,
						confirmButtonText: 'OK'
					});
					updateAccountSubmitButton.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Update Account');
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
				updateAccountSubmitButton.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Update Account');
			}
		});
	}

	//Change Password Stuff
	function changePasswordPopulateForm(accountID, accountUsername) {
		$('#changePasswordAccountUsername').val(accountUsername);
		$('#changePasswordAccountID').val(accountID);
	}

	$('#changePasswordAccountForm').on('submit', function(event) {
		event.preventDefault();

		const changePasswordFormData = new FormData(this);
		const changePasswordFormProps = Object.fromEntries(changePasswordFormData);

		const changePasswordSubmitButton = $('#changePasswordSubmitButton');
		changePasswordSubmitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Updating...');

		const formData = $(this).serialize();

		if (changePasswordFormProps.change_password_account_password === changePasswordFormProps.change_password_account_confirm_password) {
			if (changePasswordFormProps.change_password_account_password.length < 8) {
				$('#changePasswordWarning').text("New password must have at least 8 characters.");
			} else {
				changePassword(formData)
			}
			changePasswordSubmitButton.prop('disabled', false).html('<i class="bi bi-pencil me-1"></i> Change Password');
		} else {
			$('#changePasswordWarning').text("Passwords do not match.");
			changePasswordSubmitButton.prop('disabled', false).html('<i class="bi bi-pencil me-1"></i> Change Password');
		}
	});

	function changePassword(formData) {
		$.ajax({
			url: 'api/account_update_password.php',
			method: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						text: response.message,
						confirmButtonText: 'OK'
					}).then(() => {
						$('#changePasswordAccountModal').modal('hide');
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Update Failed',
						text: response.message,
						confirmButtonText: 'OK'
					});
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
			}
		});
	}

	//Delete Account Stuff
	function deletePopulateForm(accountID, accountUsername, accountRole, accountMemberFullName, accountEmail, accountIsDeleted) {
		$('#deleteAccountUsername').val(accountUsername);
		$('#deleteAccountRole').val(accountRole);
		if (accountMemberFullName == 'null') {
			$('#deleteAccountMember').val('Not Available');
		} else {
			$('#deleteAccountMember').val(accountMemberFullName);
		}

		$('#deleteAccountEmail').val(accountEmail);

		if (accountIsDeleted == 0) {
			$('#deleteAccountStatus').val('Active');
		} else {
			$('#deleteAccountStatus').val('Inactive');
		}

		$('#deleteAccountID').val(accountID);
	}
</script>