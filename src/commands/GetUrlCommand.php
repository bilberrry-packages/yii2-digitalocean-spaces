<?php

namespace bilberrry\spaces\commands;

use bilberrry\spaces\base\commands\ExecutableCommand;
use bilberrry\spaces\interfaces\commands\HasSpace;

/**
 * Class GetUrlCommand
 *
 * @method string execute()
 *
 * @package bilberrry\spaces\commands
 */
class GetUrlCommand extends ExecutableCommand implements HasSpace
{
    /** @var string */
    protected $space;

    /** @var string */
    protected $filename;

    /**
     * @return string
     */
    public function getSpace(): string
    {
        return (string)$this->space;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function inSpace(string $name)
    {
        $this->space = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return (string)$this->filename;
    }

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function byFilename(string $filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
