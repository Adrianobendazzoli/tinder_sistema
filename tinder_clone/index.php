<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: home.php");
  } else {
    $error = "Email ou senha incorretos.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login - Tinder Clone</title>
</head>
<body class="bg-gradient-to-b from-pink-100 to-pink-200 min-h-screen flex items-center justify-center">
  <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-80">
    <h2 class="text-2xl font-bold text-pink-600 mb-4 text-center">Entrar</h2>
    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-sm text-center mb-2"><?= $error ?></p>
    <?php endif; ?>
    <input name="email" placeholder="Email" class="w-full p-2 border rounded mb-3" required>
    <input name="password" type="password" placeholder="Senha" class="w-full p-2 border rounded mb-3" required>
    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded">Entrar</button>
    <p class="text-center text-sm mt-3 text-gray-600">Não tem conta? <a href="register.php" class="text-pink-500">Cadastrar</a></p>
  </form>
</body>
</html>
