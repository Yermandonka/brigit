var cambiarCSS = function (nuevo) {
    document.getElementById('idMain').className = nuevo;
}

function mostrarFicha(palabra, significado, creador) {
    const fichaContainer = document.getElementById('fichaContainer');
    const fichaContent = document.getElementById('fichaContent');

    // Hacer la petición AJAX para obtener la WordTable
    fetch(`wordTableHandler.php?palabra=${encodeURIComponent(palabra)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            fichaContent.innerHTML = `
                <button id="buttonFichaContent" onclick="ocultarFichaContainer()">✕</button>
                <h2 class="ficha-title">Significados de ${palabra}</h2>
                <div class="wordTable-container">${html}</div>
                <button id="btnAddSignificado" onclick="mostrarFormNuevoSignificado('${palabra}')" class="btn-add">
                    + Añadir significado
                </button>
            `;
            mostrarFichaContainer();
        })
        .catch(error => {
            console.error('Error al cargar WordTable:', error);
            fichaContent.innerHTML = `
                <button id="buttonFichaContent" onclick="ocultarFichaContainer()">✕</button>
                <h2 class="ficha-title">Significados de "${palabra}"</h2>
                <div class="error-message">Error al cargar la información: ${error.message}</div>
            `;
            mostrarFichaContainer();
        });
}

function mostrarFichaContainer() {
    document.getElementById('fichaContainer').style.display = 'flex';
}

function ocultarFichaContainer() {
    document.getElementById('fichaContainer').style.display = 'none';
}

function votar(palabra, significado, tipo, boton) {
    // Evitar que el click se propague al tr
    event.stopPropagation();

    // Hacer la petición AJAX
    const url = `votar.php?palabra=${palabra}&significado=${significado}&tipo=${tipo}`;

    fetch(url)
        .then(response => response.text())
        .then(text => {
            console.log('Respuesta del servidor:', text);
            // Intentar parsear el texto como JSON
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    // Actualizar el contador de votos en la tabla
                    const fila = boton.closest('tr');
                    const celdaVotos = fila.querySelector('td:nth-child(5)');
                    celdaVotos.textContent = data.votes;

                    // Debug del tipo recibido
                    console.log('Tipo:', tipo);
                    console.log('LastVote:', data.lastVote);

                    // Obtener ambos botones de la fila
                    const botonLike = fila.querySelector('.btn-like');
                    const botonDislike = fila.querySelector('.btn-dislike');

                    // Primero reseteamos ambos botones
                    botonLike.style.cursor = 'pointer';
                    botonLike.disabled = false;
                    botonLike.style.opacity = '1';

                    botonDislike.style.cursor = 'pointer';
                    botonDislike.disabled = false;
                    botonDislike.style.opacity = '1';

                    // Ahora aplicamos el estado según el voto actual
                    if (data.lastVote === tipo) {
                        if (tipo === 'like') {
                            botonLike.style.cursor = 'not-allowed';
                            botonLike.disabled = true;
                            botonLike.style.opacity = '0.5';
                        } else {
                            botonDislike.style.cursor = 'not-allowed';
                            botonDislike.disabled = true;
                            botonDislike.style.opacity = '0.5';
                        }
                    }
                }
            } catch (e) {
                console.error('Error al parsear JSON:', e);
                console.error('Texto recibido:', text);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

function mostrarFormNuevoSignificado(palabra) {
    const formContainer = document.createElement('div');
    formContainer.id = 'formNuevoSignificado';
    formContainer.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1001;';

    formContainer.innerHTML = `
        <div class="form-content" style="background: white; padding: 2rem; border-radius: 10px; width: 90%; max-width: 600px;">
            <button onclick="cerrarFormNuevoSignificado()" style="float: right; border: none; background: none; font-size: 24px; cursor: pointer;">✕</button>
            <h3>Añadir nuevo significado para "${palabra}"</h3>
            <textarea id="nuevoSignificado" style="width: 100%; margin: 1rem 0; padding: 0.5rem; height: 100px;"></textarea>
            <button onclick="guardarNuevoSignificado('${palabra}')" style="background: black; color: white; border: none; padding: 0.5rem 1rem; cursor: pointer;">Guardar</button>
        </div>
    `;

    document.body.appendChild(formContainer);
}

function cerrarFormNuevoSignificado() {
    const form = document.getElementById('formNuevoSignificado');
    if (form) {
        form.remove();
    }
}

function guardarNuevoSignificado(palabra) {
    const significado = document.getElementById('nuevoSignificado').value;
    if (!significado.trim()) {
        alert('Por favor, introduce un significado');
        return;
    }

    fetch('guardarSignificado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `palabra=${encodeURIComponent(palabra)}&significado=${encodeURIComponent(significado)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cerrarFormNuevoSignificado();
            // Recargar la tabla de significados
            mostrarFicha(palabra);
        } else {
            alert('Error al guardar el significado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el significado');
    });
}

