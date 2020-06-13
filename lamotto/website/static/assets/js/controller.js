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