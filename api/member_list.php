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

try {
	$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

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
        WHERE 1=1
    ";

	$params = [];
	$types = "";

	if (!empty($searchTerm)) {
		$sql .= " AND (m.first_name LIKE ? OR m.last_name LIKE ? OR f.family_code LIKE ?)";
		$searchPattern = "%{$searchTerm}%";
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$types .= "sss";
	}

	$sql .= " ORDER BY m.last_name ASC, m.first_name ASC";

	$stmt = $mysqli->prepare($sql);

	if (!empty($params)) {
		$stmt->bind_param($types, ...$params);
	}

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

		$members[] = $row;
	}

	$stmt->close();

	echo json_encode([
		"success" => true,
		"members" => $members,
		"total" => count($members)
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