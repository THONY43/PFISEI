
document.getElementById("carrera").addEventListener("change", function() {
    var selectNivel = document.getElementById("nivel");
    var selectParalelo = document.getElementById("paralelo");
    var idCarrera = this.value;
    var duracionCarrera = this.options[this.selectedIndex].getAttribute("data-duracion");

    // Limpiamos las opciones previas de "Nivel" y "Paralelo"
    selectNivel.innerHTML = "";

    // Llenamos los niveles según la duración de la carrera
    for (var i = 0; i <= duracionCarrera; i++) {
        var option = document.createElement("option");
        option.value = i;
        option.text = "Nivel " + i;
        selectNivel.appendChild(option);
    }

});






// Disparar el evento 'change' al cargar la página para cargar los niveles y paralelos
document.getElementById("carrera").dispatchEvent(new Event("change"));

