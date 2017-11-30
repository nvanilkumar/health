$(function () {
    //login check
    $("#login-link").click(function () {
        loginSubmit();
    });
    $('#password').keyup(function (e) {
        if (e.keyCode == 13)
        {
            loginSubmit();
        }
    });

});


function loginSubmit()
{
    userName = $('#username').val();
    password = $('#password').val();
    LoginType = 'staff';
    if (userName == "") {
        $('#username').focus();
        $('#username').addClass("invalid");
    } else if (password == "") {
        $('#password').focus();
        $('#password').addClass("invalid");
    }

    if (userName != '' && password != '') {
        $.ajax({
            type: "POST",
            url: loginApiUrl,
            data: {username: userName, password: password, user_role: LoginType},
            dataType: 'json',
            success: function (response) {
console.log(response);
                if (response.response.status == false) {
                    $("#errorMessage").html(response.response.message);
                } else if (response.response.status == true) {
                    window.location.href = mtcBaseUrl + "/dashboard";
                }else{
                    console.log(44444);
                    $("#errorMessage").html("Invalid Details");
                }

            },
            error: function (error) {

                $("#errorMessage").html(error.response.message);
            }
        });


    }
}
