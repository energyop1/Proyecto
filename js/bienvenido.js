 // Función para mostrar la tarjeta de detalles de tarea
 function mostrarTareaCard(titulo, descripcion, urgencia) {
    $('#tareaCardTitulo').text(titulo);
    $('#tareaCardDescripcion').text(descripcion);
    $('#tareaCardUrgencia').text(urgencia);
    $('#tareaCard').show();
    
    // Cerrar el modal de eventos si está abierto
    $('#eventoModal').modal('hide');
    }
    
    // Función para mostrar detalles de evento en modal
    function mostrarDetallesEvento(id) {
    var evento = <?php echo json_encode($eventos); ?>;
    var eventoSeleccionado = evento.find(function(item) {
        return item.id === id;
    });
    
    $('#eventoModalNombre').text(eventoSeleccionado.nombre);
    $('#eventoModalDescripcion').text(eventoSeleccionado.descripcion);
    $('#eventoModalInicio').text(eventoSeleccionado.dia_inicio);
    $('#eventoModalFin').text(eventoSeleccionado.dia_final);
    
    $('#eventoModal').modal('show');
    
    // Cerrar la tarjeta de detalles de tarea si está abierta
    $('#tareaCard').hide();
    }
    
    // Función para mostrar u ocultar detalles del evento
    function toggleDetallesEvento(id) {
    $('#detalle-evento-' + id).collapse('toggle');
    }
    
    function toggleDetallesTarea(id) {
    $('#detalle-tarea-' + id).collapse('toggle');
    }
    
    $(document).ready(function() {
        $('#modo-claro-oscuro').click(function() {
            $('body').toggleClass('modo-claro');
            // Guardar la preferencia del usuario
            var modoActual = $('body').hasClass('modo-claro') ? 'claro' : 'oscuro';
            localStorage.setItem('modo-preferido', modoActual);
        });
    
        // Cargar el tema preferido del usuario al cargar la página
        var modoGuardado = localStorage.getItem('modo-preferido');
        if (modoGuardado === 'claro') {
            $('body').addClass('modo-claro');
        }
    });
    
    
    function marcarCompleto(tipo, id) {
        $.post('completo.php', { tipo: tipo, id: id }, function(response) {
            if (response.success) {
                alert('Marcado como completado correctamente.');
                // Ocultar la tarjeta correspondiente
                if (tipo === 'tarea') {
                    $('#tarea-' + id).fadeOut();
                } else if (tipo === 'evento') {
                    $('#evento-' + id).fadeOut();
                }
            } else {
                alert('Error al marcar como completado: ' + response.message);
            }
        }, 'json');
    }
    $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            <?php foreach ($tareas as $tarea) : ?>
                {
                    title: '<?php echo addslashes($tarea['titulo']); ?>',
                    start: '<?php echo $tarea['dia_limite']; ?>',
                    color: '<?php echo generarColorAleatorio(); ?>' // Color de las tareas en el calendario
                },
            <?php endforeach; ?>
            <?php foreach ($eventos as $evento) : ?>
                {
                    title: '<?php echo addslashes($evento['nombre']); ?>',
                    start: '<?php echo $evento['dia_inicio']; ?>',
                    end: '<?php echo $evento['dia_final']; ?>',
                    color: '<?php echo generarColorAleatorio(); ?>' // Color de los eventos en el calendario
                },
            <?php endforeach; ?>
        ]
    });
    calendar.render();
    
    // Delete task
    $('.delete-task').click(function() {
        var taskId = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas borrar esta tarea?')) {
            $.post('borrar_tarea.php', { id: taskId }, function(response) {
                if (response.success) {
                    alert('Tarea eliminada correctamente.');
                    location.reload();
                } else {
                    alert('Error al borrar la tarea.');
                }
            }, 'json');
        }
    });
    
    // Delete event
    $('.delete-event').click(function() {
        var eventId = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas borrar este evento?')) {
            $.post('borrar_evento.php', { id: eventId }, function(response) {
                if (response.success) {
                    alert('Evento eliminado correctamente.');
                    location.reload();
                } else {
                    alert('Error al borrar el evento.');
                }
            }, 'json');
        }
    });
    });