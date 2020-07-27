<?php


namespace   lib\Base\Http;

use         lib\Base\Http\Response;

class   JsonResponse extends Response
{
    public function run()
    {
        $data = json_encode($this->args);

        if (!$data) {
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    throw new \RuntimeException('Json error: depth', 500);
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    throw new \RuntimeException('Json error: state mismatch', 500);
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    throw new \RuntimeException('Json error: ctrl char', 500);
                    break;
                case JSON_ERROR_SYNTAX:
                    throw new \RuntimeException('Json error: syntax error', 500);
                    break;
                case JSON_ERROR_UTF8:
                    throw new \RuntimeException('Json error: utf-8', 500);
                    break;
                default:
                    throw new \RuntimeException('Json undefined error', 500);
                    break;
            }
        }

        header_remove();
        header('Content-type:application/json;charset=utf-8', true, 200);
        echo $data;
        exit;
    }
}