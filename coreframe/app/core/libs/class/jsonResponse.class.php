<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/22
 * Time: 10:52
 */
class WUZHI_jsonResponse
{
    function __construct()
    {
       // $this->setUtf8();
    }

    public function setUtf8()
    {
        header("Content-Type: application/json; charset=UTF-8");
    }
    public function set401()
    {
        header("HTTP/1.1 401 Unauthorized");
    }
    public function set400()
    {
        header("HTTP/1.1 400 Bad Request");
    }
    public function set200()
    {
        header("HTTP/1.1 200 ok");
    }

    public  function json($data)
    {
        echo json_encode($data);
        exit;
    }

    public function exitJson($code, $message, $data = '')
    {
        $result = array(
            'code'    => $code,
            'msg'     => $message,
            'data'    => $data
        );
        echo json_encode($result);
        exit;
    }
    public function jsonOfStatus($code, $message, $data, $count="", $status=200)
    {
        $this->setUtf8();
        switch ($status)
        {
            case 200:
                $this->set200();
                break;
            case 401:
                $this->set401();
                break;
            case 400:
                $this->set400();
                break;

        }

        $result = array(
            'code'    => $code,
            'msg'     => $message,
            'count'   => $count,
            'data'    => $data,
        );

        echo json_encode($result);
        exit;
    }
}