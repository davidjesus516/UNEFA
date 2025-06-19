</div>
</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let tiempoActual = null; // Guardará la hora inicial de la API
    let intervalo = null;

    function mostrarHora() {
        const ahora = new Date(tiempoActual);

        const opcionesHora = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
            timeZone: 'America/Caracas'
        };
        const opcionesFecha = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'America/Caracas'
        };

        const hora = ahora.toLocaleTimeString('es-VE', opcionesHora);
        const fecha = ahora.toLocaleDateString('es-VE', opcionesFecha);

        document.getElementById("hora-actual").textContent = hora;
        document.getElementById("fecha-actual").textContent = fecha.charAt(0).toUpperCase() + fecha.slice(1);

        // Sumar un segundo manualmente para la próxima actualización
        tiempoActual.setSeconds(tiempoActual.getSeconds() + 1);
    }

    async function obtenerHoraCaracas() {
        try {
            const res = await fetch("https://worldtimeapi.org/api/timezone/America/Caracas");
            const data = await res.json();
            tiempoActual = new Date(data.datetime);

            // Mostrar inmediatamente
            mostrarHora();

            // Luego actualizar cada segundo
            intervalo = setInterval(mostrarHora, 1000);
        } catch (error) {
            console.warn("Fallo al obtener la hora de Caracas. Usando hora local.");
            tiempoActual = new Date(); // Hora local como respaldo
            mostrarHora();
            intervalo = setInterval(mostrarHora, 1000);
        }
    }

    obtenerHoraCaracas();
</script>


<!-- <script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Despliegue de submenús
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        // Despliegue/ocultamiento del sidebar
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        if (sidebarBtn) {
            sidebarBtn.addEventListener("click", () => {
                sidebar.classList.toggle("close");
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modal = document.getElementById("genericModal");

    // Get the element with the class "logo-details" (your clickable title/logo)
    var triggerElement = document.querySelector(".logo-details");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-button")[0];

    // Get the OK button in the modal footer
    var okButton = document.querySelector(".modal-ok-button");

    // When the user clicks the "logo-details" element, open the modal
    if (triggerElement) { // Ensure the element exists before adding event listener
        triggerElement.onclick = function() {
            modal.style.display = "flex"; // Use flex to center the modal
        }
    }


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks on the OK button, close the modal
    okButton.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Function to open specific tab
    window.openTab = function(evt, tabName) {
        var i, tabcontent, tabbuttons;

        // Get all elements with class="tab-content" and hide them
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tab-button" and remove the "active" class
        tabbuttons = document.getElementsByClassName("tab-button");
        for (i = 0; i < tabbuttons.length; i++) {
            tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Set the default open tab (Acerca de)
    document.querySelector('.tab-button.active').click();
});
</script>
</body>

</html>