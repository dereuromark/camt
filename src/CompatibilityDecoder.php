<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;

final class CompatibilityDecoder implements DecoderInterface
{
    public function __construct(private readonly DecoderInterface $decoder)
    {
    }

    public function decode(DOMDocument $document, bool $xsdValidation = true): Message
    {
        return $this->decoder->decode($document, false);
    }
}
