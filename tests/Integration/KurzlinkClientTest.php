<?php
declare(strict_types=1);

namespace Robertfausk\KurzlinkApiClient\Tests\Integration;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Robertfausk\KurzlinkApiClient\KurzlinkClient;

/*
 * This file is part of the Robertfausk\KurzlinkApiClient.
 * (c) Robert Freigang <robertfreigang@gmx.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class KurzlinkClientTest extends TestCase
{
    /** @var string $kurzlinkAddress */
    private $kurzlinkAddress = 't1p.de';
    /** @var string $apiKey */
    private $apiKey;

    public function setUp(): void
    {
        $this->apiKey = $_ENV['apiKey'];
        parent::setUp();
    }

    public function test_simple_request(): void
    {
        $client = KurzlinkClient::create($this->apiKey, $this->kurzlinkAddress, true);
        $urlToShorten = 'https://google.de/';
        $shortUrl = $client->request($urlToShorten);
        Assert::assertIsString($shortUrl);
        Assert::stringStartsWith('https://t1p.de/');
    }

    public function test_request_with_desired_parameter(): void
    {
        $client = KurzlinkClient::create($this->apiKey, $this->kurzlinkAddress, true);
        $urlToShorten = 'https://google.de/';
        $requestParams = ['requesturl' => 'testen123'];
        $shortUrl = $client->request($urlToShorten, $requestParams);
        Assert::assertIsString($shortUrl);
        Assert::assertIsString('https://t1p.de/testen123');
    }

    public function test_request_with_another_domain(): void
    {
        $client = KurzlinkClient::create($this->apiKey, 'ogy.de', true);
        $urlToShorten = 'https://google.de/';
        $shortUrl = $client->request($urlToShorten);
        Assert::assertIsString($shortUrl);
        Assert::stringStartsWith('https://ogy.de/');
    }
}
