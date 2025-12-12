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