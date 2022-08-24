<?php

namespace TaskForce\services;

use DirectoryIterator;
use SplFileObject;

class SQLGenerator
{
    private DirectoryIterator $sourceDirectoryIterator;
    private SQLConverter $queryConverter;
    private string $targetPath;
    private string $targetExtension;


    public function __construct(
        DirectoryIterator $sourceDirectoryIterator,
        SQLConverter $queryConverter,
        string $targetPath = '',
        string $targetExtension = '.sql'
    ) {
        $this->sourceDirectoryIterator = $sourceDirectoryIterator;
        $this->queryConverter = $queryConverter;
        $this->targetPath = $targetPath;
        $this->targetExtension = $targetExtension;
    }

    public function generate()
    {
        foreach ($this->sourceDirectoryIterator as $file) {
            $sourceFile = $file->openFile();
            $targetFile =
                new SplFileObject($this->getTargetFilePath($sourceFile), 'w');

            $this->queryConverter->convert($sourceFile, $targetFile);
        }
    }


    private function getTargetFileName(SplFileObject $sourceFile): string
    {
        return explode('.', $sourceFile->getFilename())[0]
               . $this->targetExtension;
    }

    private function getTargetFilePath(SplFileObject $sourceFile): string
    {
        return "{$this->targetPath}\\{$this->getTargetFileName($sourceFile)}";
    }

}
