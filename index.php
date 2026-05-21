// app.js — Bender's Chilaquiles
// Lógica compartida de toda la app

// ── Menú mobile ─────────────────────────────────────────────────
document.addEventListener('click', function(e) {
  const sidebar = document.getElementById('sidebar');
  const btn = document.querySelector('.menu-btn');
  if (sidebar && btn && !sidebar.contains(e.target) && !btn.contains(e.target)) {
    sidebar.classList.remove('open');
  }
});

// ── Cerrar alertas ───────────────────────────────────────────────
document.querySelectorAll('.alert').forEach(alert => {
  alert.style.cursor = 'pointer';
  alert.title = 'Click para cerrar';
  alert.addEventListener('click', () => {
    alert.style.opacity = '0';
    alert.style.transition = 'opacity .3s';
    setTimeout(() => alert.remove(), 300);
  });
});
