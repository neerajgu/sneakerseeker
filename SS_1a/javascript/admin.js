function cellBool(row, i) {
    return row.children[i].innerText || row.children[i].textContent;
}

//comparison function for js sort
var compare = function (index, order) {
    return function (a, b) {
        return (function (x, y) {
            // if its a number, just subtract otherwise use string compare (slow)
            return x !== "" && y !== "" && !isNaN(x) && !isNaN(y)
                ? x - y
                : x.toString().localeCompare(y);
        })(
            //return, is a or b greate as boolean
            cellBool(order ? a : b, index),
            cellBool(asc ? b : a, index)
        );
    };
};

$(document).ready(() => {
    $("table thead tr").on("click", "th", (event) => {
        let table = $(event.currentTarget).parent().parent().parent();
        let col = $(event.currentTarget);

        if (col.hasClass("asc")) {
            table.find(".asc, .desc").removeClass("asc").removeClass("desc");
            col.addClass("desc");
        } else {
            table.find(".asc, .desc").removeClass("asc").removeClass("desc");
            col.addClass("asc");
        }

        // change to bool
        // let order = col.hasClass("asc") ? true :

        // using js objects because for some reason jquery spits out undefined objects at random(?) even if it is converted with $object[0]
        let tbody = table[0].querySelector("tbody");
        Array.from(tbody.querySelectorAll("tr"))
            .sort(
                // compare function
                compare(
                    Array.from(
                        $(event.currentTarget).parent().children().get()
                    ).indexOf($(event.currentTarget)[0]),
                    (this.asc = !this.asc)
                )
            )
            .forEach((tr) => tbody.appendChild(tr));
        // then shoot out the sorted array of elements
    });

    $(".editButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        //in edit tools cell, find submit, delete and cancel button, toggle visiblity
        $(event.currentTarget)
            .parent()
            .find(".submitButton, .cancelButton, .deleteButton")
            .toggleClass("off");

        //turn on edit inputs, disable
        let row = $(event.currentTarget).parent().parent();
        row.find("p.long").toggleClass("off");
        row.find("input:not(.submitButton), select").toggleClass("off");
    });

    $(".cancelButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        //in edit tools cell, find submit and edit button, toggle visiblity
        $(event.currentTarget)
            .parent()
            .find(".submitButton, .editButton, .deleteButton")
            .toggleClass("off");

        // vice versa
        let row = $(event.currentTarget).parent().parent();
        row.find("p.long").toggleClass("off");
        row.find("input:not(.submitButton), select").toggleClass("off");
    });

    $(".createButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        $(".cancelCreateButton").toggleClass("off");
        $("form.add").toggleClass("off");
    });

    $(".cancelCreateButton").on("click", "", (event) => {
        //disable self visiblity
        $(event.currentTarget).toggleClass("off");
        $(".createButton").toggleClass("off");
        $("form.add").toggleClass("off");
    });
});
