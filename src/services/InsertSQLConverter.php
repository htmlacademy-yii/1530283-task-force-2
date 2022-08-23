<?php

namespace TaskForce\services;

use SplFileObject;

class InsertSQLConverter implements SQLConverter
{
    private ?SplFileObject $targetFile = null;
    private ?SplFileObject $sourceFile = null;
    private array|null|false $currentLine = null;

    static private function sanitizeValue(string $value): string
    {
        return preg_replace(
            '/[\x{200B}-\x{200D}\x{FEFF}]/u',
            '',
            $value
        );
    }

    public function setSourceFile(SplFileObject $sourceFile): void
    {
        $this->sourceFile = $sourceFile;
        $this->readNextLine();
    }

    public function setTargetFile(SplFileObject $targetFile): void
    {
        $this->targetFile = $targetFile;
    }

    public function convert(): void
    {
        $this->startWriting();

        $this->readNextLine();

        while ($this->isCurrentLine()) {
            $this->writeValues();
            $this->readNextLine();

            if ($this->isCurrentLine()) {
                $this->writeValueDivider();
            }
        }

        $this->endWriting();
    }

    private function readNextLine(): void
    {
        $this->currentLine = $this->sourceFile->fgetcsv();
    }

    private function write(string $value): void
    {
        $this->targetFile->fwrite($value);
    }

    private function startWriting(): void
    {
        $this->write(
            "INSERT INTO {$this->getTableName()} ({$this->getTableRows()})
VALUES 
"
        );
    }

    private function writeValues(): void
    {
        $this->write("   ({$this->getValues()})");
    }

    private function writeValueDivider(): void
    {
        $this->write(",\n");
    }

    private function endWriting(): void
    {
        $this->write(";\n");
    }

    private function getTableName(): string
    {
        return explode('.', $this->sourceFile->getFilename())[0];
    }

    private function getTableRows(): string
    {
        return implode(
            ', ',
            array_map(
                function ($value) {
                    return self::sanitizeValue($value);
                },
                $this->currentLine
            )
        );
    }

    private function getValues(): string
    {
        return implode(
            ', ',
            array_map(
                function ($value) {
                    $sanitizedValue = self::sanitizeValue($value);

                    return "'$sanitizedValue'";
                },
                $this->currentLine
            )
        );
    }

    private function isCurrentLine(): bool
    {
        return is_array($this->currentLine)
               && count(
                   array_filter($this->currentLine)
               );
    }
}
