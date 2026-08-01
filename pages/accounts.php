<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Accounts</h5>
		<button class="btn btn-primary btn-sm">
			<i class="bi bi-plus-circle me-1"></i> Create Account
		</button>
	</div>
	<div class="card-body">
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
								"memberid" => 1,
								"username" => "Username1",
								"roleid" => "1",
								"is_deleted" => "0"
							],
							[
								"memberid" => 2,
								"username" => "Username1",
								"roleid" => "2",
								"is_deleted" => "0"
							],
							[
								"memberid" => 3,
								"username" => "Username1",
								"roleid" => "3",
								"is_deleted" => "1"
							],
						];

						$userbaseSize = count($userbase);

						$increment = 0;

						if ($userbaseSize > 0) {
							while ($increment < $userbaseSize) {
								echo '<tr>';
								echo '<td>' . $userbase[$increment]["memberid"] . '</td>';
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