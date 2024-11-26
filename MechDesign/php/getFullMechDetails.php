<?php

require_once("../config/config.php");
include("../php/DB_Conn.php");

$mechID = filter_input(INPUT_GET, 'mechIDPassed', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;

// List of tables to query
$tables = ['mechs', 'mecharm', 'mechengine', 'mechexternalarmor', 'mechhead', 'mechinternals', 'mechleg', 'mechtorso', 'mechtorsocenter'];

$selectColumns = [];

// Fetch column names for each table
foreach ($tables as $table) {
    // Query to get columns for the table
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tablesToUse = [$table];
        if ($table === 'mecharm') {
            $tablesToUse = ['mecharmLeft', 'mecharmRight'];
        }
        if ($table === 'mechleg') {
            $tablesToUse = ['mechlegLeft', 'mechlegRight'];
        }
        if ($table === 'mechtorso') {
            $tablesToUse = ['mechtorsoLeft', 'mechtorsoRight'];
        }
        while ($row = $result->fetch_assoc()) {
            foreach($tablesToUse as $tableToUse) {
                $selectColumns[] = $tableToUse . '.' . $row['COLUMN_NAME'] . ' as ' . $tableToUse . '_' . $row['COLUMN_NAME'];
            }
        }
    }
}

// Build the full SELECT string
$selectString = rtrim(implode(', ', $selectColumns), ', ');

// Full SQL query
$queryAllMechSql = "
    SELECT
        $selectString
    FROM
        mechs
    LEFT JOIN mecharm mecharmLeft ON mechs.mechID = mecharmLeft.mechID AND mecharmLeft.partLeftorRight = 0
    LEFT JOIN mecharm mecharmRight ON mechs.mechID = mecharmRight.mechID AND mecharmRight.partLeftorRight = 1
    LEFT JOIN mechengine on mechs.mechID = mechengine.mechID
    LEFT JOIN mechexternalarmor on mechs.mechID = mechexternalarmor.mechID
    LEFT JOIN mechhead on mechs.mechID = mechhead.mechID
    LEFT JOIN mechinternals on mechs.mechID = mechinternals.mechID
    LEFT JOIN mechleg mechlegLeft ON mechs.mechID = mechlegLeft.mechID AND mechlegLeft.partLeftorRight = 0
    LEFT JOIN mechleg mechlegRight ON mechs.mechID = mechlegRight.mechID AND mechlegRight.partLeftorRight = 1
    LEFT JOIN mechtorso mechtorsoLeft ON mechs.mechID = mechtorsoLeft.mechID AND mechtorsoLeft.partLeftorRight = 0
    LEFT JOIN mechtorso mechtorsoRight ON mechs.mechID = mechtorsoRight.mechID AND mechtorsoRight.partLeftorRight = 1
    LEFT JOIN mechtorsocenter on mechs.mechID = mechtorsocenter.mechID
    WHERE
        mechs.mechID = ?
";

// echo json_encode([$queryAllMechSql]); exit(0);

// Prepare the statement
$stmt = $conn->prepare($queryAllMechSql);
if (!$stmt) {
    die("Prepared statement failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('i', $mechID);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the data and structure it
$data = [];
$currentPrefix = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = $row;
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return the result as JSON
echo json_encode($data);

?>
