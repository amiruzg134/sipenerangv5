<?php
require 'vendor/autoload.php';
require 'config/env.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();
session_start();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <link id="pagestyle" href="./assets/css/material-kit-pro.min.css?v=3.0.2" rel="stylesheet" />

        <style>
            .row {
                margin: 0;
                padding: 0;
            }
            .row>* {
                margin: 0 !important;
                padding: 0 !important;
            }
            .login-with-google-btn {
                transition: background-color 0.3s, box-shadow 0.3s;
                padding: 12px 16px 12px 42px;
                border: none;
                border-radius: 3px;
                box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
                color: #757575;
                font-size: 14px;
                font-weight: 500;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
                background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
                background-color: white;
                background-repeat: no-repeat;
                background-position: 12px 11px;
            }
            .login-with-google-btn:hover {
                box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
            }
            .login-with-google-btn:active {
                background-color: #eeeeee;
            }
            .login-with-google-btn:focus {
                outline: none;
                box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
            }
            .login-with-google-btn:disabled {
                filter: grayscale(100%);
                background-color: #ebebeb;
                box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
                cursor: not-allowed;
            }
        </style>
    </head>
    <body>

    <div class="row vh-100">
        <div class="col-md-12 col-xl-5">
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="p-4 w-100 w-md-50 w-xl-75">
                    <h4 class="mb-4">Daftar Sekarang Juga</h4>
                    <form action="" method="post">
                        <div class="">
                            <div class="input-group input-group-static mb-4">
                                <label>Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" required>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                            </div>
                            <button type="button" id="btn_submit" class="btn btn-primary w-100">
                                <span id="btn-text-proses">Register</span>
                                <div class="spinner-border spinner-border-sm" role="status" id="loading" style="display: none;">
                                </div>
                            </button>
                        </div>
                        Sudah punya akun? <a href="login.php">Login</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-7 d-none d-xl-block">
            <div class="h-100 w-100" style="background-image: url('./assets/img/mountains-190055_1280 1.png'); background-size:cover; background-repeat: no-repeat; background-position: center; border-top-left-radius: 25px; border-bottom-left-radius: 25px;"></div>
        </div>
    </div>

    <script src="./assets/js/core/jquery-min.js" type="text/javascript"></script>
    <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/js/material-kit-pro.min.js?v=3.0.2" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    </script>

    </body>
    </html>

    <script>
    $(document).ready(function() {
        $('#btn_submit').click(function () {
            var key = $('#key').val();
            var email = $('#email').val();
            var username = $('#username').val();
            var password = $('#password').val();
            $.ajax({
                type    : "POST",
                url     : "api/register.php",
                data    : {
                    key: key,
                    email: email,
                    username: username,
                    password: password,
                },
                beforeSend: function() {
                    $('#btn-text-proses').hide()
                    $('#loading').show()
                    $('#btn_submit').prop('disabled', true)
                },
                complete: function() {
                    $('#btn-text-proses').show()
                    $('#loading').hide()
                    $('#btn_submit').prop('disabled', false)
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.error){
                        alert("Terjadi kesalahan!, "+json.message);
                    }else{
                        alert("Pendaftaran berhasil, Silakan cek email Anda untuk verifikasi email dan melanjutkan Pemesanan Tiket");
                        window.location.href = "login.php";
                    }
                }
            });
            return false;
        });
    })
</script>

