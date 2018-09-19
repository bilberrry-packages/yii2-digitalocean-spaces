<?php

namespace bilberrry\spaces\handlers;

use bilberrry\spaces\base\handlers\Handler;
use bilberrry\spaces\commands\GetUrlCommand;

/**
 * Class GetUrlCommandHandler
 *
 * @package bilberrry\spaces\handlers
 */
final class GetUrlCommandHandler extends Handler
{
    /**
     * @param \bilberrry\spaces\commands\GetUrlCommand $command
     *
     * @return string
     */
    public function handle(GetUrlCommand $command): string
    {
        return $this->s3Client->getObjectUrl($command->getSpace(), $command->getFilename());
    }
}
