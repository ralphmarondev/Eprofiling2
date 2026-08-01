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
	// Get family filter if provided
	$familyFilter = isset($_GET['family_id']) ? intval($_GET['family_id']) : null;
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
            m.is_head,
            m.relationship_to_head,
            m.created_at,
            f.id AS family_id,
            f.family_code,
            f.name AS family_name,
            f.address,
            (
                SELECT CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name)
                FROM members 
                WHERE family_id = f.id AND is_head = 1 
                LIMIT 1
            ) AS head_name
        FROM members m
        INNER JOIN families f ON m.family_id = f.id
        WHERE m.id IS NOT NULL
    ";

	$conditions = [];
	$params = [];
	$types = "";

	if ($familyFilter) {
		$conditions[] = "f.id = ?";
		$params[] = $familyFilter;
		$types .= "i";
	}

	if (!empty($searchTerm)) {
		$conditions[] = "(m.first_name LIKE ? OR m.last_name LIKE ? OR f.family_code LIKE ?)";
		$searchPattern = "%{$searchTerm}%";
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$params[] = $searchPattern;
		$types .= "sss";
	}

	if (!empty($conditions)) {
		$sql .= " AND " . implode(" AND ", $conditions);
	}

	$sql .= " ORDER BY f.name ASC, m.is_head DESC, m.first_name ASC";

	$stmt = $mysqli->prepare($sql);

	if (!empty($params)) {
		$stmt->bind_param($types, ...$params);
	}

	$stmt->execute();
	$result = $stmt->get_result();

	$members = [];
	while ($row = $result->fetch_assoc()) {
		// Format member name
		$row['full_name'] = trim(
			$row['first_name'] . ' ' .
			($row['middle_name'] ? $row['middle_name'] . ' ' : '') .
			$row['last_name'] .
			($row['suffix'] ? ' ' . $row['suffix'] : '')
		);

		// Format role badge
		if ($row['is_head']) {
			$row['role_display'] = 'Head';
			$row['role_badge'] = 'primary';
		} else {
			$row['role_display'] = ucfirst($row['relationship_to_head']);
			$row['role_badge'] = $row['relationship_to_head'] === 'spouse' ? 'info' : 'secondary';
		}

		// Format date
		$row['age'] = calculateAge($row['date_of_birth']);
		$row['created_at_formatted'] = date('M d, Y', strtotime($row['created_at']));

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