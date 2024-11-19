<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php'; 
use League\OAuth2\Client\Provider\GenericProvider;
use Dotenv\Dotenv;

class Azure {
    private $provider;

    public function __construct() {
        // Cargar el archivo .env desde la raíz del proyecto
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        // Crear el proveedor de OAuth2 utilizando las variables del archivo .env
        $this->provider = new GenericProvider([
            'clientId'                => $_ENV['CLIENT_ID'],    
            'clientSecret'            => $_ENV['CLIENT_SECRET'],
            'redirectUri'             => $_ENV['REDIRECT_URI'],
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . $_ENV['TENANT_ID'] . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . $_ENV['TENANT_ID'] . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
            'scopes'                  => [$_ENV['SCOPE']]
        ]);
    }

    public function getProvider() {
        return $this->provider;
    }

    public function getAuthorizationUrl() {
        return $this->provider->getAuthorizationUrl();
    }

    public function getAccessToken($grant, $options = []) {
        return $this->provider->getAccessToken($grant, $options);
    }

    public function getUserDetails($accessToken) {
        // Realiza una solicitud a la API de Microsoft Graph para obtener los detalles del usuario
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            'https://graph.microsoft.com/v1.0/me',
            $accessToken
        );

        $response = $this->provider->getResponse($request);
        return json_decode($response->getBody(), true);  // Retorna los detalles del usuario en formato array
    }
}
