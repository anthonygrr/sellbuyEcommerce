<?php
include __DIR__ . '/../_conection.php';

header('Content-Type: application/json');

$response=new stdClass();

// --- Input sanitization (never interpolate raw user input into SQL) ---
$charge = isset($_POST['charge']) ? intval($_POST['charge']) : 0;
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
if ($page < 1) {
	$page = 1;
}
// Pagination is OPT-IN: a client must send per_page as an int > 0 to get
// LIMIT/OFFSET paging. Legacy consumers (e.g. productDetails.php) omit it and
// receive the FULL result set, exactly like the original code.
$per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 0;
$paginated = $per_page > 0;
if ($paginated && $per_page > 48) {
	$per_page = 48;
}

// --- charge -> WHERE fragment (same conditions as before, reused by COUNT + data queries) ---
$conditions = [];
$conditions[1] = "state_prod=1";
$conditions[2] = "category_prod ='bags,backpacks'";
$conditions[3] = "category_prod ='accesories'";
$conditions[4] = "category_prod ='shirt'";
$conditions[5] = "category_prod ='shoes,tenis,boots'";

$where = isset($conditions[$charge]) ? $conditions[$charge] : "";

$datos = [];
$total = 0;

// --- COUNT (skipped when no charge matched -> total stays 0, no query, no warnings) ---
if ($where !== "") {
	$countSql = "SELECT COUNT(*) AS total FROM products WHERE " . $where;
	$countResult = mysqli_query($con, $countSql);
	if ($countResult) {
		$countRow = mysqli_fetch_assoc($countResult);
		if (isset($countRow['total'])) {
			$total = intval($countRow['total']);
		}
	}
}

// --- Paginated mode: clamp page into [1, max(1, ceil(total / per_page))] AFTER the total.
// --- Legacy mode (no per_page): one full result set -> page 1, total_pages 1, no OFFSET. ---
$offset = 0;
if ($paginated) {
	$total_pages = max(1, (int)ceil($total / $per_page));
	if ($page > $total_pages) {
		$page = $total_pages;
	}
	$offset = ($page - 1) * $per_page;
} else {
	$page = 1;
	$total_pages = 1;
}

// --- Data query (ORDER BY keeps page boundaries stable; skipped when no charge matched) ---
if ($where !== "") {
	$sql = "SELECT * FROM products WHERE " . $where . " ORDER BY code_prod ASC";
	if ($paginated) {
		$sql .= " LIMIT " . $per_page . " OFFSET " . $offset;
	}
	$result = mysqli_query($con, $sql);
	if ($result) {
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$obj = new stdClass();
			$obj->code_prod = $row['code_prod'];
			$obj->name_prod = $row['name_prod'];
			$obj->description_prod = $row['description_prod'];
			$obj->price_prod = $row['price_prod'];
			$obj->image_route = $row['image_route'];

			$datos[$i] = $obj;
			$i++;
		}
	}
}

$response->datos = $datos;
$response->total = $total;
$response->page = $page;
// Legacy mode reports the row count it actually returned (0 when empty).
$response->per_page = $paginated ? $per_page : count($datos);
$response->total_pages = $total_pages;

mysqli_close($con);
echo json_encode($response);
