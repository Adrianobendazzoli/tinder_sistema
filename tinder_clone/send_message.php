<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['user'])) exit;

$user_id = $_SESSION['user_id'];
$other_id = intval($_GET['user']);

$result = $conn->query("
    SELECT * FROM messages
    WHERE (sender_id = $user_id AND receiver_id = $other_id)
       OR (sender_id = $other_id AND receiver_id = $user_id)
    ORDER BY created_at ASC
");

while($row = $result->fetch_assoc()) {
    $class = ($row['sender_id'] == $user_id) ? "text-right" : "text-left";
    echo "<div class='$class p-2'>";
    echo "<span class='inline-block bg-white rounded shadow p-2'>{$row['message']}</span>";
    echo "</div>";
}
