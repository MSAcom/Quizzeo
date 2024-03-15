<!DOCTYPE html>
<html>
<head>
    <title>Quiz List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>List of Quizzes</h1>
    <?php
    include 'config.php';

    $sql = "SELECT * FROM quiz";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<h2>" . $row['title'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";

            $sql_answers = "SELECT * FROM answers WHERE quiz_id = " . $row['id'];
            $result_answers = $conn->query($sql_answers);

            if ($result_answers->num_rows > 0) {
                echo "<ul>";
                while($row_answers = $result_answers->fetch_assoc()) {
                    echo "<li>" . $row_answers['answer'];
                    if ($row_answers['correct'] == 1) {
                        echo " (Correct)";
                    }
                    echo "</li>";
                }
                echo "</ul>";
            }
        }
    } else {
        echo "No quizzes found";
    }

    $conn->close();
    ?>
</body>
</html>