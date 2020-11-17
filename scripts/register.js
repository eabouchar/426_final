$(document).ready(function() {

    // https://www.w3schools.com/jquery/jquery_slide.asp

    $("#register").click(function() {
        $(".login_div").slideUp("slow", function() {
            $(".register_div").slideDown("slow")
        })
    })

    $("#login").click(function() {
        $(".register_div").slideUp("slow", function() {
            $(".login_div").slideDown("slow")
        })
    })

});

