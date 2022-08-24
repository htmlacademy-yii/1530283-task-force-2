<?php

namespace TaskForce\services;

use SplFileObject;

interface SQLConverter
{
    public function convert(
        SplFileObject $sourceFile,
        SplFileObject $targetFile
    ): void;
}
