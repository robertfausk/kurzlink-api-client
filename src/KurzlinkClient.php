<?php
declare(strict_types=1);

/*
 * This file is part of the Robertfausk\KurzlinkApiClient.
 * (c) Robert Freigang <robertfreigang@gmx.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Robertfausk\KurzlinkApiClient;

use Robertfausk\KurzlinkApiClient\Exception\BadRequestException;
use Robertfausk\KurzlinkApiClient\Exception\Exception;
use Robertfausk\KurzlinkApiClient\Exception\ForbiddenException;
use Robertfausk\KurzlinkApiClient\Exception\LockedException;
use Robertfausk\KurzlinkApiClient\Exception\NoResponseException;
use Robertfausk\KurzlinkApiClient\Exception\TooManyRequestsException;
use Robertfausk\KurzlinkApiClient\Exception\UnexpectedResponseException;
use Symfony\Component\HttpClient\HttpClient;

final class KurzlinkClient
{
    /** @var array<string,mixed>  */
    private $config = [
        'json' => true,
    ];
    /** @var string */
    private $kurzlinkAddress;
    /** @var bool */
    private $useSandbox;
    /** @var int */
    private $apiVersion;
    /** @var string */
    private $apiKey;

    private function __construct(string $apiKey, string $kurzlinkAddress, bool $useSandbox)
    {
        $this->kurzlinkAddress = $kurzlinkAddress;
        $this->useSandbox = $useSandbox;
        $this->apiVersion = 21;
        if ($this->useSandbox) {
            $this->kurzlinkAddress .= '/sandbox';
        } else {
            $this->kurzlinkAddress .= '/api';
        }
        $this->apiKey = $apiKey;
    }

    public static function create(string $apiKey, string $kurzlinkAddress, bool $useSandbox = true): self
    {
        return new self($apiKey, $kurzlinkAddress, $useSandbox);
    }

    public function request(string $urlToShorten, ?array $requestParams = null): string
    {
        $client = HttpClient::create();

        $url = \sprintf(
            'https://%s',
            $this->kurzlinkAddress
        );

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-alive'
        ];

        $options = ['headers' => $headers];
        $options['body'] = $this->config;
        $options['body']['url'] = urldecode($urlToShorten);
        $options['body']['key'] = $this->apiKey;
        $options['body']['apiversion'] = $this->apiVersion;
        if ($requestParams) {
            $options['body'] = \array_merge($options['body'], $requestParams);
        }

        $response = $client->request('POST', $url, $options);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray(false);

        switch ($statusCode) {
            case 200:
                break;
            case 400:
                throw new BadRequestException($content);
            case 403:
                throw new ForbiddenException($content);
            case 423:
                throw new LockedException($content);
            case 429:
                throw new TooManyRequestsException($content);
            case 444:
                throw new NoResponseException($content);
            default:
                throw new Exception($content);
        }

        $shortUrl = $content['shorturl']['url'] ?? false;
        if (false === $shortUrl || !\is_string($shortUrl)) {
            throw new UnexpectedResponseException($content);
        }

        return $shortUrl;
    }

    public function getApiVersion(): int
    {
        return $this->apiVersion;
    }
}
