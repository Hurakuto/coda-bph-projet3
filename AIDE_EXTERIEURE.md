ChatGPT :

nous : peux-tu me donner du code js me permettant de faire en sorte que quand j'appuie sur un boutton ça ouvre un menu


ChatGPT :
Bien sûr ! Voici un exemple simple en JavaScript pour faire en sorte que quand tu cliques sur un bouton, un menu s’ouvre (et se referme si tu recliques).

✅ HTML
<button class="trigger">Ouvrir le menu</button>

<div class="dropdown" style="display: none;">
  <p>Contenu du menu</p>
</div>

✅ CSS (optionnel, juste pour que ce soit visible)
.dropdown {
  background: #eee;
  padding: 10px;
  border: 1px solid #ccc;
  width: 150px;
  margin-top: 10px;
}

✅ JavaScript
document.addEventListener("DOMContentLoaded", () => {
  const trigger = document.querySelector('.trigger');
  const dropdown = document.querySelector('.dropdown');

  trigger.addEventListener('click', () => {
    dropdown.style.display =
      dropdown.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.multi-select')) {
      dropdown.style.display = 'none';
    }
  });
});