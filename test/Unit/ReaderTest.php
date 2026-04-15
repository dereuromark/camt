<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use DOMDocument;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Config;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\ReaderException;
use Genkgo\Camt\Reader;
use PHPUnit\Framework;
use PHPUnit\Framework\Attributes\DataProvider;

class ReaderTest extends Framework\TestCase
{
    protected function getDefaultConfig(): Config
    {
        $config = new Config();
        $config->addMessageFormat(new MessageFormat\V02());

        return $config;
    }

    public function testReadEmptyDocument(): void
    {
        $this->expectException(ReaderException::class);
        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom(new DOMDocument('1.0', 'UTF-8'));
    }

    public function testReadWrongFormat(): void
    {
        $this->expectException(ReaderException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $root = $dom->createElement('Document');
        $root->setAttribute('xmlns', 'unknown');
        $dom->appendChild($root);

        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom($dom);
    }

    public function testReadFile(): void
    {
        $reader = new Reader(Config::getDefault());
        $message = $reader->readFile('test/data/camt053.v2.minimal.xml');
        self::assertInstanceOf(DTO\Message::class, $message);
    }

    public function testReadFileWithNoXsdValidation(): void
    {
        $config = Config::getDefault();
        $config->disableXsdValidation();

        $reader = new Reader($config);
        $message = $reader->readFile('test/data/camt053.v2.minimal.xml');
        self::assertInstanceOf(DTO\Message::class, $message);
    }

    #[DataProvider('providerCompatibleNamespaces')]
    public function testReadCompatibleNewerFormatNamespace(
        string $file,
        string $fromNamespace,
        string $toNamespace,
        string $expectedMsgId
    ): void {
        $xml = file_get_contents($file);
        self::assertNotFalse($xml);

        $xml = str_replace($fromNamespace, $toNamespace, $xml);

        $reader = new Reader(Config::getDefault());
        $message = $reader->readString($xml);

        self::assertInstanceOf(DTO\Message::class, $message);
        self::assertSame($expectedMsgId, $reader->getMessageFormat()?->getMsgId());
    }

    public static function providerCompatibleNamespaces(): iterable
    {
        yield 'camt052-v10' => [
            'test/data/camt052.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.052.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.052.001.10',
            'camt.052.001.10',
        ];
        yield 'camt052-v11' => [
            'test/data/camt052.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.052.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.052.001.11',
            'camt.052.001.11',
        ];
        yield 'camt053-v10' => [
            'test/data/camt053.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.053.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.053.001.10',
            'camt.053.001.10',
        ];
        yield 'camt053-v11' => [
            'test/data/camt053.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.053.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.053.001.11',
            'camt.053.001.11',
        ];
        yield 'camt054-v10' => [
            'test/data/camt054.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.054.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.054.001.10',
            'camt.054.001.10',
        ];
        yield 'camt054-v11' => [
            'test/data/camt054.v8.xml',
            'urn:iso:std:iso:20022:tech:xsd:camt.054.001.08',
            'urn:iso:std:iso:20022:tech:xsd:camt.054.001.11',
            'camt.054.001.11',
        ];
    }
}
