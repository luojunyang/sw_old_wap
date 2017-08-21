
(function () {
    $(".tu1").click(function () {
        console.log(45)
        location.href="yws_store_home.php?store_id="+store_id;

    });
    $(".tu2").click(function () {
        console.log(44)
        location.href="yws_popularise.php?store_id="+store_id;
    });
    $(".tu3").click(function () {
        console.log(43)
        location.href="./drp_ucenter.php";
    });
})();