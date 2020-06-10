<?php
session_start();

require_once 'vendor/autoload.php';

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => 'HBLuN3KpcM1g2GrZwwM3phQJkldJe64ZCJm9781Q',
    'clientSecret'            => '',
    'redirectUri'             => 'https://gymkhana.iitb.ac.in/~mlc/nodues/login',
    'urlAuthorize'            => 'https://gymkhana.iitb.ac.in/sso/oauth/authorize/',
    'urlAccessToken'          => 'https://gymkhana.iitb.ac.in/sso/oauth/token/',
    'urlResourceOwnerDetails' => 'https://gymkhana.iitb.ac.in/sso/user/api/user/?fields=roll_number,first_name,last_name'
]);

// Catch errors
if (isset($_GET['error'])) {
    echo "Error occured during authentication";
    exit;
}

// Login with SSO
if (!isset($_GET['code'])) {
    $options = [
        'scope' => ['basic profile program']
    ];
    $authorizationUrl = $provider->getAuthorizationUrl($options);
    header('Location: ' . $authorizationUrl);
    exit;
} else {
    try {
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        $resourceOwner = $provider->getResourceOwner($accessToken);
        $user = $resourceOwner->toArray();

        // Login
        if ($user != null && $user['roll_number'] != null) {
            $_SESSION['rno'] = $user['roll_number'];
            header("location:home");
        } else {
            echo "Failed to get user profile from SSO";
        }
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        exit($e->getMessage());
    }
}
