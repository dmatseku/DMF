<?php


namespace   lib\Base\Views;


use lib\Base\Http\Response;
use Prelang\Prelang;
use lib\Base\Support\Config;
use lib\Base\Support\Session;
use lib\Base\Views\Errors\UnhandlingException;

class   View extends Response
{
    /**
     * @var string path to view file
     */
    private string    $path;
    /**
     * @var bool is file prelang
     */
    private bool      $processing;

    /**
     * View constructor.
     *
     * @param string $path
     */
    public function     __construct(string $path)
    {
        $this->processing = !empty(preg_match('/\.prelang\.php\s*$/', $path));

        if (!is_string($path)) {
            throw new \RuntimeException('Invalid path to view', 500);
        }

        $this->path = $path;
    }

    /**
     * @inheritDoc
     */
    public function     run(): void
    {
        if (!$this->processing) {
            $this->loadSimplePage();
        } else {
            $this->loadPrelangPage();
        }
    }

    /**
     * load page without preprocessing
     */
    protected function  loadSimplePage(): void
    {
        extract($this->args, EXTR_OVERWRITE);
        $path = preg_replace('/@view/', Session::get('DIR', '').'app/Views', $this->path);
        $path = preg_replace('/@libView/', Session::get('DIR', '').'lib/Base/Views', $path);

        if (!file_exists($path) || !is_file($path)) {
            throw new \RuntimeException('View "'.$path.'" not found', 500);
        }

        require $path;
    }

    /**
     * load page with preprocessing
     */
    protected function  loadPrelangPage(): void
    {
        extract($this->args, EXTR_OVERWRITE);

        $prelang = new Prelang(Config::get('prelang', null, []));
        eval("?>".$prelang->process($this->path)."<?php");
    }
}