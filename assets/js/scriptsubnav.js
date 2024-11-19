 
 const submenus = {
    usuarios: `
      <li><a href="../Administrador/listUser.php">Ver lista de Usuarios</a></li>
      <li><a href="../Administrador/createUser.php">Crear nuevo Usuario</a></li>
      <li><a href="../Administrador/matricularUser.php">Matricular Usuario</a></li>
      <li><a href="../Administrador/deleteUser.php">Eliminar Usuario</a></li>
      
       
    `,
    carreras: `
      <li><a href="#">Ver lista de carreras</a></li>
      <li><a href="#">Crear nueva carrera</a></li>
      <li><a href="#">Editar carrera</a></li>
      <li><a href="#">Eliminar carrera</a></li>
    `,
    materias: `
      <li><a href="#">Ver lista de materias</a></li>
      <li><a href="#">Crear nueva materia</a></li>
      <li><a href="#">Editar materia</a></li>
      <li><a href="#">Eliminar materia</a></li>
    `
  };
  function showSubmenu(menuItem, menu) {
    document.getElementById('submenu-items').innerHTML = submenus[menu];
    document.getElementById('sub-navbar').style.display = 'block';
  }
  document.addEventListener('click', function(event) {
    if (!event.target.closest('.navbar') && !event.target.closest('.sub-navbar')) {
      document.getElementById('sub-navbar').style.display = 'none';
    }
  });