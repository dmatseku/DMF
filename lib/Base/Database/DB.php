<?php


namespace   lib\Base\Database;


use lib\Base\Support\Config;
use PDO;

class   DB
{
    protected   $connect;
    protected   $query;

    protected function      __construct($query, $stmtOptions)
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
    }

    public static function  createQuery($query, $stmtOptions = null)
    {
        return new static($query, $stmtOptions ?? [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    }

    public static function  createProcedure($procedure, $stmtOptions = null)
    {
        $query = "CALL $procedure";

        return new static($query, $stmtOptions ?? [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    }

    public function         getResult($params = null, $modelName = null)
    {
        $this->query->execute($params);

        if (!$modelName) {
            return $this->query->fetchAll();
        }
        return $this->query->fetchAll(PDO::FETCH_CLASS, $modelName);
    }
}