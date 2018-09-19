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
 * Class DeleteCommand
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @package bilberrry\spaces\commands
 */
class DeleteCommand extends ExecutableCommand implements PlainCommand, HasSpace, Asynchronous
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
     * @return string
     */
    public function getVersionId(): string
    {
        return $this->args['VersionId'] ?? '';
    }

    /**
     * @param string $versionId
     *
     * @return $this
     */
    public function withVersionId(string $versionId)
    {
        $this->args['VersionId'] = $versionId;

        return $this;
    }

    /**
     * @internal used by the handlers
     *
     * @return string
     */
    public function getName(): string
    {
        return 'DeleteObject';
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
