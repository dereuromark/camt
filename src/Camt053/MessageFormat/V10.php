<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt053\MessageFormat;

use Genkgo\Camt\CompatibilityDecoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

final class V10 implements MessageFormatInterface
{
    public function getXmlNs(): string
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.10';
    }

    public function getMsgId(): string
    {
        return 'camt.053.001.10';
    }

    public function getName(): string
    {
        return 'BankToCustomerStatementV10';
    }

    public function getDecoder(): DecoderInterface
    {
        return new CompatibilityDecoder((new V08())->getDecoder());
    }
}
