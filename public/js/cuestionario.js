$(document).ready(function () {
   // getPreguntas(); // Cargar preguntas inicialmente
});

// Función para obtener preguntas y seleccionar una al azar
function getPreguntas() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: "GET",
        url: "/randomcuest",
        dataType: "json",
        success: function (data) {
            if (data.msj) {
                $('#selectedParticipant').html(
                    `<strong id='str'>Mensaje:</strong> <strong id='str2'>${data.msj}</strong>`
                );
                return;
            }

            let participants = $.map(data, function (item) {
                return { id: item.id, pregunta: item.preguntas };
            });

            console.log("Preguntas obtenidas:", participants);
            seleccionarPregunta(participants);
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener preguntas:", error);
            $('#selectedParticipant').text("Error al cargar preguntas.");
        }
    });
}

// Función para seleccionar una pregunta al azar y animarla
function seleccionarPregunta(participants) {
    if (participants.length === 0) {
        $('#selectedParticipant').text("No hay más preguntas disponibles.");
        return;
    }

    let $drumroll = $('#drumroll');

    if (!$drumroll.length) {
        console.error("El elemento de audio 'drumroll' no se encontró.");
        return;
    }

    console.log("Iniciando animación...");
    $('#selectedParticipant').addClass('animateText');

    // Animación con texto aleatorio
    let animationInterval = setInterval(function () {
        let randomText = participants[Math.floor(Math.random() * participants.length)].pregunta;
        $('#selectedParticipant').text(randomText);
    }, 100);

    $drumroll[0].play().then(function () {
        console.log("Sonido de redoblante reproducido.");
    }).catch(function (error) {
        console.error("Error al reproducir el sonido:", error);
    });

    setTimeout(function () {
        clearInterval(animationInterval);
        $('#selectedParticipant').removeClass('animateText');

        let selected = participants[Math.floor(Math.random() * participants.length)];

        $('#selectedParticipant').html(
            `<strong id='str'>Pregunta:</strong> <strong id='str2'>${selected.pregunta}</strong>`
        );

        $drumroll[0].pause();
        $drumroll[0].currentTime = 0;

        console.log("Animación finalizada, pregunta seleccionada:", selected);

        // Actualizar estado de la pregunta
        updateQuestionStatus(selected.id);

        confetti({
            particleCount: 900,
            spread: 100,
            origin: { y: 0.6 }
        });
    }, 2000);
}

// Función para actualizar el estado de la pregunta
function updateQuestionStatus(questionId) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        url: "/update-question-status",
        data: { id: questionId },
        success: function (response) {
            console.log("Estado actualizado con éxito:", response);
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar el estado:", error);
        }
    });
}

// Evento al hacer clic en el botón
$('#selectCuest').click(function () {
    console.log("Botón clickeado, obteniendo nuevas preguntas...");
    getPreguntas();
});
