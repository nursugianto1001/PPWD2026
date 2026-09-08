// ==========================================================
// Kedai Kopi Ranting — script.js
// ==========================================================

document.addEventListener('DOMContentLoaded', function () {

  // ---- Menu navigasi mobile (hamburger) ----
  var navToggle = document.getElementById('navToggle');
  var navMenu = document.getElementById('navMenu');

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      var isOpen = navMenu.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // Tutup menu saat salah satu link diklik (khusus tampilan mobile)
    navMenu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navMenu.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // ---- Tombol kembali ke atas ----
  var backToTop = document.getElementById('backToTop');
  if (backToTop) {
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // ---- Validasi ringan di sisi klien untuk form kontak ----
  var kontakForm = document.querySelector('.kontak-form');
  if (kontakForm) {
    kontakForm.addEventListener('submit', function (event) {
      var nama = kontakForm.querySelector('#nama');
      var email = kontakForm.querySelector('#email');
      var pesan = kontakForm.querySelector('#pesan');

      var kosong = [nama, email, pesan].some(function (field) {
        return field && field.value.trim() === '';
      });

      if (kosong) {
        event.preventDefault();
        alert('Mohon lengkapi semua kolom sebelum mengirim pesan.');
      }
    });
  }

});