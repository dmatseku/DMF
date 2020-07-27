<?php


namespace   lib\Base\Prelang;


use SplDoublyLinkedList;

class   Prelang
{
    use ViewArgs;

    protected static    $dir = '';
    protected           $handlers = [];
    protected           $orderBefore = [];
    protected           $orderAfter = [];
    protected           $orderFinish = [];

    public function         __construct(&$args, $config)
    {
        if (is_array($args)) {
            $this->args = &$args;
        }

        if (isset($config['handlers'])) {
            $this->handlers = Handler::createArray($args, $config['handlers'], $config['appSpace'], $config['selfSpace']);
        }

        if (isset($config['before'])) {
            $this->orderBefore = $config['before'];
        }
        if (isset($config['after'])) {
            $this->orderAfter = $config['after'];
        }
        if (isset($config['finish'])) {
            $this->orderFinish = $config['finish'];
        }

        if (isset($config['viewDir'])) {
            self::$dir = $config['viewDir'];
        }
    }

    public static function  getPage($pageName)
    {
        if ($pageName !== false) {
            $page = self::$dir.'/'.$pageName.'.php';

            ob_start();
            if (file_exists($page) || is_file($page)) {
                require $page;
                return ob_get_clean();
            }
            throw new \RuntimeException('View not found', 500);
        }
        return false;
    }

    public function         process($view)
    {
        $pageList = new SplDoublyLinkedList();
        $views = [];

        while ($page = self::getPage($view)) {
            $this->before($page);
            $pageList->push($page);

            if (preg_match('/@use\s*\(\s*\'\s*(.+)\s*\'\s*\)/', $page, $matches) && isset($views[$matches[1]])) {
                $view = $matches[1];
                $views[$matches[1]] = 1;
            } else {
                $view = false;
            }
        }

        $result = $pageList->isEmpty() ? '' : $pageList->pop();

        while (!$pageList->isEmpty()) {
            $page = $pageList->pop();
            $this->after($result, $page);
        }

        $this->finish($result);
        preg_replace('/@use\s*\(\s*\'\s*(.*)\s*\'\s*\)/', '', $page);

        ob_start();
        eval(" ?>".$result."<?php ");
        $result = ob_get_clean();
        foreach ($this->handlers as $handler) {
            $handler->clean($result);
        }
        return $result;
    }

    private function        before(&$page)
    {
            foreach ($this->orderBefore as $handler => $macros) {
                $handler = $this->handlers[$handler];
                $pattern = $handler->pattern();

                if (preg_match_all($pattern, $page, $matches, PREG_OFFSET_CAPTURE|PREG_SET_ORDER)) {
                    $handler->before($page, $matches, $macros);
                }
            }
    }

    private function        after(&$result, &$page)
    {
        foreach ($this->orderAfter as $handler => $macros) {
            $handler = $this->handlers[$handler];
            $pattern = $handler->pattern();

            $resultMatches = [];
            $pageMatches = [];

            if (preg_match_all($pattern, $result, $resultMatches, PREG_OFFSET_CAPTURE|PREG_SET_ORDER) ||
                preg_match_all($pattern, $page, $pageMatches, PREG_OFFSET_CAPTURE)) {
                $handler->after($result, $page, $resultMatches, $pageMatches, $macros);
            }
        }
    }

    private function        finish(&$result)
    {
        foreach ($this->orderFinish as $handler => $macros) {
            $handler = $this->handlers[$handler];
            $pattern = $handler->pattern();

            if (preg_match_all($pattern, $result, $matches, PREG_OFFSET_CAPTURE|PREG_SET_ORDER)) {
                $handler->finish($result, $matches, $macros);
            }
        }
    }
}