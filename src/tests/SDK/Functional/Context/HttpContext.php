<?php declare(strict_types=1);

namespace Tests\SDK\Functional\Context;

use Behat\Behat\Context\Context;
use GuzzleHttp\Client;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class HttpContext implements Context
{
    private const PREFIX_REQUIRED_FOR_HTTP_HEADER = 'HTTP_';

    /** @var Application */
    private $app;

    /** @var UrlGenerator */
    private $urlGenerator;

    /** @var Response */
    private $response;

    /** @var Client */
    private $externalClient;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

}