<?php

namespace bilberrry\spaces\handlers;

use bilberrry\spaces\base\handlers\Handler;
use bilberrry\spaces\commands\ExistCommand;

/**
 * Class ExistCommandHandler
 *
 * @package bilberrry\spaces\handlers
 */
final class ExistCommandHandler extends Handler
{
    /**
     * @param \bilberrry\spaces\commands\ExistCommand $command
     *
     * @return bool
     */
    public function handle(ExistCommand $command): bool
    {
        return $this->s3Client->doesObjectExist(
            $command->getSpace(),
            $command->getFilename(),
            $command->getOptions()
        );
    }
}
