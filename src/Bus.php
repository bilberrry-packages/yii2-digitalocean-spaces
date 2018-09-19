<?php

namespace bilberrry\spaces;

use bilberrry\spaces\interfaces;

/**
 * Class Bus
 *
 * @package bilberrry\spaces
 */
class Bus implements interfaces\Bus
{
    /** @var interfaces\HandlerResolver */
    protected $resolver;

    /**
     * Bus constructor.
     *
     * @param \bilberrry\spaces\interfaces\HandlerResolver $inflector
     */
    public function __construct(interfaces\HandlerResolver $inflector)
    {
        $this->resolver = $inflector;
    }

    /**
     * @param \bilberrry\spaces\interfaces\commands\Command $command
     *
     * @return mixed
     */
    public function execute(interfaces\commands\Command $command)
    {
        $handler = $this->resolver->resolve($command);

        return call_user_func([$handler, 'handle'], $command);
    }
}
