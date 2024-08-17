<?php
include 'config.php';
$id = $_GET['id'];
$query = "DELETE FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "User deleted successfully.";
} else {
    echo "Error deleting user: " . $con->error;
}
header('Location: admin_users.php'); 
?>
