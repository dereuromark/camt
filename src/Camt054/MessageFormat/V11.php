<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt054\MessageFormat;

use Genkgo\Camt\CompatibilityDecoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

final class V11 implements MessageFormatInterface
{
    public function getXmlNs(): string
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.054.001.11';
    }

    public function getMsgId(): string
    {
        return 'camt.054.001.11';
    }

    public function getName(): string
    {
        return 'BankToCustomerDebitCreditNotificationV11';
    }

    public function getDecoder(): DecoderInterface
    {
        return new CompatibilityDecoder((new V08())->getDecoder());
    }
}
