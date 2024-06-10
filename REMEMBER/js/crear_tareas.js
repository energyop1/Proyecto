
  // Función para alternar el color del botón y manejar el nivel de urgencia
function toggleColor(button) {
    // Obtener el valor de urgencia asociado al botón
    var urgencia = $(button).data('urgencia');
    
    // Verificar si el botón ya está activo
    if ($(button).hasClass('active')) {
        // Si está activo, desactivarlo y cambiar su color a negro
        $(button).removeClass('active');
        $(button).css('color', 'black');
        // Vaciar el valor del nivel de urgencia
        $('#nivel_urgencia').val('');
    } else {
        // Si no está activo, desactivar otros botones y cambiar su color a negro
        $('.btn-pencil').removeClass('active').css('color', 'black');
        // Activar el botón actual y cambiar su color a morado
        $(button).addClass('active');
        $(button).css('color', 'purple'); // Cambia el color al activar
        // Establecer el valor del nivel de urgencia
        $('#nivel_urgencia').val(urgencia);
    }
}

// Función para validar la fecha límite de una tarea
function validateDate() {
    // Obtener el valor del input de fecha límite
    var dateInput = document.querySelector('input[name="dia_limite"]').value;
    // Convertir el valor de fecha en un objeto Date
    var selectedDate = new Date(dateInput);
    // Establecer la fecha mínima permitida
    var minDate = new Date('2024-01-01');

    // Verificar si la fecha seleccionada es anterior a la fecha mínima
    if (selectedDate < minDate) {
        // Mostrar una alerta si la fecha no es válida
        alert('El día límite no puede ser anterior al año 2024.');
        return false;
    }
    return true;
}

// Función para validar las fechas de inicio y final de un evento
function validateEventDates() {
    // Obtener los valores de los inputs de fecha de inicio y final
    var diaInicio = document.querySelector('input[name="dia_inicio"]').value;
    var diaFinal = document.querySelector('input[name="dia_final"]').value;

    // Convertir los valores de fecha en objetos Date
    var inicioDate = new Date(diaInicio);
    var finalDate = new Date(diaFinal);
    // Establecer la fecha mínima permitida
    var minDate = new Date('2024-01-01');

    // Verificar si las fechas de inicio o final son anteriores a la fecha mínima
    if (inicioDate < minDate || finalDate < minDate) {
        // Mostrar una alerta si alguna de las fechas no es válida
        alert('Las fechas del evento no pueden ser anteriores al año 2024.');
        return false;
    }

    // Verificar si la fecha final es anterior a la fecha de inicio
    if (finalDate < inicioDate) {
        // Mostrar una alerta si la fecha final no es válida
        alert('El día final no puede ser anterior al día de inicio.');
        return false;
    }

    return true;
}