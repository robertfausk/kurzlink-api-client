# KurzlinkApiClient
[![Latest Stable Version](https://poser.pugx.org/robertfausk/kurzlink-api-client/v/stable.svg)](https://packagist.org/packages/robertfausk/kurzlink-api-client)
[![Latest Unstable Version](https://poser.pugx.org/robertfausk/kurzlink-api-client/v/unstable.svg)](https://packagist.org/packages/robertfausk/kurzlink-api-client)
[![Total Downloads](https://poser.pugx.org/robertfausk/kurzlink-api-client/downloads.svg)](https://packagist.org/packages/robertfausk/kurzlink-api-client)
[![Build Status](https://travis-ci.com/robertfausk/kurzlink-api-client.svg?branch=master)](https://travis-ci.com/robertfausk/kurzlink-api-client)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/robertfausk/kurzlink-api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/kurzlink-api-client/)
[![Code Coverage](https://scrutinizer-ci.com/g/robertfausk/kurzlink-api-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/kurzlink-api-client/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP7 Compatible](https://img.shields.io/travis/php-v/robertfausk/kurzlink-api-client/master?style=flat-square)
[![Open Issues](https://img.shields.io/github/issues-raw/robertfausk/kurzlink-api-client?style=flat-square)](https://github.com/robertfausk/kurzlink-api-client/issues)
[![Closed Issues](https://img.shields.io/github/issues-closed-raw/robertfausk/kurzlink-api-client?style=flat-square)](https://github.com/robertfausk/kurzlink-api-client/issues?q=is%3Aissue+is%3Aclosed)
[![Contributors](https://img.shields.io/github/contributors/robertfausk/kurzlink-api-client?style=flat-square)](https://github.com/robertfausk/kurzlink-api-client/graphs/contributors)
![Contributors](https://img.shields.io/maintenance/yes/2020?style=flat-square)

Very simple api client written in PHP for url shortener kurzelinks.de which supports ogy.de, t1p.de,
0cn.de, kurzelinks.de and also own domains. 

## Install

    composer require --dev robertfausk/kurzlink-api-client

Usage Example
-------------

```PHP
<?php

use Robertfausk\KurzlinkApiClient\KurzlinkClient;

$apiKey = 'your secret api key';
$kurzlinkAddress = 't1p.de';
$useSandbox = true;
$client = KurzlinkClient::create($apiKey, $kurzlinkAddress, $useSandbox);
$urlToShorten = 'https://google.de/';
$requestParams = [  // feel free to use every param from api doc
    'requesturl' => '',
];
$shortUrl = $client->request($urlToShorten, $requestParams);
```

### How to upgrade?

 Have a look at [CHANGELOG](CHANGELOG.md) for detailed information.

## How to contribute?

Copy phpunit.xml.dist and insert your api key to be able to run the integration tests.

Start docker-compose with php web driver

    docker-compose up php7.2

Run phpunit tests

    docker-compose exec php7.2 vendor/bin/phpunit


## Credits

Created by Robert Freigang [robertfausk](https://github.com/robertfausk).
