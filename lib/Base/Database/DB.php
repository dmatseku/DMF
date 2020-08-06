<?php


namespace   lib\Base\Database;


use lib\Base\Support\Config;
use PDO;
use PDOStatement;

class   DB
{
    /**
     * @var PDO Connection object
     */
    private PDO $connect;

    /**
     * @var bool|PDOStatement Statement object
     */
    private     $query;

    /**
     * DB constructor. Creates connection and prepare statement
     *
     * @param string $query execution query
     * @param array $stmtOptions option for preparing statement
     */
    protected function      __construct(string $query, array $stmtOptions)
    {
        $db = Config::get('database', 'SQL', 'mysql');
        $driver = $db['DRIVER'];
        $host = $db['HOST'];
        $port = $db['PORT'];
        $other = $db['OTHER'];
        $dbName = $db['DATABASE_NAME'];
        $user = $db['USER'];
        $pass = $db['PASSWORD'];

        $this->connect = new PDO("$driver:host=$host;port=$port;dbname=$dbName;$other", $user, $pass);
        $this->query = $this->connect->prepare($query, $stmtOptions);
        if (!$this->query) {
            throw new \RuntimeException('Invalid query: '.$query, 500);
        }
    }

    /**
     * Create simple query
     *
     * @param string $query execution query
     * @param array $stmtOptions option for preparing statement
     *
     * @return static object of query
     */
    public static function  query(string $query, array $stmtOptions = [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY])
    {
        return new static($query, $stmtOptions);
    }

    /**
     * Create procedure query: CALL $procedure
     *
     * @param string $procedure execution procedure (without CALL)
     * @param array $stmtOptions
     *
     * @return static object of query
     */
    public static function  procedure(string $procedure, array $stmtOptions = [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY])
    {
        return new static("CALL $procedure", $stmtOptions);
    }

    /**
     * @param array $params arguments for query
     * @param string $modelName name of class for result
     *
     * @return array array of results. if modelName is not null, then it's array of object. Otherwise it's simple array
     */
    public function         execute(array $params = null, string $modelName = null)
    {
        if (!$this->query->execute($params)) {
            throw new \RuntimeException('Query execute error', 500);
        }

        if ($modelName === null) {
            return $this->query->fetchAll();
        }
        return $this->query->fetchAll(PDO::FETCH_CLASS, $modelName);
    }
}