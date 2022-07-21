$(document).ready(function () {
    let get = window.location.search.substring(1);
    let success = get.substring(get.lastIndexOf("success="));
    if (get.lastIndexOf("success=") !== -1 && get.lastIndexOf("id=") !== -1) {
        // if there is a success message from cart and viewing specific shoe

        var alreadyBought = false;
        $("#cartNotif").addClass("show");
        alreadyBought = true;

        setTimeout(function () {
            if ($("#cartNotif").hasClass("show"))
                $("#cartNotif").removeClass("show");
        }, 3000);
    }
});
