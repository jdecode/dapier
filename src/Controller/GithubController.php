<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Routing\Router;

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
            return $this->redirect(Router::url('/app/dashboard?') . $this->getTokenFromParams($this->curlGithub()));
        }
        return $github_return;
    }

    private function getTokenFromParams($params)
    {
        $_params = explode('&', $params);
        foreach ($_params as $_param) {
            if (stristr($_param, 'access_token=')) {
                return $_param;
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

    public function getUserInfo(string $access_token)
    {
        $this->curlGithubToken = $access_token;
        $this->curlGithubUrl = 'https://api.github.com/user';
        return $this->curlGithub();
    }
}
