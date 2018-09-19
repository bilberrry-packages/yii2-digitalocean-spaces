<?php

namespace bilberrry\spaces\handlers;

use Aws\CommandInterface as AwsCommand;
use bilberrry\spaces\base\handlers\Handler;
use bilberrry\spaces\interfaces\commands\Asynchronous;
use bilberrry\spaces\interfaces\commands\PlainCommand;

/**
 * Class PlainCommandHandler
 *
 * @package bilberrry\spaces\handlers
 */
final class PlainCommandHandler extends Handler
{
    /**
     * @param \bilberrry\spaces\interfaces\commands\PlainCommand $command
     *
     * @return \Aws\ResultInterface|\GuzzleHttp\Promise\PromiseInterface
     */
    public function handle(PlainCommand $command)
    {
        $awsCommand = $this->transformToAwsCommand($command);

        /** @var \GuzzleHttp\Promise\PromiseInterface $promise */
        $promise = $this->s3Client->executeAsync($awsCommand);

        return $this->commandIsAsync($command) ? $promise : $promise->wait();
    }

    /**
     * @param \bilberrry\spaces\interfaces\commands\PlainCommand $command
     *
     * @return bool
     */
    protected function commandIsAsync(PlainCommand $command): bool
    {
        return $command instanceof Asynchronous && $command->isAsync();
    }

    /**
     * @param \bilberrry\spaces\interfaces\commands\PlainCommand $command
     *
     * @return \Aws\CommandInterface
     */
    protected function transformToAwsCommand(PlainCommand $command): AwsCommand
    {
        $args = array_filter($command->toArgs());

        return $this->s3Client->getCommand($command->getName(), $args);
    }
}
