function toggleDropdown() {
    const navs = document.querySelectorAll('.toggle-item-view');
    navs.forEach(nav => nav.classList.toggle('show-item'));
    console.log('toggle');
  }
  
// document.querySelector('.buger-menu').addEventListener('click', toggleDropdown);