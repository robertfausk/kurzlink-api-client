<?php
declare(strict_types=1);

namespace Robertfausk\KurzlinkApiClient\Exception;

class UnexpectedResponseException extends Exception
{
    public function __construct(array $content)
    {
        $content['messages']['error'] ? $content['messages']['error'] : 'Response has unknown format.';
        parent::__construct($content);
    }
}
