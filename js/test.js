
$(document).ready(function(){
    $(".clickVideo").on("click", function(){
        var code = $(this).data("code");
        console.log(code);

        $("#principal-video").attr('src', 'https://www.youtube.com/embed/'+code);
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });
});/**
 * Created by ASUS on 23/10/2016.
 */
