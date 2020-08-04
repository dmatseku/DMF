<?php


namespace   lib\Base\Http;


use lib\Base\Support\Session;

class   Request
{
    /**
     * @var array|mixed|null input array
     */
    private         $input;
    /**
     * @var string url
     */
    private string  $url;
    /**
     * @var string AJAX/Default
     */
    private string  $requestType = 'default';
    /**
     * @var string GET/POST
     */
    private string  $requestMethod;

    /**
     * Request constructor. initialize request from input
     *
     * @param string $requestMethod GET/POST
     * @param string $url
     */
    public function __construct(string $requestMethod, string $url)
    {
        $this->requestMethod = $requestMethod;
        $this->input = Session::get('redirectInput', []);

        switch ($requestMethod) {
            case 'GET':
            case 'get':
                $this->input += !empty($_GET) ? $_GET : [];
                break;
            case 'POST':
            case 'post':
                $this->input += !empty($_POST) ? $_POST : [];
                break;
        }

        $this->url = $url;

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->requestType = 'ajax';
        }
    }

    /**
     * request is ajax or not
     *
     * @return bool
     */
    public function ajax(): bool
    {
        return $this->requestType === 'ajax';
    }

    /**
     * get all input
     *
     * @return array|mixed|null
     */
    public function all()
    {
        return $this->input;
    }

    /**
     * get input argument
     *
     * @param mixed $key argument name
     * @param mixed $alt return if argument not found
     *
     * @return mixed
     */
    public function getInput($key, $alt)
    {
        if (isset($this->input[$key])) {
            return $this->input[$key];
        }
        return $alt;
    }

    /**
     * get request url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * get request method
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }
}