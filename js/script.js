//meniu hamburger

// Obține elementele necesare
const menuToggle = document.getElementById('menu-toggle');
const menu = document.getElementById('menu');

// Adaugă un eveniment de click pe butonul hamburger
menuToggle.addEventListener('click', () => {
  menu.classList.toggle('active');
});

// Popup de confirmare trimitere mesaj
document.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);

  // Adaugă un mesaj de debug pentru a verifica parametrul URL
  console.log('Parametri URL:', urlParams.toString());

  if (urlParams.get('mesaj') === 'trimis') {
    const bar = document.getElementById('popup-bar');

    if (bar) {
      // Afișează popup
      console.log('Popup-ul este afișat!');
      bar.style.display = 'block';

      // Ascunde după 5 secunde
      setTimeout(() => {
        console.log('Popup-ul se va ascunde.');
        bar.style.display = 'none';
      }, 5000);

      // Curăță parametrul 'mesaj' din URL
      const url = new URL(window.location);
      url.searchParams.delete('mesaj');
      window.history.replaceState({}, document.title, url);
    } else {
      console.log('Elementul #popup-bar nu a fost găsit!');
    }
  } else {
    console.log("Nu există parametrul 'mesaj' în URL.");
  }
});
