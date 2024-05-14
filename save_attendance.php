<?php
// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted data
    $student_name = sanitizeData($_POST["student_name"]);
    $status = sanitizeData($_POST["status"]);

    // Open the Excel file
    $excel_file = 'attendance.xlsx';
    $excel_data = [];

    // Check if the file exists
    if (file_exists($excel_file)) {
        // Read the existing data from the Excel file
        $excel_data = array_map('str_getcsv', file($excel_file));
    }

    // Append the new data to the array
    $excel_data[] = array($student_name, $status);

    // Open the Excel file for writing
    $file = fopen($excel_file, 'w');

    // Write the data to the Excel file
    foreach ($excel_data as $row) {
        fputcsv($file, $row);
    }

    // Close the file
    fclose($file);

    echo "Attendance saved successfully!";
} else {
    // If the form is not submitted, redirect to the index page
    header("Location: index.php");
    exit();
}
?>
