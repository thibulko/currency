<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $options = [
        'client_id' => 'ek_token_ico',
        'client_secret' => 'equ2EeH7r',
        'redirect_uri' => 'http://127.0.0.1:8000/callback',
        'scope' => 'firstname,surname,email,phone,pwhash,viber,skype,wechat,trust_level,otp,totp_secret'
    ];

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->options['client_id'],
            'client_secret' => $this->options['client_secret'],
            'redirect_uri' => $this->options['redirect_uri'],
            'scope' => $this->options['scope']
        ]);

        return redirect('https://testing.e-id.cards/oauth/users.deal@ukr.net/EiG3oobetest1/EiG3oobe?' . $query);
    }

    /**
     * @param Request $request
     * @return null|string
     */
    public function callback(Request $request): ?string
    {
        if (!$request->has('code')) {
            return null;
        }

        $token = $this->getAccessToken($request->code);

        if (!empty($token)) {
            $userData = $this->getUserData($token);

            // todo: need realized as save sid to storage
            if (!empty($userData)) {
                $sid = $this->getSid($userData);
                print $sid;
                return $sid;
            }
        }

        return null;
    }

    /**
     * @param string $code
     * @return null|string
     */
    private function getAccessToken(string $code): ?string
    {
        $response = $this->client->post('https://testing.e-id.cards/oauth/client', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->options['client_id'],
                'client_secret' => $this->options['client_secret'],
                'redirect_uri' => $this->options['redirect_uri'],
                'code' => $code
            ]
        ]);

        $data = json_decode((string) $response->getBody(), true);
        return $data['access_token'] ?? null;
    }

    /**
     * @param string $token
     * @return array
     */
    private function getUserData(string $token): array
    {
        $response = $this->client->get('https://testing.e-id.cards/oauth/data', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * @param array $userData
     * @return string
     */
    private function getSid(array $userData): string
    {
        $response = $this->client->post('https://testing.bb.yttm.work:5000/v1/oauth_auth', [
            'form_params' => $userData
        ]);

        $result = json_decode((string) $response->getBody(), true);

        return !empty($result['result']) && strtolower($result['result']) === 'ok' && !empty($result['sid'])
            ? $result['sid'] : null;
    }
}
