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

// Get family ID from request (changed from family_code)
$family_id = isset($_GET['family_id']) ? intval($_GET['family_id']) : 0;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Validate family ID
if ($family_id === 0) {
	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => "Family ID is required."
	]);
	exit;
}

try {
	// First, verify the family exists
	$family_sql = "SELECT id, family_code, name FROM families WHERE id = ?";
	$stmt = $mysqli->prepare($family_sql);
	$stmt->bind_param("i", $family_id);
	$stmt->execute();
	$family_result = $stmt->get_result();
	$family = $family_result->fetch_assoc();
	$stmt->close();

	if (!$family) {
		http_response_code(404);
		echo json_encode([
			"success" => false,
			"message" => "Family not found with ID: " . $family_id
		]);
		exit;
	}

	// Build the members query - only for this specific family
	$sql = "
        SELECT 
            m.id,
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
            m.is_head,
            m.relationship_to_head,
            m.is_voter,
            m.is_indigenous,
            m.indigenous_group,
            m.create_date,
            f.id AS family_id,
            f.family_code,
            f.name AS family_name,
            f.contact_number AS family_contact,
            f.status AS family_status,
            f.registration_status,
            (
                SELECT CONCAT(
                    COALESCE(first_name, ''),
                    ' ',
                    COALESCE(middle_name, ''),
                    ' ',
                    COALESCE(last_name, '')
                )
                FROM members 
                WHERE family_id = f.id AND is_head = 1 
                LIMIT 1
            ) AS head_name
        FROM members m
        INNER JOIN families f ON m.family_id = f.id
        WHERE f.id = ?
    ";

	$params = [$family_id];
	$types = "i";

	// Add search filter if provided
	if (!empty($searchTerm)) {
		$sql .= " AND (
            m.first_name LIKE ? OR 
            m.last_name LIKE ? OR 
            m.middle_name LIKE ? OR
            CONCAT(m.first_name, ' ', m.last_name) LIKE ?
        )";
		$searchPattern = "%{$searchTerm}%";
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$types .= "ssss";
	}

	// Order: Head first, then spouse, then children, then others
	$sql .= " ORDER BY 
        CASE WHEN m.is_head = 1 THEN 0 ELSE 1 END,
        CASE WHEN m.relationship_to_head = 'spouse' THEN 1 ELSE 2 END,
        m.last_name ASC, 
        m.first_name ASC";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param($types, ...$params);
	$stmt->execute();
	$result = $stmt->get_result();

	$members = [];
	while ($row = $result->fetch_assoc()) {
		// Calculate age
		$row['age'] = calculateAge($row['date_of_birth']);
		$row['created_at_formatted'] = date('M d, Y', strtotime($row['create_date']));

		// Format sex
		$row['sex_display'] = ucfirst($row['sex']);

		// Format civil status
		$civilStatusLabels = [
			'single' => 'Single',
			'married' => 'Married',
			'widowed' => 'Widowed',
			'separated' => 'Separated',
			'divorced' => 'Divorced'
		];
		$row['civil_status_display'] = $civilStatusLabels[$row['civil_status']] ?? ucfirst($row['civil_status']);

		// Format relationship
		$relationshipLabels = [
			'head' => 'Head',
			'spouse' => 'Spouse',
			'child' => 'Child'
		];
		$row['relationship_display'] = $relationshipLabels[$row['relationship_to_head']] ?? ucfirst($row['relationship_to_head']);

		// Boolean to Yes/No
		$row['is_voter_display'] = $row['is_voter'] ? 'Yes' : 'No';
		$row['is_indigenous_display'] = $row['is_indigenous'] ? 'Yes' : 'No';

		// Format role badge
		if ($row['is_head']) {
			$row['role_display'] = 'Head';
			$row['role_badge'] = 'primary';
		} else {
			$roleLabels = [
				'spouse' => 'Spouse',
				'child' => 'Child'
			];
			$row['role_display'] = $roleLabels[$row['relationship_to_head']] ?? ucfirst($row['relationship_to_head']);
			$row['role_badge'] = $row['relationship_to_head'] === 'spouse' ? 'info' : 'secondary';
		}

		// Full name for display
		$row['full_name'] = trim(
			$row['first_name'] . ' ' .
			($row['middle_name'] ? substr($row['middle_name'], 0, 1) . '. ' : '') .
			$row['last_name'] .
			($row['suffix'] ? ' ' . $row['suffix'] : '')
		);

		$members[] = $row;
	}

	$stmt->close();

	// Get member count
	$count_sql = "SELECT COUNT(*) as total FROM members WHERE family_id = ?";
	$stmt = $mysqli->prepare($count_sql);
	$stmt->bind_param("i", $family_id);
	$stmt->execute();
	$count_result = $stmt->get_result();
	$count_row = $count_result->fetch_assoc();
	$total_members = $count_row['total'];
	$stmt->close();

	echo json_encode([
		"success" => true,
		"family" => [
			"id" => $family['id'],
			"code" => $family['family_code'],
			"name" => $family['name']
		],
		"members" => $members,
		"total" => $total_members
	]);

} catch (Exception $e) {
	http_response_code(500);
	echo json_encode([
		"success" => false,
		"message" => $e->getMessage()
	]);
}

$mysqli->close();

function calculateAge($birthDate)
{
	if (!$birthDate)
		return null;
	$birth = new DateTime($birthDate);
	$today = new DateTime('today');
	$age = $today->diff($birth)->y;
	return $age;
}
?>