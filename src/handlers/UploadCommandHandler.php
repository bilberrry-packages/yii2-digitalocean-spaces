<?php

namespace bilberrry\spaces\handlers;

use bilberrry\spaces\commands\UploadCommand;
use bilberrry\spaces\base\handlers\Handler;
use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Class UploadCommandHandler
 *
 * @package bilberrry\spaces\handlers
 */
final class UploadCommandHandler extends Handler
{
    /**
     * @param \bilberrry\spaces\commands\UploadCommand $command
     *
     * @return \Aws\ResultInterface|\GuzzleHttp\Promise\PromiseInterface
     */
    public function handle(UploadCommand $command)
    {
        $source = $this->sourceToStream($command->getSource());
        $options = array_filter($command->getOptions());

        $promise = $this->s3Client->uploadAsync(
            $command->getSpace(),
            $command->getFilename(),
            $source,
            $command->getAcl(),
            $options
        );

        return $command->isAsync() ? $promise : $promise->wait();
    }

    /**
     * Create a new stream based on the input type.
     *
     * @param resource|string|StreamInterface $source path to a local file, resource or stream
     *
     * @return StreamInterface
     */
    protected function sourceToStream($source): StreamInterface
    {
        if (is_string($source)) {
            $source = \GuzzleHttp\Psr7\Utils::tryFopen($source, 'r+');
        }

        return \GuzzleHttp\Psr7\Utils::streamFor($source);
    }
}
