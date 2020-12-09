<?php
declare(strict_types=1);

namespace Robertfausk\KurzlinkApiClient\Exception;

class Exception extends \Exception
{
    public function __construct(array $content) {
        parent::__construct($content['messages']['error'] ?? 'No error message in response.');
    }
}
