<?php


namespace lib\Base\Http;


class Csrf
{
    /**
     * @var int|null generated token index
     */
    private static ?string  $token = null;

    /**
     * remove all the old tokens
     */
    private static function update(): void
    {
        $now = new \DateTime();
        foreach($_SESSION['csrf'] as $key => $limit) {
            if ($limit < $now) {
                unset($_SESSION['csrf'][$key]);
            }
        }
    }

    /**
     * create and save token
     *
     * @return string token
     * @throws \Exception
     */
    private static function create(): string
    {
        $time = new \DateTime();
        $time->modify('+30 minutes');
        $token = hash('sha256', random_bytes(32));

        $_SESSION['csrf'][$token] = $time;
        return $token;
    }

    /**
     * get request token. create if not exists
     *
     * @return string token
     * @throws \Exception
     */
    public static function  generate(): string
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = [];
        }
        self::update();

        if (self::$token === null) {
            self::$token = self::create();
        }

        return self::$token;
    }

    /**\
     * check the existence and relevance of the token
     *
     * @param string $token
     */
    public static function  check(string $token): void
    {
        if (!isset($_SESSION['csrf'][$token])) {
            throw new \RuntimeException('Request refused', 409);
        }

        if ($_SESSION['csrf'][$token] < new \DateTime()) {
            throw new \RuntimeException('Request time out', 408);
        }
    }

    public static function  isUnsafe($requestMethod) {
        switch ($requestMethod) {
            case 'GET':
            case 'get':
            case 'HEAD':
            case 'head':
            case 'OPTIONS':
            case 'options':
            case 'TRACE':
            case 'trace':
                return false;
        }

        return true;
    }
}