<?php
include 'config.php';
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];

$query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ssi", $name, $email, $id);

if ($stmt->execute()) {
    echo "User updated successfully.";
    header('Location: admin_users.php'); 
} else {
    echo "Error updating user: " . $con->error;
}
?>
