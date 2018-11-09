    function exitApps() {
        navigator.app.exitApp();
    }
    $(document).on('ready', function () {
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
        $('.single-item').slick(
            {
                arrows: true,
                autoplay: false,
                autoplaySpeed: 3000,
                dots: true,
            });
        $('.bottom-item').slick(
            {
                arrows: true,
                autoplay: true,
                autoplaySpeed: 2000
            });
        $('.fade').slick({
            infinite: true,
            speed: 1000,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 3000
        });
    });
    var backButtonPressed = false, intval = setInterval(function () {
        backButtonPressed = false;
    }, 1000);
    ;
    document.addEventListener("backbutton", function (e) {
        e.preventDefault();
        if (backButtonPressed) {
            clearInterval(intval)
            (navigator.app && navigator.app.exitApp()) || (device && device.exitApp())
        }
        else {
            window.plugins.toast.showShortBottom('Press again to exit', function (a) {
                console.log('toast success: ' + a)
            }, function (b) {
                alert('toast error: ' + b)
            });
            backButtonPressed = true;
            // history.back(1);
        }
    }, false);

    $(function () {
        var intervalTime = 3600000;
        var myTimer;
        myTimer = setInterval(function () {
            console.log('interval ');
            // alert('log');
            window.location.href = 'index_login2.html';
        }, intervalTime);

        $('body').bind('touchstart', function () {
            console.log('touchstart');
            clearInterval(myTimer);
        });

        $('body').bind('touchend', function () {
            console.log('touchend');
            myTimer = setInterval(function () {
                // alert('log');
                console.log('interval ');
                window.location.href = 'index_login2.html';
            }, intervalTime);
        });
    });

    $(function () {
        var role = getSession();
        // console.log(role);
        var list = ['PRODUCTION', 'SALES', 'SCM', 'FINANCE', 'PROJECT', 'INVENTORY', 'MAINTENANCE', 'TRESURI', 'CAPEX', 'QUALITY'];
        // console.log(list);
        if (!role) {


        } else {
            $.each(list, function (index, el) {
                // console.log(index +'-'+el);
                if (role[el] == "0") {

                    $('#' + el).removeAttr('href');
                    $('#' + el + ' img').addClass('hide');
                }
            });
        }
        // $('#PRODUCTION').removeAttr('href');
        // $('#PRODUCTION img').addClass('hide');
    })

