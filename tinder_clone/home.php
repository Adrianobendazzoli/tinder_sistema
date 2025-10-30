<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Pegar todos os matches do usuário
$matches = $conn->query("
    SELECT u.id, u.name, u.photo
    FROM users u
    JOIN likes l1 ON l1.liked_id = u.id
    JOIN likes l2 ON l2.liker_id = u.id
    WHERE l1.liker_id = $user_id AND l2.liked_id = $user_id
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tinder Clone - Matches</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/gsap@3.13.0/dist/gsap.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/lucide/dist/lucide.esm.js"></script>
</head>
<body class="bg-pink-50 min-h-screen flex flex-col">

<header class="bg-white shadow p-4 text-center font-bold text-pink-600 text-xl">
    Seus Matches
</header>

<main class="flex-1 p-4">
    <?php if ($matches->num_rows > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while($match = $matches->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-4 flex flex-col items-center">
                    <img class="w-32 h-32 object-cover rounded-full mb-3" src="<?= htmlspecialchars($match['photo']) ?>" alt="<?= htmlspecialchars($match['name']) ?>">
                    <h2 class="text-lg font-bold text-pink-600 mb-2"><?= htmlspecialchars($match['name']) ?></h2>
                    <a href="chat.php?user=<?= $match['id'] ?>"
                       class="bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded shadow-md flex items-center gap-2 chat-button">
                        <i data-lucide="message-square"></i> Chat
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500 mt-10">Você ainda não tem matches.</p>
    <?php endif; ?>
</main>

<script type="module">
import lucide from 'https://cdn.jsdelivr.net/npm/lucide/dist/lucide.esm.js';
lucide.createIcons();

// Animação GSAP para todos os botões de chat
const buttons = document.querySelectorAll('.chat-button');
buttons.forEach((btn, i) => {
    gsap.from(btn, {scale:0, duration:0.5, ease:"bounce.out", delay: i*0.1});
});
</script>

</body>
</html>
