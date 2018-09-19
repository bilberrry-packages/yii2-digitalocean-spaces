<?php

namespace bilberrry\spaces\interfaces;

use bilberrry\spaces\interfaces\commands\Command;

/**
 * Interface Bus
 *
 * @package bilberrry\spaces\interfaces
 */
interface Bus
{
    /**
     * @param \bilberrry\spaces\interfaces\commands\Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);
}
