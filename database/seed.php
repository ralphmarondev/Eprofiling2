<?php
require_once "../config/database.php";
// ============================================
// Optional: Clear existing data (CAUTION!)
// ============================================
// Uncomment if you want to reset everything.

$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
$mysqli->query("TRUNCATE TABLE accounts");
$mysqli->query("TRUNCATE TABLE members");
$mysqli->query("TRUNCATE TABLE families");
$mysqli->query("TRUNCATE TABLE roles");
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
echo "⚠️ Existing data cleared!\n";
// ============================================
// Helper Function
// ============================================
function isTableEmpty($mysqli, $table)
{
	$result = $mysqli->query("SELECT COUNT(*) AS total FROM {$table}");
	$row = $result->fetch_assoc();

	return $row["total"] == 0;
}
// ============================================
// Seed Roles
// ============================================
if (isTableEmpty($mysqli, "roles")) {
	$roles = [
		"administrator",
		"staff",
		"family_admin",
		"resident"
	];

	$stmt = $mysqli->prepare("
        INSERT INTO roles (name)
        VALUES (?)
    ");

	foreach ($roles as $role) {
		$stmt->bind_param("s", $role);
		if (!$stmt->execute()) {
			die("Failed to seed roles: " . $stmt->error);
		}
	}
	$stmt->close();
	echo "✅ Roles seeded successfully.\n";
} else {
	echo "⏭️ Roles already exist.\n";
}

// ============================================
// Seed Administrator & Staff Accounts
// ============================================
// NOTE:
// This assumes accounts.member_id is NULLABLE.
// If it is NOT NULL, these inserts will fail.
// ============================================

if (isTableEmpty($mysqli, "accounts")) {
	$accounts = [
		[
			"username" => "admin",
			"email" => "admin@gmail.com",
			"password" => "adminnimda",
			"role_id" => 1
		],
		[
			"username" => "staff",
			"email" => "staff@gmail.com",
			"password" => "staff123",
			"role_id" => 2
		]
	];

	$stmt = $mysqli->prepare("
        INSERT INTO accounts
        (
            role_id,
            member_id,
            username,
            email,
            password_hash
        )
        VALUES
        (
            ?, ?, ?, ?, ?
        )
    ");

	foreach ($accounts as $account) {
		$memberId = null;
		$passwordHash = password_hash(
			$account["password"],
			PASSWORD_DEFAULT
		);
		$stmt->bind_param(
			"iisss",
			$account["role_id"],
			$memberId,
			$account["username"],
			$account["email"],
			$passwordHash
		);
		if (!$stmt->execute()) {
			die("Failed to seed account: " . $stmt->error);
		}
	}
	$stmt->close();
	echo "✅ Accounts seeded successfully.\n";
} else {
	echo "⏭️ Accounts already exist.\n";
}

$mysqli->close();

echo "\n🎉 Database seeded successfully!\n";