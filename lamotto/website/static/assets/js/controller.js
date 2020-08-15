const phoneNumber = "3122513459"
function OpenModalRegister() {
    $('#form_modal').modal("toggle")
}
// Load init information form
$(document).ready(function () {
    const date = new Date();
    const dateMin = date.getFullYear() - 15
    const dateMax = date.getFullYear() + 1

    console.log("ready!");
    $("#model_input").attr({
        "max": dateMax, // substitute your own
        "min": dateMin, // values (or variables) here
        "value": date.getFullYear()
    });
});

function printDiv() {
    window.print();
}

function WhatsAppLink() {
    window.open(`https://wa.me/+57${phoneNumber}?text=Me%20interesa%20el%20servicio`);
}

function WhatsAppUser(userID) {
    console.log(">>> userID <<<", userID)
    window.open(`https://wa.me/+57${phoneNumber}?text=Número%20de%20ticket:${userID}`);
}