var cambiarCSS = function (nuevo) {
    document.getElementById('idMain').className = nuevo;
}

function mostrarFicha(palabra, significado, creador) {
    const fichaContent = document.getElementById('fichaContent');

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
                <button id="btnAddSignificado" onclick="mostrarFicha2()" class="btn-add">
                    + Añadir significado
                </button>
                <div id="significadoFormContainer" style="display:none">
                    <div id="significadoForm"></div>
                </div>
            `;
            mostrarFichaContainer();
        })
        .catch(error => {
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
    const palabra = document.querySelector('.ficha-title').textContent.split(' ').pop();
    const url = `getVotes.php?palabra=${encodeURIComponent(palabra)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const rankingFila = document.querySelector(`tr[id="${palabra}"]`);
                if (rankingFila) {
                    const celdaVotos = rankingFila.querySelector('td:nth-child(5)');
                    if (celdaVotos) {
                        celdaVotos.textContent = data.votes;
                    }
                }
            }
        })
        .catch(error => {});

    document.getElementById('fichaContainer').style.display = 'none';
}



function votar(palabra, significado, tipo, boton) {
    event.stopPropagation();
    const url = `votar.php?palabra=${palabra}&significado=${significado}&tipo=${tipo}`;

    fetch(url)
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    const fila = boton.closest('tr');
                    const celdaVotos = fila.querySelector('td:nth-child(5)');
                    celdaVotos.textContent = data.votes;

                    const botonLike = fila.querySelector('.btn-like');
                    const botonDislike = fila.querySelector('.btn-dislike');

                    if (tipo === 'like') {
                        botonLike.style.cursor = 'not-allowed';
                        botonLike.disabled = true;
                        botonLike.style.opacity = '0.5';
                        if(data.lastVote === 'dislike') {
                            botonDislike.style.cursor = 'pointer';
                            botonDislike.disabled = false;
                            botonDislike.style.opacity = '1';
                        }
                    } else {
                        botonDislike.style.cursor = 'not-allowed';
                        botonDislike.disabled = true;
                        botonDislike.style.opacity = '0.5';
                        if(data.lastVote === 'like') {
                            botonLike.style.cursor = 'pointer';
                            botonLike.disabled = false;
                            botonLike.style.opacity = '1';
                        }
                    }
                }
            } catch (e) {}
        })
        .catch(error => {});
}

function votar2(palabra, significado, tipo, boton) {
    event.stopPropagation();
    const url = `votar.php?palabra=${palabra}&significado=${significado}&tipo=${tipo}`;

    fetch(url)
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    const fila = boton.closest('tr');
                    const celdaVotos = fila.querySelector('td:nth-child(4)');
                    celdaVotos.textContent = data.votesMeaning;

                    const botonLike = fila.querySelector('.btn-like');
                    const botonDislike = fila.querySelector('.btn-dislike');

                    if (tipo === 'like') {
                        botonLike.style.cursor = 'not-allowed';
                        botonLike.disabled = true;
                        botonLike.style.opacity = '0.5';
                        if(data.lastVote === 'dislike') {
                            botonDislike.style.cursor = 'pointer';
                            botonDislike.disabled = false;
                            botonDislike.style.opacity = '1';
                        }
                    } else {
                        botonDislike.style.cursor = 'not-allowed';
                        botonDislike.disabled = true;
                        botonDislike.style.opacity = '0.5';
                        if(data.lastVote === 'like') {
                            botonLike.style.cursor = 'pointer';
                            botonLike.disabled = false;
                            botonLike.style.opacity = '1';
                        }
                    }
                }
            } catch (e) {}
        })
        .catch(error => {});
}

function mostrarSignificadoFormContainer() {
    document.getElementById('significadoFormContainer').style.display = 'flex';
}

function ocultarSignificadoFormContainer() {
    document.getElementById('significadoFormContainer').style.display = 'none';
}

function mostrarFicha2() {
    const fichaContent = document.getElementById('significadoForm');

    fichaContent.innerHTML = `
        <form id="formNuevoSignificado">
            <div class="form-group">
                <label for="nuevoSignificado">Nuevo significado:</label>
                <textarea id="nuevoSignificado" class="form-control" required></textarea>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="ocultarSignificadoFormContainer()">Cancelar</button>
            </div>
        </form>
    `;

    mostrarSignificadoFormContainer();

    document.getElementById('formNuevoSignificado').addEventListener('submit', function (e) {
        e.preventDefault();
        guardarNuevoSignificado(document.querySelector('.ficha-title').textContent.split(' ').pop());
    });
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
                ocultarSignificadoFormContainer();
                mostrarFicha(palabra);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error al guardar el significado');
        });
}

function eliminar(palabra, boton) {
    event.stopPropagation();
    if (confirm('¿Estás seguro de que quieres borrar esta palabra?')) {
        const url = `borrarPalabra.php?palabra=${encodeURIComponent(palabra)}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const fila = boton.closest('tr');
                    fila.remove();
                } else {
                    alert('No se pudo borrar la palabra');
                }
            })
            .catch(error => {
                alert('Error al borrar la palabra');
            });
    }
}

function eliminar2(palabra, boton) {
    event.stopPropagation();
    if (confirm('¿Estás seguro de que quieres borrar esta palabra?')) {
        const url = `borrarPalabra.php?palabra=${encodeURIComponent(palabra)}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const fila = boton.closest('tr');
                    fila.remove();
                } else {
                    alert('No se pudo borrar la palabra');
                }
            })
            .catch(error => {
                alert('Error al borrar la palabra');
            });
    }
}

