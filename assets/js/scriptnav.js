// script.js

document.querySelectorAll('.nav-item a').forEach(item => {
  item.addEventListener('click', function() {
    // Remover la clase "activo" de todos los elementos del menú
    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('activo'));
    
    // Agregar la clase "activo" al elemento clicado
    this.parentElement.classList.add('activo');
  });
});
