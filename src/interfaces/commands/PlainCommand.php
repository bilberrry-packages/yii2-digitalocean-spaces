<?php

namespace bilberrry\spaces\interfaces\commands;

/**
 * Interface PlainCommand
 *
 * @package bilberrry\spaces\interfaces\commands
 */
interface PlainCommand extends Command
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArgs(): array;
}
