document.addEventListener("DOMContentLoaded", () => {
  const card = document.querySelector("#card");
  const likeBtn = document.querySelector("#likeBtn");
  const dislikeBtn = document.querySelector("#dislikeBtn");

  if (card) {
    gsap.from(card, { opacity: 0, y: 100, duration: 0.8, ease: "back.out(1.7)" });

    likeBtn.addEventListener("click", () => animateCard("like"));
    dislikeBtn.addEventListener("click", () => animateCard("dislike"));
  }

  function animateCard(action) {
    const direction = action === "like" ? 300 : -300;
    const rotation = action === "like" ? 15 : -15;

    gsap.to(card, {
      x: direction,
      rotation: rotation,
      opacity: 0,
      duration: 0.6,
      ease: "power2.in",
      onComplete: () => {
        if (action === "like") sendLike();
        else location.reload();
      }
    });
  }

  function sendLike() {
    const likedId = likeBtn.dataset.id;
    fetch("like.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "liked=" + likedId
    })
    .then(res => res.text())
    .then(res => {
      if (res === "match") {
        showMatchAnimation();
      } else {
        location.reload();
      }
    });
  }

  function showMatchAnimation() {
    const matchText = document.createElement("div");
    matchText.textContent = "🎉 É um MATCH!";
    matchText.className = "absolute inset-0 flex items-center justify-center text-3xl font-bold text-pink-600 bg-white bg-opacity-90";

    document.body.appendChild(matchText);

    gsap.fromTo(matchText, { scale: 0 }, { scale: 1, duration: 0.6, ease: "elastic.out(1, 0.5)" });
    setTimeout(() => {
      gsap.to(matchText, { opacity: 0, duration: 0.6, onComplete: () => location.reload() });
    }, 2000);
  }
});
