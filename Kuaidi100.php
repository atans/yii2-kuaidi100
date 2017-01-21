<?php

namespace atans\kuaidi100;

use common\components\GuzzleHttp\Cookie\CacheCookieJar;
use yii\base\Component;
use yii\httpclient\Client;

class Kuaidi100 extends Component
{
    const LOGIN_API = 'https://sso.kuaidi100.com//sso/login.do';

    public $account;
    public $password;

    /**
     * Login
     *
     * Response
     *   Headers: Location: https://sso.kuaidi100.com/
     *
     * @return bool
     */
    public function login()
    {
        $formParams = [
            'directlogin'  => '1',
            'data'         => '',
            'sign'         => '',
            'referer'      => '',
            'identifytype' => 'PASSWORD',
            'utype'        => 'BUYER',
            'isvalid'      => '',
            'name'         => $this->account,
            'password'     => $this->password,
            'validcode'    => '',
        ];

        $response = $this->getClient()
            ->createRequest()
            ->setUrl(self::LOGIN_API)
            ->setMethod('post')
            ->setOptions([
                'cookies' => $this->getCookieJar(),
                'form_params' => $formParams,
            ])
            ->send();

        return $response->getStatusCode() == 302 && strpos($response->getHeaders()->get('Location'), 'sso.kuaidi100.com') !== false;
    }

    /**
     * Get header
     *
     * @return array
     */
    public function getDefaultHeaders()
    {
        return [
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:46.0) Gecko/20100101 Firefox/46.0',
            'Referer'          => 'http://www.kuaidi100.com/user/login.shtml',
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
        ];
    }

    /**
     * Get cookie jar
     *
     * @return CacheCookieJar
     */
    protected function getCookieJar()
    {
        return new CacheCookieJar($this->account, true);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client([
            'cookies'  => true,
        ]);
    }
}