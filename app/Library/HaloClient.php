<?php namespace App\Library;

use GuzzleHttp;

class HaloClient
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var int
     */
    public $cache;

    /**
     * @var GuzzleHttp\Client
     */
    public $client;

    /**
     * HaloClient constructor.
     * @param $path
     * @param null $cache
     */
    public function __construct($path, $cache = null)
    {
        $this->setPath($path);
        $this->cache = $cache;
        $this->client = new GuzzleHttp\Client();
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->url = config('leaf.endpoint') . $path;
    }

    /**
     * @param $minutes
     */
    public function setCache($minutes)
    {
        $this->cache = $minutes;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function request()
    {
        $sum = md5($this->url);
        
        if ($this->cache != 0 && \Cache::has($sum))
        {
            return \Cache::get($sum);
        }
        
        $res = $this->client->request('GET', $this->url);

        if ($res->getStatusCode() != 200)
        {
            throw new \Exception('API Offline or invalid.');
        }
        
        if ($this->cache != 0)
        {
            $operation = ($this->cache === -1) ? 'forever' : 'put';
            \Cache::$operation($sum, json_decode($res->getBody(), true, 512, JSON_BIGINT_AS_STRING), $this->cache);
        }
        
        return json_decode($res->getBody(), true, 512, JSON_BIGINT_AS_STRING);
    }
}