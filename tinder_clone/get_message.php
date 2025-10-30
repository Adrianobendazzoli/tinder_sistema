<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['user_id'];
$other_id = intval($_GET['user']);

// Buscar mensagens entre os dois
$result = $conn->query("
    SELECT * FROM messages 
    WHERE (sender_id = $user_id AND receiver_id = $other_id) 
       OR (sender_id = $other_id AND receiver_id = $user_id)
    ORDER BY created_at ASC
");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?>
