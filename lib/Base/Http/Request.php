<?php


namespace   lib\Base\Http;


use lib\Base\Support\Session;

class   Request
{
    private     $input;
    private     $url;
    protected   $requestType = 'default';
    private     $requestMethod;

    public function __construct($requestMethod, $url)
    {
        $this->requestMethod = $requestMethod;
        $this->input = Session::get('redirectInput', []);

        switch ($requestMethod) {
            case 'GET':
            case 'get':
                $this->input += !empty($_GET) ? $_GET : [];
                break;
            case 'post':
            case 'POST':
                $this->input += !empty($_POST) ? $_POST : [];
                break;
        }

        $this->url = $url;

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->requestType = 'ajax';
        }
    }

    public function ajax()
    {
        return $this->requestType === 'ajax';
    }

    public function all()
    {
        return $this->input;
    }

    public function getInput($key, $alt)
    {
        if (isset($this->input[$key])) {
            return $this->input[$key];
        }
        return $alt;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
}