$(document).ready(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("startDate").setAttribute("max", today);
    document.getElementById("addProductDate").setAttribute("max", today);
    document.getElementById("endDate").setAttribute("max", today);
});