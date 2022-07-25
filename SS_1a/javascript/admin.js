$(document).ready(() => {
    $(".editButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        //in edit tools cell, find submit and cancel button, toggle visiblity
        $(event.currentTarget)
            .parent()
            .find(".submitButton, .cancelButton")
            .toggleClass("off");

        //turn on edit inputs, disable
        let row = $(event.currentTarget).parent().parent();
        row.find("p.long").toggleClass("off");
        row.find("input:not(.submitButton)").toggleClass("off");
    });

    $(".cancelButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        //in edit tools cell, find submit and edit button, toggle visiblity
        $(event.currentTarget)
            .parent()
            .find(".submitButton, .editButton")
            .toggleClass("off");

        // vice versa
        let row = $(event.currentTarget).parent().parent();
        row.find("p.long").toggleClass("off");
        row.find("input:not(.submitButton)").toggleClass("off");
    });
});
