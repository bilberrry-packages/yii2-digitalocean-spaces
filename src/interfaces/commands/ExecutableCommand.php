<?php

namespace bilberrry\spaces\interfaces\commands;

/**
 * Interface ExecutableCommand
 *
 * @package bilberrry\spaces\interfaces\commands
 */
interface ExecutableCommand extends Command
{
    /**
     * @return mixed
     */
    public function execute();
}
