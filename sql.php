<?php

require_once 'init/common.php';
require_once 'vendor/autoload.php';

use TaskForce\services\InsertSQLConverter;
use TaskForce\services\SQLGenerator;

const SOURCE_DIRECTORY = 'data';
const TARGET_DIRECTORY = 'queries';

$sourceDirectoryIterator =
    new FilesystemIterator(SOURCE_DIRECTORY, FilesystemIterator::SKIP_DOTS);

$insertQueryConverter = new InsertSQLConverter();

$dirRecorder = new SQLGenerator(
    $sourceDirectoryIterator,
    $insertQueryConverter,
    TARGET_DIRECTORY
);

$dirRecorder->generate();
