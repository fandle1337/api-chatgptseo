<?php

namespace App\Service\Payment;

class MiddlewarePaymentProviderUrl
{
    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    private $lastRequest;

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function __invoke(\Psr\Http\Message\RequestInterface $request)
    {
        return $this->lastRequest = $request;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return string
     */
    public function getFinalUrl()
    {
        return $this->lastRequest->getUri()->__toString();
    }
}
