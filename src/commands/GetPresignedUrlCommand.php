<?php

namespace bilberrry\spaces\commands;

use bilberrry\spaces\base\commands\ExecutableCommand;
use bilberrry\spaces\interfaces\commands\HasSpace;

/**
 * Class GetPresignedUrlCommand
 *
 * @method string execute()
 *
 * @package bilberrry\spaces\commands
 */
class GetPresignedUrlCommand extends ExecutableCommand implements HasSpace
{
    /** @var array */
    protected $args = [];

    /** @var mixed */
    protected $expiration;

    /**
     * @return string
     */
    public function getSpace(): string
    {
        return $this->args['Bucket'] ?? '';
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function inSpace(string $name)
    {
        $this->args['Bucket'] = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->args['Key'] ?? '';
    }

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function byFilename(string $filename)
    {
        $this->args['Key'] = $filename;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param int|string|\DateTime $expiration
     *
     * @return $this
     */
    public function withExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @internal used by the handlers
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}
