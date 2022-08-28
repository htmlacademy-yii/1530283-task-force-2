<?php

namespace TaskForce\services;

use SplFileObject;

class InsertSQLConverter implements SQLConverter
{
    static private function sanitizeValue(string $value): string
    {
        return preg_replace(
            '/[\x{200B}-\x{200D}\x{FEFF}]/u',
            '',
            $value
        );
    }

    public function convert(
        SplFileObject $sourceFile,
        SplFileObject $targetFile
    ): void {
        $currentLine = $this->readNextLine($sourceFile);

        $this->startWriting($sourceFile, $targetFile, $currentLine);

        $currentLine = $this->readNextLine($sourceFile);

        while ($this->isCurrentLine($currentLine)) {
            $this->writeValues($targetFile, $currentLine);
            $currentLine = $this->readNextLine($sourceFile);

            if ($this->isCurrentLine($currentLine)) {
                $this->writeValueDivider($targetFile);
            }
        }

        $this->endWriting($targetFile);
    }

    private function readNextLine(SplFileObject $sourceFile): array|null|false
    {
        return $sourceFile->fgetcsv();
    }

    private function write(SplFileObject $targetFile, string $value): void
    {
        $targetFile->fwrite($value);
    }

    private function startWriting(
        SplFileObject $sourceFile,
        SplFileObject $targetFile,
        array $currentLine
    ): void {
        $this->write(
            $targetFile,
            "INSERT INTO {$this->getTableName($sourceFile)} ({$this->getTableRows($currentLine)})
VALUES 
"
        );
    }

    private function writeValues(SplFileObject $targetFile, array $currentLine): void
    {
        $this->write($targetFile, "   ({$this->getValues($currentLine)})");
    }

    private function writeValueDivider(SplFileObject $targetFile): void
    {
        $this->write($targetFile, ",\n");
    }

    private function endWriting(SplFileObject $targetFile): void
    {
        $this->write($targetFile, ";\n");
    }

    private function getTableName(SplFileObject $sourceFile): string
    {
        return explode('.', $sourceFile->getFilename())[0];
    }

    private function getTableRows(array $currentLine): string
    {
        return implode(
            ', ',
            array_map(
                function ($value) {
                    return self::sanitizeValue($value);
                },
                $currentLine
            )
        );
    }

    private function getValues(array $currentLine): string
    {
        return implode(
            ', ',
            array_map(
                function ($value) {
                    $sanitizedValue = self::sanitizeValue($value);

                    return "'$sanitizedValue'";
                },
                $currentLine
            )
        );
    }

    private function isCurrentLine(array $currentLine): bool
    {
        return is_array($currentLine)
               && count(
                   array_filter($currentLine)
               );
    }
}
