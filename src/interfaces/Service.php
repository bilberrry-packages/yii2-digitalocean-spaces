<?php

namespace bilberrry\spaces\interfaces;

use bilberrry\spaces\interfaces\commands\Command;

/**
 * Interface Service
 *
 * @package bilberrry\spaces\interfaces
 */
interface Service
{
    /**
     * @param \bilberrry\spaces\interfaces\commands\Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);

    /**
     * @param string $commandClass
     *
     * @return \bilberrry\spaces\interfaces\commands\Command
     */
    public function create(string $commandClass): Command;
}
