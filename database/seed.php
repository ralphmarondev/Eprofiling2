<?php
require_once "../config/database.php";

// ============================================
// Optional: Clear existing data (CAUTION!)
// ============================================
// Uncomment these lines if you want to reset everything
// $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
// $mysqli->query("TRUNCATE TABLE accounts");
// $mysqli->query("TRUNCATE TABLE members");
// $mysqli->query("TRUNCATE TABLE family");
// $mysqli->query("TRUNCATE TABLE relationship");
// $mysqli->query("TRUNCATE TABLE role");
// $mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
// echo "⚠️  Existing data cleared!\n";

// ============================================
// Helper function to check if table is empty
// ============================================
function isTableEmpty($mysqli, $table)
{
	$result = $mysqli->query("SELECT COUNT(*) as count FROM $table");
	$row = $result->fetch_assoc();
	return $row['count'] == 0;
}

// ============================================
// STEP 1: Seed Roles (only if empty)
// ============================================
if (isTableEmpty($mysqli, 'role')) {
	$roles = [
		['name' => 'Administrator'],
		['name' => 'Staff'],
		['name' => 'FamilyAdmin'],
		['name' => 'User']
	];

	$stmt = $mysqli->prepare("INSERT INTO role (name) VALUES (?)");

	foreach ($roles as $role) {
		$stmt->bind_param("s", $role['name']);

		if (!$stmt->execute()) {
			die("Failed to seed role: " . $stmt->error);
		}
	}

	$stmt->close();
	echo "✅ Roles seeded successfully!\n";
} else {
	echo "⏭️  Roles already exist, skipping...\n";
}

// ============================================
// STEP 2: Seed Accounts (only if empty)
// ============================================
if (isTableEmpty($mysqli, 'accounts')) {
	$accounts = [
		[
			"username" => "admin",
			"email" => "admin@gmail.com",
			"password" => "adminnimda",
			"member_id" => null,
			"role_id" => 1 // Administrator
		],
		[
			"username" => "staff",
			"email" => "staff@gmail.com",
			"password" => "staff123",
			"member_id" => null,
			"role_id" => 2 // Staff
		]
	];

	$stmt = $mysqli->prepare("
        INSERT INTO accounts (
            username,
            email,
            password,
            member_id,
            role_id
        ) VALUES (?, ?, ?, ?, ?)
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
	echo "✅ Accounts seeded successfully!\n";
} else {
	echo "⏭️  Accounts already exist, skipping...\n";
}

$mysqli->close();

echo "\n🎉 Database seeded successfully!\n";
?>