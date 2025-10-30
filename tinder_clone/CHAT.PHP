<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['user'])) {
    exit("Usuário não especificado!");
}

$user_id = $_SESSION['user_id'];
$other_id = intval($_GET['user']);

// Checa se existe match
$match_check = $conn->query("
    SELECT * FROM likes l1
    JOIN likes l2 ON l1.liker_id = l2.liked_id AND l1.liked_id = l2.liker_id
    WHERE (l1.liker_id = $user_id AND l1.liked_id = $other_id)
");
if ($match_check->num_rows == 0) exit("Não há match com este usuário.");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col h-screen">

<header class="bg-pink-500 text-white p-4 text-center font-bold">Chat</header>

<div id="chat-box" class="flex-1 overflow-auto p-4 space-y-2">
    <!-- Mensagens serão carregadas aqui -->
</div>

<form id="chat-form" class="p-4 bg-white flex gap-2">
    <input type="text" id="message" class="flex-1 border rounded px-2 py-1" placeholder="Digite sua mensagem">
    <button type="submit" class="bg-pink-500 text-white px-4 rounded">Enviar</button>
</form>

<script>
const userId = <?= $user_id ?>;
const otherId = <?= $other_id ?>;

// Função para carregar mensagens
function loadMessages() {
    $.get("load_messages.php", {user: otherId}, function(data){
        $("#chat-box").html(data);
        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
    });
}

// Atualiza mensagens a cada 2 segundos
setInterval(loadMessages, 2000);
loadMessages();

// Enviar mensagem
$("#chat-form").submit(function(e){
    e.preventDefault();
    const msg = $("#message").val();
    if(msg.trim() === "") return;
    $.post("send_message.php", {receiver_id: otherId, message: msg}, function(){
        $("#message").val("");
        loadMessages();
    });
});
</script>

</body>
</html>
