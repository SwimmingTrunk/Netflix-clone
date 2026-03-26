<?php

include 'db_connection.php'; 
// includes the database connection so we can run queries

if (isset($_GET['id'])) {
    // checks if an id was passed in the URL

    $id = intval($_GET['id']);
    // gets the id from the URL and converts it to an integer for safety
    
    // Optional: Fetch filename first to delete the actual file from server

    $sql = "DELETE FROM movies WHERE ID = ?";
    // SQL query to delete a movie from the database using its ID

    $stmt = $conn->prepare($sql);
    // prepares the SQL statement to prevent SQL injection

    $stmt->bind_param("i", $id);
    // binds the id value to the query, "i" means integer

    if ($stmt->execute()) {
        // runs the query

        header("Location: admin.php?success=deleted");
        // redirects back to admin page with a success message in the URL

    } else {
        // if something goes wrong

        echo "Error deleting record: " . $conn->error;
        // shows an error message
    }
}

?>