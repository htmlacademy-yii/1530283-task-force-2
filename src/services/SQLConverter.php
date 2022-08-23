<?php

namespace TaskForce\services;

use SplFileObject;

interface SQLConverter
{
    public function setSourceFile(SplFileObject $file): void;

    public function setTargetFile(SplFileObject $file): void;

    public function convert(): void;
}
