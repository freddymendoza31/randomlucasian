
/*
Author: FREDDY JR MENDOZA PADILLA
Date: 21/06/2024
Description: Script para seleccionar un participante al azar y disparar confeti.
*/

$(document).ready(function () {
  
    // Evento al hacer clic en el botón
    $('#selectRandom').click(function () {

       $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        url: "/randomuser",
        dataType: "json",
    }).done(function (data) {
        //console.log(data);
        $('#selectedParticipant').html("<strong id='str'>Participante Seleccionado Es:</strong> " + "<strong id='str2'>" + data.nombres_apellidos + "</strong>");
        
    }).fail(function () {
        console.log('error');
    });
        // Disparar confeti
        confetti({
            particleCount: 800,
            spread: 100,
            origin: { y: 0.7 }

        });
    });
});