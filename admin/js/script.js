var $ = jQuery.noConflict();
$('.btn-close').click(function(){
    $('.disclaimer-content').addClass('disclaimer-disable')
});


$(".grt-cookie").grtCookie({
    // Main text and background color
    // Duration in days
    background: "transparent",
    duration: 1,
});
$(".grt-cookie-button").on("click", function () {
    $('.grt-cookie').remove();
    document.cookie = "acceptgrt=0;" + expiredate + ";path=/";
});