<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $photo = $_POST['photo'] ?: 'https://via.placeholder.com/150';

  $stmt = $conn->prepare("INSERT INTO users (name, email, password, photo) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $pass, $photo);
  $stmt->execute();

  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Cadastro - Tinder Clone</title>
</head>
<body class="bg-gradient-to-b from-pink-100 to-pink-200 min-h-screen flex items-center justify-center">
  <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-80">
    <h2 class="text-2xl font-bold text-pink-600 mb-4 text-center">Crie sua conta</h2>
    <input name="name" placeholder="Nome" class="w-full p-2 border rounded mb-3" required>
    <input name="email" placeholder="Email" class="w-full p-2 border rounded mb-3" required>
    <input name="password" type="password" placeholder="Senha" class="w-full p-2 border rounded mb-3" required>
    <input name="photo" placeholder="URL da foto (opcional)" class="w-full p-2 border rounded mb-3">
    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded">Cadastrar</button>
    <p class="text-center text-sm mt-3 text-gray-600">Já tem conta? <a href="index.php" class="text-pink-500">Entrar</a></p>
  </form>
</body>
</html>
