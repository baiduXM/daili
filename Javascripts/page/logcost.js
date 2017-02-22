jQuery(document).ready(function() {
    $("select.logcost-type").change(function() {
        var type = $(this).val();
        if (type == "0") {
            $("table tr.data-item").show();
        } else {
            $("table tr.data-item").hide();
            $("table tr.data-item[data-type=" + type + "]").show();
        }
    });
    $(".searchbottom").click(function() {
        var month = $("input.timelimit").val();
        window.location.href = "?module=Gbaopen&action=LogCost&month=" + month;
    });
});