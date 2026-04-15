<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class StructuredRemittanceInformation
{
    private ?CreditorReferenceInformation $creditorReferenceInformation = null;

    private ?string $additionalRemittanceInformation = null;

    /**
     * @var string[]
     */
    private array $additionalRemittanceInformations = [];

    public function getAdditionalRemittanceInformation(): ?string
    {
        return $this->additionalRemittanceInformation;
    }

    public function setAdditionalRemittanceInformation(?string $additionalRemittanceInformation): void
    {
        $this->additionalRemittanceInformation = $additionalRemittanceInformation;
        $this->additionalRemittanceInformations = $additionalRemittanceInformation !== null
            ? [$additionalRemittanceInformation]
            : [];
    }

    /**
     * @return string[]
     */
    public function getAdditionalRemittanceInformations(): array
    {
        return $this->additionalRemittanceInformations;
    }

    /**
     * @param string[] $additionalRemittanceInformations
     */
    public function setAdditionalRemittanceInformations(array $additionalRemittanceInformations): void
    {
        $this->additionalRemittanceInformations = $additionalRemittanceInformations;
        $this->additionalRemittanceInformation = $additionalRemittanceInformations[0] ?? null;
    }

    public function getCreditorReferenceInformation(): ?CreditorReferenceInformation
    {
        return $this->creditorReferenceInformation;
    }

    public function setCreditorReferenceInformation(?CreditorReferenceInformation $creditorReferenceInformation): void
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
    }
}
