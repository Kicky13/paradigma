$(document).ready(function () {
    console.log("Test");
    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false
    });
    $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false
    });
    $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true,
        arrows: false,
    });
    $('.single-item').slick({
        // autoplay: true,
        // autoplaySpeed: 5000
        arrows: false
    });
    $('.single-item').slick();
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4
    });
    $(".regular").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        centerMode: true
        // variableWidth: true
    });
});