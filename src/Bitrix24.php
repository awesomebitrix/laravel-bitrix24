<?php
namespace Antsupovsa\Bitrix24;

use Bitrix24\CRM\Lead;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Arr;

class Bitrix24
{
    /**
     * Illuminate config repository instance.
     *
     * @var array
     */
    protected $config;

    /** @var \Bitrix24\Bitrix24 */
    protected $bitrix24;

    /**
     * Set api key and optionally API endpoint
     * @param      $config
     */
    public function __construct($config)
    {
        $this->config = $config;

        // init lib
        $this->bitrix24 = new \Bitrix24\Bitrix24();
        $this->bitrix24->setApplicationScope($this->makeScope($this->config('B24_APPLICATION_SCOPE')));
        $this->bitrix24->setApplicationId($this->config('B24_APPLICATION_ID'));
        $this->bitrix24->setApplicationSecret($this->config('B24_APPLICATION_SECRET'));

        if (!empty($this->config('DOMAIN'))) {
            $this->bitrix24->setDomain($this->config('DOMAIN'));
        }
        if (!empty($this->config('MEMBER_ID'))) {
            $this->bitrix24->setMemberId($this->config('MEMBER_ID'));
        }
        if (!empty($this->config('AUTH_ID'))) {

            $this->bitrix24->setAccessToken($this->config('AUTH_ID'));
        }
        if (!empty($this->config('REFRESH_ID'))) {
            $this->bitrix24->setRefreshToken($this->config('REFRESH_ID'));
        }
    }

    public function getAccessToken()
    {
        $client = new \GuzzleHttp\Client();

        $params = [
            'client_id' => $this->bitrix24->getApplicationId(),
            'response_type' => 'code',
            'redirect_uri' => $this->bitrix24->getRedirectUri(),
        ];

        $uri = 'http://'.$this->bitrix24->getDomain();
        $uri .= '/oauth/authorize/?';
        $uri .= \GuzzleHttp\Psr7\build_query($params);

        $client->request('GET', $uri, [
            'on_stats' => function (TransferStats $stats) {
                echo $stats->getEffectiveUri() . "\n";
                echo $stats->getTransferTime() . "\n";
                var_dump($stats->getHandlerStats());

                // You must check if a response was received before using the
                // response object.
                if ($stats->hasResponse()) {
                    echo $stats->getResponse()->getStatusCode();
                } else {
                    // Error data is handler specific. You will need to know what
                    // type of error data your handler uses before using this
                    // value.
                    var_dump($stats->getHandlerErrorData());
                }
            }
        ]);


        //$res = $client->request('GET', $url);
        $this->bitrix24->setAccessToken($url);
    }

    /**
     * @param $scope
     * @return array
     */
    public function makeScope($scope)
    {
        $scopes = explode(",", $scope);

        return $scopes;
    }

    /**
     * Add a new lead to CRM
     * @param array $fields array of fields
     * @param array $params Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in a lead in the Activity Stream.
     * The lead's Responsible person will also receive notification.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_add.php
     * @return array
     */
    public function addLead($fields = [], $params = [])
    {
        $lead = new Lead($this->bitrix24);

        $currentLead = $lead->add($fields, $params);

        return $currentLead;
    }

    /**
     * We can modify internal settings
     * @param $key
     * @param $value
     */
    function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }
}