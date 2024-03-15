<?php
include 'config.php';

$sql = "CREATE TABLE quiz (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table quiz created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE answers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT(6) UNSIGNED,
    answer TEXT,
    correct TINYINT(1) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table answers created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>