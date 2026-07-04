
/*
Author: FREDDY JR MENDOZA PADILLA
Date: 21/06/2024
Description: Script para seleccionar un participante al azar y disparar confeti.
*/

$(document).ready(function () {
   countuser() 
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
         countuser() 
        
    }).fail(function () {
        console.log('error');
    });
        // Disparar confeti
        confetti({
            particleCount: 1000,
            spread: 400,
            origin: { y: 0.3 }

        });
    });
});

function countuser() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        url: "/countuser",
        data: "data",
        dataType: "json",
        success: function (data) {
            console.log(data)
            $('#user').html(data)
        }
    });
}