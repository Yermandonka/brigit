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
    // Debug logs
    console.log('Iniciando voto:', { palabra, significado, tipo });
    
    // Evitar que el click se propague al tr
    event.stopPropagation();
    console.log('Click propagation detenida');
    
    // Hacer la petición AJAX
    const url = `votar.php?palabra=${palabra}&significado=${significado}&tipo=${tipo}`;
    console.log('Haciendo petición a:', url);

    fetch(url)
        .then(response => {
            console.log('Respuesta recibida:', response);
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            if (data.success) {
                // Actualizar el contador de votos en la tabla
                const fila = boton.closest('tr');
                const celdaVotos = fila.querySelector('td:nth-child(5)');
                const votosAnteriores = celdaVotos.textContent;
                celdaVotos.textContent = data.votes;
                console.log('Votos actualizados:', { anteriores: votosAnteriores, nuevos: data.votes });
            } else {
                console.error('Error en la respuesta:', data);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

