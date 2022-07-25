//show
$(".password").mouseover(function () {
    $(this).prop("type", "text");
});

//hide
$(".password").mouseout(function () {
    $(this).prop("type", "password");
});
