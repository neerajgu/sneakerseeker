$(document).ready(function () {
    let get = window.location.search.substring(1);
    let success = get.substring(get.lastIndexOf("success=")); // part of url after ?id=x&success=...
    if (get.lastIndexOf("success=") !== -1 && get.lastIndexOf("id=") !== -1) {
        // if there is a success message from cart and viewing specific shoe

        //show snackbar
        $("#cartNotif").addClass("show");

        setTimeout(function () {
            if ($("#cartNotif").hasClass("show"))
                $("#cartNotif").removeClass("show");
        }, 3000);
    }
});
