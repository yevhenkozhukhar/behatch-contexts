<?php
declare(strict_types=1);

namespace Behatch\HttpCall;

use Behat\Mink\Mink;

class Request
{
    private Mink $mink;
    private $client;

    public function __construct(Mink $mink)
    {
        $this->mink = $mink;
    }

    /**
     * @param mixed $arguments
     * @return mixed
     */
    public function __call(string $name, $arguments)
    {
        return \call_user_func_array([$this->getClient(), $name], $arguments);
    }

    private function getClient(): Request\BrowserKit|Request\Goutte
    {
        if ($this->client === null) {
            if ('symfony2' === $this->mink->getDefaultSessionName()) {
                $this->client = new Request\Goutte($this->mink);
            } else {
                $this->client = new Request\BrowserKit($this->mink);
            }
        }

        return $this->client;
    }
}
