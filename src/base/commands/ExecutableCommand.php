<?php

namespace bilberrry\spaces\base\commands;

use bilberrry\spaces\interfaces\Bus;
use bilberrry\spaces\interfaces\commands\ExecutableCommand as ExecutableCommandInterface;

/**
 * Class ExecutableCommand
 *
 * @package bilberrry\spaces\base\commands
 */
abstract class ExecutableCommand implements ExecutableCommandInterface
{
    /** @var \bilberrry\spaces\interfaces\Bus */
    private $bus;

    /**
     * ExecutableCommand constructor.
     *
     * @param \bilberrry\spaces\interfaces\Bus $bus
     */
    public function __construct(Bus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->bus->execute($this);
    }
}
