<?php
require_once "../config/database.php";

$accounts = [
	[
		"username" => "admin",
		"email" => "admin@gmail.com",
		"password" => "adminnimda",
		"member_id" => null,
		"role_id" => 1
	],
	[
		"username" => "staff",
		"email" => "staff@gmail.com",
		"password" => "staff123",
		"member_id" => null,
		"role_id" => 2
	]
];

$stmt = $mysqli->prepare("
	INSERT INTO accounts
	(
		username,
		email,
		password,
		member_id,
		role_id
	)
	VALUES
	(?, ?, ?, ?, ?)
");

foreach ($accounts as $account) {
	$hashedPassword = password_hash(
		$account["password"],
		PASSWORD_DEFAULT
	);

	$stmt->bind_param(
		"sssii",
		$account["username"],
		$account["email"],
		$hashedPassword,
		$account["member_id"],
		$account["role_id"]
	);

	if (!$stmt->execute()) {
		die("Failed to seed account: " . $stmt->error);
	}
}

$stmt->close();
$mysqli->close();

echo "Database seeded successfully!";
?>