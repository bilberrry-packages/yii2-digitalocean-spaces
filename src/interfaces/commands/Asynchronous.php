<?php

namespace bilberrry\spaces\interfaces\commands;

/**
 * Interface Asynchronous
 *
 * @package bilberrry\spaces\interfaces\commands
 */
interface Asynchronous
{
    /**
     * @return mixed
     */
    public function async();

    /**
     * @return bool
     */
    public function isAsync(): bool;
}
