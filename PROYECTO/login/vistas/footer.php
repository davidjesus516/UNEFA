</div>
</div>
</section>
<script src="js/app.js"></script>
<script src="../js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js" defer></script>

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

</body>

</html>