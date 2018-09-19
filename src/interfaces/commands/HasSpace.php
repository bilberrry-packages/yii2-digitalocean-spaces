<?php

namespace bilberrry\spaces\interfaces\commands;

/**
 * Interface HasSpace
 *
 * @package bilberrry\spaces\interfaces\commands
 */
interface HasSpace
{
    /**
     * @param string $name
     */
    public function inSpace(string $name);
}
