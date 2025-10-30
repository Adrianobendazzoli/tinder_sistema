<?php
include 'db.php';
session_start();

$liker = $_SESSION['user_id'];
$liked = $_POST['liked'];

$conn->query("INSERT INTO likes (liker_id, liked_id) VALUES ($liker, $liked)");

$check = $conn->query("SELECT * FROM likes WHERE liker_id=$liked AND liked_id=$liker");
if ($check->num_rows > 0) {
  echo "match";
} else {
  echo "ok";
}
?>
