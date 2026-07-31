<div class="row g-4">
	<div class="col-md-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h6 class="text-muted">Families</h6>
				<h2>0</h2>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h6 class="text-muted">Members</h6>
				<h2>0</h2>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h6 class="text-muted">Accounts</h6>
				<h2>0</h2>
			</div>
		</div>
	</div>
</div>

<div class="card shadow-sm mt-4">
	<div class="card-header fw-semibold">
		Welcome
	</div>
	<div class="card-body">
		<p class="mb-0">
			Welcome to the Eprofiling System.
			You are logged in as
			<strong>
				<?= htmlspecialchars($_SESSION["role"]); ?>
			</strong>.
		</p>
	</div>
</div>