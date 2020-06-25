<?php
declare(strict_types=1);

namespace App\Controller;

use Aws\DynamoDb\Exception\DynamoDbException;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Github Controller
 *
 */
class GithubController extends AppController
{
    private string $hashBabyHash = 'whatislovebabydonthurtme';

    private string $curlGithubUrl = '';

    private string $curlGithubToken = '';

    private array $curlGithubHeaders = [];

    private array $curlGithubPostdata = [];

    private bool $isPostJson = false;

    private Client $http;

    public function initialize(): void
    {
        parent::initialize();
        $this->setCurlGithubHeaders('User-Agent: jdecode');
        $this->http = new Client();
    }

    public function getGithubUrl()
    {
        $url = 'https://github.com/login/oauth/authorize?'
            . 'client_id=' . Configure::read('oauth.github.CLIENT_ID')
            . '&redirect_uri=' . Configure::read('oauth.github.REDIRECT_URI')
            . '&state=' . $this->hashBabyHash
            . '&scope=' . $this->getScopes();
        return $this->redirect($url);
    }

    private function getScopes()
    {
        $scopes = [
            'user:email'
        ];
        return implode(' ', $scopes);
    }

    public function callback()
    {
        $github_return = $this->request->getQueryParams();
        if (isset($github_return['code']) && strlen(trim($github_return['code']))) {
            $postvars = [
                'code' => $github_return['code'],
                'client_id' => Configure::read('oauth.github.CLIENT_ID'),
                'client_secret' => Configure::read('oauth.github.CLIENT_SECRET'),
                'redirect_uri' => Configure::read('oauth.github.REDIRECT_URI'),
                'state' => $this->hashBabyHash
            ];
            $this->curlGithubUrl = 'https://github.com/login/oauth/access_token';
            $this->setCurlGithubPost($postvars);
            $token = $this->token($this->getAccessTokenFromParams($this->curlGithub()));
            return $this->redirect(Router::url('/app?token=') . $token);
        }
        return $github_return;
    }

    private function getAccessTokenFromParams($params, $key = null)
    {
        $key = $key ?? 'access_token';
        $_params = explode('&', $params);
        foreach ($_params as $_param) {
            if (stristr($_param, $key.'=')) {
                $val =  explode('=', $_param);
                return $val[1];
            }
        }
        return '';
    }

    private function curlGithub()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->curlGithubUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getCurlGithubHeaders());
        if (count($this->curlGithubPostdata)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($this->isPostJson) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->curlGithubPostdata));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($this->curlGithubPostdata));
            }
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function setCurlGithubHeaders(String $header)
    {
        $this->curlGithubHeaders[] = $header;
    }

    private function setCurlGithubPost(array $postvars)
    {
        if (!count($this->curlGithubPostdata)) {
            $this->curlGithubPostdata = $postvars;
            return;
        }
        $this->curlGithubPostdata[] = $postvars;
    }

    /**
     * @return array
     */
    private function getCurlGithubHeaders()
    {
        if (strlen(trim($this->curlGithubToken))) {
            $this->setCurlGithubHeaders('Authorization: Bearer ' . $this->curlGithubToken);
        }
        return $this->curlGithubHeaders;
    }

    public function oauth()
    {
        return $this->redirect($this->getGithubUrl());
    }

    private function userInfo(string $access_token)
    {
        $ccn = curl_init();

        curl_setopt($ccn, CURLOPT_URL, 'https://api.github.com/user');
        curl_setopt($ccn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ccn, CURLOPT_HTTPHEADER, array(
            'User-Agent: jdecode',
            "Authorization: token {$access_token}"
        ));

        $info = curl_exec($ccn);
        curl_close($ccn);
        return $info;
    }
    private function token($access_token)
    {
        $user = json_decode($this->userInfo($access_token), true);
        $identity = [
            'id_entity' => Text::uuid(),
            'email' => $user['email'],
            'github' => [
                'name' => $user['name'],
                'login' => $user['login'],
                'nodeid' => $user['node_id'],
                'photo' => $user['avatar_url']
            ],
            'active' => true,
            'created' => time()
        ];

        $token = [
            'token' => Text::uuid(),
            'id_entity' => $identity['id_entity'],
            'active' => true,
            'created' => time(),
            'last_active' => time(),
            'source' => 'github',
        ];

        try {
            $params = [
                'TableName' => 'users',
                'KeyConditionExpression' => "email = :email",
                'ExpressionAttributeValues' => [
                    ':email' => [
                        'S' => $identity['email']
                    ]
                ],
                'Limit' => 1
            ];
            $resp = $this->dynamoDb->query($params);
            if (!$resp['Count']) {
                $this->pda->insert('users', array_keys($identity), [array_values($identity)]);
                $this->pda->insert('tokens', array_keys($token), [array_values($token)]);
            }
            if ($resp['Count']) {
                $token['id_entity'] = $resp['Items'][0]['id_entity']['S'];
                $this->pda->insert('tokens', array_keys($token), [array_values($token)]);
            }
            return $token['token'];
        } catch (DynamoDbException $DynamoDbException) {
            dd($DynamoDbException);
        }
    }
}
