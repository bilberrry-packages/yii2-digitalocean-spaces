<?php

namespace bilberrry\spaces\base\handlers;

use Aws\S3\S3Client;
use bilberrry\spaces\interfaces\handlers\Handler as HandlerInterface;

/**
 * Class Handler
 *
 * @package bilberrry\spaces\base\handlers
 */
abstract class Handler implements HandlerInterface
{
    /** @var S3Client */
    protected $s3Client;

    /**
     * Handler constructor.
     *
     * @param \Aws\S3\S3Client $s3Client
     */
    public function __construct(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
    }
}
