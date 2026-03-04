<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Optional: Fetch filename first to delete the actual file from server
    $sql = "DELETE FROM movies WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?success=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>