$(function () {
    if (sessionStorage.getItem('u')!=null) {
        $('#inputUser').val(sessionStorage.getItem('u'));
    }
    if (localStorage.user!=null) {
        console.log('session ON');
        $('#inputUser').val(localStorage.user);
    }

    $('#inputUser').removeClass("invalid");
   

    $('#inputPassword').removeClass("invalid");
    $('#inputLogin').click(function () {

        // $("#change-meta").attr("content", "default-src *; style-src *  'unsafe-inline'; script-src *  'unsafe-inline'; media-src *");

        $('#inputLogin').val('Loading...');
        setTimeout(function(){
            $.post(url_ol+"/json/ldapLoginApi2.php",
                {
                    username: $('#inputUser').val(),
                    password: $('#inputPassword').val()
                },
                function (data) {
                    var dataJson = JSON.parse(data);
                    if (dataJson.status != 'false') {
                    //console.log(JSON.stringify(dataJson.data));
                        sessionStorage.setItem('u', $('#inputUser').val());
                        sessionStorage.setItem('userData', JSON.stringify(dataJson.data));
                        setUserData();
                        sessionStorage.setItem('p', $('#inputPassword').val());
                        localStorage.user = $('#inputUser').val();
                        window.location.href = "index.html";
                        //console.log(data);
                    } else {
                        alert('Access Denied!!');

                        $('#inputUser').addClass("invalid")
                        $('#inputPassword').addClass("invalid")
                         $("#error_bos").text("Login Failed, please try again later");
                    }

                    $('#inputLogin').val('SIGN IN');
                });
        }, 2000);
    })
});