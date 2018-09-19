<?php

namespace bilberrry\spaces\interfaces;

use bilberrry\spaces\interfaces\commands\Command;
use bilberrry\spaces\interfaces\handlers\Handler;

/**
 * Interface HandlerResolver
 *
 * @package bilberrry\spaces\interfaces
 */
interface HandlerResolver
{
    /**
     * @param \bilberrry\spaces\interfaces\commands\Command $command
     *
     * @return \bilberrry\spaces\interfaces\handlers\Handler
     */
    public function resolve(Command $command): Handler;

    /**
     * @param string $commandClass
     * @param mixed  $handler
     */
    public function bindHandler(string $commandClass, $handler);
}
