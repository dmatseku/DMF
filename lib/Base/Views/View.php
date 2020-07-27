<?php


namespace   lib\Base\Views;


use lib\Base\Http\Response;
use lib\Base\Prelang\Prelang;
use lib\Base\Support\Config;
use lib\Base\Support\Session;
use lib\Base\Views\Errors\UnhandlingException;

class   View extends Response
{
    protected   $path;
    protected   $processing;

    public function     __construct($path)
    {
        $this->processing = !empty(preg_match('/^.*\.prelang\s*$/', $path));

        if (!is_string($path)) {
            throw new \RuntimeException('Invalid path to view', 500);
        }

        if (!$this->processing) {
            $this->path = preg_replace('/@view/', Session::get('DIR', '').'app/Views', $path);
            $this->path = preg_replace('/@libView/', Session::get('DIR', '').'lib/Base/Views', $this->path).'.php';

            if (!file_exists($this->path) || !is_file($this->path)) {
                throw new \RuntimeException('View "'.$path.'" not found', 500);
            }
        } else {
            $this->path = $path;
        }
    }

    public function     run()
    {
        if (!$this->processing) {
            $this->loadSimplePage();
        } else {
            $this->loadPrelangPage();
        }
    }

    protected function  loadSimplePage()
    {
        extract($this->args, EXTR_OVERWRITE);

        require $this->path;
    }

    protected function  loadPrelangPage()
    {
        $prelang = new Prelang($this->args, Config::get('prelang', null, []));
        echo $prelang->process($this->path);
    }
}