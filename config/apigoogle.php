<?php
require 'vendor/autoload.php';
include 'connection.php';
include 'env.php';

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

session_start();
// Call Google API


$sql_CLIENTID = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='CLIENTID'"));
$clientID = $sql_CLIENTID['value'] != null ? $sql_CLIENTID['value'] : getenv('CLIENTID');

$sql_CLIENTSECRET = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='CLIENTSECRET'"));
$clientSecret = $sql_CLIENTSECRET['value'] != null ? $sql_CLIENTSECRET['value'] : getenv('CLIENTSECRET');

$sql_REDIRECTURI = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='REDIRECTURI'"));
$redirectUri = $sql_REDIRECTURI['value'] != null ? $sql_REDIRECTURI['value'] : getenv('REDIRECTURI');

$sql_BASE_URL = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
$base_url = $sql_BASE_URL['value'] != null ? $sql_BASE_URL['value'] : getenv('BASE_URL');

$sql_ACCESS_KEY = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
$access_key = $sql_ACCESS_KEY['value'] != null ? $sql_ACCESS_KEY['value'] : getenv('ACCESS_KEY');

$googleClient = new Google_Client();
$googleClient->setApplicationName('Tahura');
$googleClient->setClientId($clientID);
$googleClient->setClientSecret($clientSecret);
$googleClient->setRedirectUri($redirectUri);
$googleClient->setAccessType('offline');
$googleClient->setApprovalPrompt('force');

$googleClient->addScope("email");
$googleClient->addScope("profile");

$login_button = '';
if(isset($_GET["code"]))
{
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET["code"]);
    if(!isset($token['error']))
    {
        $googleClient->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($googleClient);
        $data = $google_service->userinfo->get();
        $response = $client->post($base_url.'login-sosmed', [
                'form_params' => [
                    'firstname' => $data['givenName'] ?? null,
                    'lastname'  => $data['familyName'] ?? null,
                    'username'  => str_replace("@gmail.com", "", $data['email']),
                    'email'     => $data['email'] ?? null,
                    'google_account_id'   => $data['id'] ?? null,
                    'ip_address'    => $_SERVER['REMOTE_ADDR'],
                    'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
                ],
                'headers' => [
                    'Access-Key' => $access_key
                ],
            ]
        );
        $res = json_decode($response->getBody(), true);
        $message = $res['message'];
        if($res['error']){
            echo "<script type='text/javascript'>";
            echo "alert('$message'); window.location.href='login.php'";
            echo "</script>";
        }else{
            if(isset($res['data'])){
                $_SESSION['uuid']  = $res['data']['user']['id'];
                $_SESSION['nama_user']  = $res['data']['user']['fullname'];
                $_SESSION['token'] = "bearer ".$res['data']['authorization']['token'];

                $email      = $res['data']['user']['email'];
                $user_id    = $res['data']['user']['id'];

                $is_exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user_verification WHERE email='$email' AND user_id_tiket_pendakian='$user_id'"));
                if(empty($is_exist_user)){
                    mysqli_query($conn, "INSERT INTO user_verification(email, status_code, user_id_tiket_pendakian)VALUES('$email', 1, '$user_id')");
                }

                echo "<script type='text/javascript'>";
                echo "alert('$message'); window.location.href='index.php'";
                echo "</script>";
            }else{
                $RevokeTokenURL="https://accounts.google.com/o/oauth2/revoke?token=".$token['access_token'];
                $ch = curl_init($RevokeTokenURL);
                curl_exec($ch);
                curl_close($ch);

                unset($_SESSION['access_token']);
                unset($_SESSION['uuid']);
                unset($_SESSION['token']);

                echo "<script type='text/javascript'>";
                echo "alert('$message'); window.location.href='login.php'";
                echo "</script>";
            }
        }
    }
}

if(!isset($_SESSION['access_token']))
{
    $login_button = $googleClient->createAuthUrl();
}

?>