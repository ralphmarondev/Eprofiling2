<?php
require_once "../config/database.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
	http_response_code(405);
	echo json_encode([
		"success" => false,
		"message" => "Method Not Allowed."
	]);
	exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => "Family ID is required."
	]);
	exit;
}

$familyId = (int) $_GET['id'];

try {
	// Get family details with head of family and account
	$sql = "
        SELECT 
            f.id,
            f.family_code,
            f.name AS family_name,
            f.household_number,
            f.household_type,
            f.housing_ownership,
            f.contact_number,
            f.address,
            f.status,
            f.registration_status,
            f.create_date,
            f.update_date,
            -- Head of Family
            m.id AS member_id,
            m.first_name,
            m.middle_name,
            m.last_name,
            m.suffix,
            m.sex,
            m.date_of_birth,
            m.place_of_birth,
            m.civil_status,
            m.nationality,
            m.religion,
            m.occupation,
            m.educational_attainment,
            m.relationship_to_head,
            m.is_voter,
            m.is_indigenous,
            m.indigenous_group,
            -- Account
            a.username,
            a.email,
            a.is_deleted AS account_deleted,
            r.name AS role_name
        FROM families f
        LEFT JOIN members m ON f.id = m.family_id AND m.is_head = 1
        LEFT JOIN accounts a ON m.id = a.member_id
        LEFT JOIN roles r ON a.role_id = r.id
        WHERE f.id = ?
    ";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $familyId);
	$stmt->execute();
	$result = $stmt->get_result();
	$family = $result->fetch_assoc();

	if (!$family) {
		http_response_code(404);
		echo json_encode([
			"success" => false,
			"message" => "Family not found."
		]);
		exit;
	}

	// Get beneficiary programs for the head of family
	$programs = [];
	if ($family['member_id']) {
		$programsSql = "
            SELECT 
                bp.id,
                bp.name,
                bp.description
            FROM member_beneficiaries mb
            JOIN beneficiary_programs bp ON mb.program_id = bp.id
            WHERE mb.member_id = ?
        ";

		$stmt = $mysqli->prepare($programsSql);
		$stmt->bind_param("i", $family['member_id']);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$programs[] = $row;
		}
	}

	// Parse address components
	$addressParts = array_map('trim', explode(',', $family['address'] ?? ''));
	$houseNo = $addressParts[0] ?? '';
	$barangay = $addressParts[1] ?? '';
	$municipality = $addressParts[2] ?? '';
	$province = $addressParts[3] ?? '';

	// Build response
	$response = [
		"success" => true,
		"data" => [
			// Family Info
			"id" => $family['id'],
			"family_code" => $family['family_code'] ?? '-',
			"family_name" => $family['family_name'] ?? '-',
			"household_number" => $family['household_number'] ?? '-',
			"household_type" => $family['household_type'] ?? '-',
			"housing_ownership" => $family['housing_ownership'] ?? '-',
			"contact_number" => $family['contact_number'] ?? '-',
			"status" => $family['status'] ?? 'inactive',
			"registration_status" => $family['registration_status'] ?? 'pending',

			// Address
			"address" => $family['address'] ?? '-',
			"house_no" => $houseNo,
			"barangay" => $barangay,
			"municipality" => $municipality,
			"province" => $province,

			// Member Details
			"member_id" => $family['member_id'],
			"first_name" => $family['first_name'] ?? '-',
			"middle_name" => $family['middle_name'] ?? '-',
			"last_name" => $family['last_name'] ?? '-',
			"suffix" => $family['suffix'] ?? '-',
			"sex" => $family['sex'] ?? '-',
			"date_of_birth" => $family['date_of_birth'] ?? '-',
			"place_of_birth" => $family['place_of_birth'] ?? '-',
			"civil_status" => $family['civil_status'] ?? '-',
			"nationality" => $family['nationality'] ?? '-',
			"religion" => $family['religion'] ?? '-',
			"occupation" => $family['occupation'] ?? '-',
			"educational_attainment" => $family['educational_attainment'] ?? '-',
			"relationship_to_head" => $family['relationship_to_head'] ?? 'head',
			"is_voter" => (bool) $family['is_voter'],
			"is_indigenous" => (bool) $family['is_indigenous'],
			"indigenous_group" => $family['indigenous_group'] ?? '-',

			// Beneficiary
			"is_beneficiary" => count($programs) > 0,
			"programs" => $programs,

			// Account
			"username" => $family['username'] ?? '-',
			"email" => $family['email'] ?? '-',
			"role_name" => $family['role_name'] ?? '-',
			"account_status" => isset($family['account_deleted']) && $family['account_deleted'] ? 'Deleted' : 'Active'
		]
	];

	echo json_encode($response);

} catch (Exception $e) {
	http_response_code(500);
	echo json_encode([
		"success" => false,
		"message" => $e->getMessage()
	]);
}

$mysqli->close();
?>