var cambiarCSS = function(nuevo) 
{
    document.getElementById('idMain').className = nuevo;
}

function mostrarFicha(palabra, significado, creador) {
    const fichaContainer = document.getElementById('fichaContainer');
    const fichaContent = document.getElementById('fichaContent');
    
    fichaContent.innerHTML = `
        <h2 style="margin-bottom:20px;">${palabra}</h2>
        <div style="margin-bottom:15px;">
            <strong>Significado:</strong>
            <p>${significado}</p>
        </div>
        <div>
            <strong>Creador:</strong>
            <p>${creador}</p>
        </div>
    `;
    
    mostrarFichaContainer();
}

function mostrarFichaContainer() {
    document.getElementById('fichaContainer').style.display = 'block';
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar el contador de votos en la tabla
                const fila = boton.closest('tr');
                const celdaVotos = fila.querySelector('td:nth-child(5)');
                celdaVotos.textContent = data.votes;

                // Obtener ambos botones de la fila
                const botonLike = fila.querySelector('.btn-like');
                const botonDislike = fila.querySelector('.btn-dislike');

                // Luego, según el voto actual, deshabilitamos el correspondiente
                if (data.lastVote === "like") {
                    botonLike.style.cursor = 'not-allowed';
                    botonLike.disabled = true;
                    botonLike.style.opacity = '0.5';
                    botonDislike.style.cursor = 'pointer';
                    botonDislike.disabled = false;
                    botonDislike.style.opacity = '1';
                } else if (data.lastVote === "dislike") {
                    botonLike.style.cursor = 'pointer';
                    botonLike.disabled = false;
                    botonLike.style.opacity = '1';
                    botonDislike.style.cursor = 'not-allowed';
                    botonDislike.disabled = true;
                    botonDislike.style.opacity = '0.5';
                }
                // Si currentVote es null, significa que se quitó el voto
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

