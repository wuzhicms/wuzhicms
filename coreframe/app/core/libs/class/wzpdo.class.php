<?php
defined('IN_WZ') or exit('No direct script access allowed');
require WWW_ROOT . 'vendor/autoload.php';
use Doctrine\DBAL\DriverManager;
class WUZHI_wzpdo
{
    private $pdoConfig;
    private $conn;

    function __construct()
    {
        $this->pdoConfig = get_config('pdo_mysql');
        $this->conn = DriverManager::getConnection($this->pdoConfig['default']);
    }

    public function queryBuilder()
    {
        return $this->conn->createQueryBuilder();
    }


}