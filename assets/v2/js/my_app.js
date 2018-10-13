function goToPage(pageIndex) {
    $("#pi").val(pageIndex);
    document.form1.submit();
}

$(document).ready(function () {
    $("#ps").change(function () {
        $("#pi").val(1);
        document.form1.submit();
    });
});