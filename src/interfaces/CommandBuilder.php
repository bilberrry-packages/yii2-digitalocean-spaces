<?php

namespace bilberrry\spaces\interfaces;

use bilberrry\spaces\interfaces\commands\Command;

/**
 * Interface CommandBuilder
 *
 * @package bilberrry\spaces\interfaces
 */
interface CommandBuilder
{
    /**
     * @param string $commandClass
     *
     * @return \bilberrry\spaces\interfaces\commands\Command
     */
    public function build(string $commandClass): Command;
}
