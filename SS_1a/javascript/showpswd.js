$(".password").mouseover(function () {
    $(this).prop("type", "text");
});
$(".password").mouseout(function () {
    $(this).prop("type", "password");
});
