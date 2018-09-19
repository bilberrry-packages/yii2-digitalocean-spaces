<?php

namespace bilberrry\spaces\interfaces\commands;

/**
 * Interface HasAcl
 *
 * @package bilberrry\spaces\interfaces\commands
 */
interface HasAcl
{
    /**
     * @param string $acl
     */
    public function withAcl(string $acl);
}
