<?php

namespace bilberrry\spaces\commands;

use Aws\ResultInterface;
use bilberrry\spaces\base\commands\ExecutableCommand;
use bilberrry\spaces\base\commands\traits\Async;
use bilberrry\spaces\base\commands\traits\Options;
use bilberrry\spaces\interfaces\commands\Asynchronous;
use bilberrry\spaces\interfaces\commands\HasSpace;
use bilberrry\spaces\interfaces\commands\PlainCommand;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class GetCommand
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @package bilberrry\spaces\commands
 */
class GetCommand extends ExecutableCommand implements PlainCommand, HasSpace, Asynchronous
{
    use Async;
    use Options;

    /** @var array */
    protected $args = [];

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
     * @param string $value
     *
     * @return $this
     */
    public function saveAs(string $value)
    {
        $this->args['SaveAs'] = $value;

        return $this;
    }

    /**
     * @param string $ifMatch
     *
     * @return $this
     */
    public function ifMatch(string $ifMatch)
    {
        $this->args['IfMatch'] = $ifMatch;

        return $this;
    }

    /**
     * @internal used by the handlers
     *
     * @return string
     */
    public function getName(): string
    {
        return 'GetObject';
    }

    /**
     * @internal used by the handlers
     *
     * @return array
     */
    public function toArgs(): array
    {
        return array_replace($this->options, $this->args);
    }
}
