<?php

namespace bilberrry\spaces\handlers;

use bilberrry\spaces\base\handlers\Handler;
use bilberrry\spaces\commands\GetPresignedUrlCommand;

/**
 * Class GetPresignedUrlCommandHandler
 *
 * @package bilberrry\spaces\handlers
 */
final class GetPresignedUrlCommandHandler extends Handler
{
    /**
     * @param \bilberrry\spaces\commands\GetPresignedUrlCommand $command
     *
     * @return string
     */
    public function handle(GetPresignedUrlCommand $command): string
    {
        $awsCommand = $this->s3Client->getCommand('GetObject', $command->getArgs());
        $request = $this->s3Client->createPresignedRequest($awsCommand, $command->getExpiration());

        return (string)$request->getUri();
    }
}
