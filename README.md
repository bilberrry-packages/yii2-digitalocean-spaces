# Yii2 DigitalOcean Spaces

DigitalOcean Spaces component for Yii2. Based on [frostealth/yii2-aws-s3](https://github.com/frostealth/yii2-aws-s3/).

[![License](https://poser.pugx.org/frostealth/yii2-aws-s3/license)](https://github.com/frostealth/yii2-aws-s3/blob/2.x/LICENSE)


## Installation

1. Run the [Composer](http://getcomposer.org/download/) command to install the latest version:

    ```bash
    composer require bilberrry/yii2-digitalocean-spaces
    ```

2. Add the component to config:

    ```php
    'components' => [
        // ...
        'storage' => [
            'class' => 'bilberrry\spaces\Service',
            'credentials' => [
                'key' => 'my-key',
                'secret' => 'my-secret',
            ],
            'region' => 'nyc3', // currently available: nyc3, ams3, sgp1, sfo2
            'defaultSpace' => 'my-space',
            'defaultAcl' => 'public-read',
        ],
        // ...
    ],
    ```

## Basic usage

### Usage of the command factory and additional params

```php
/** @var \bilberrry\spaces\Service $storage */
$storage = Yii::$app->get('storage');

/** @var \Aws\ResultInterface $result */
$result = $storage->commands()->get('filename.ext')->saveAs('/path/to/local/file.ext')->execute();

$result = $storage->commands()->put('filename.ext', 'body')->withContentType('text/plain')->execute();

$result = $storage->commands()->delete('filename.ext')->execute();

$result = $storage->commands()->upload('filename.ext', '/path/to/local/file.ext')->withAcl('private')->execute();

$result = $storage->commands()->restore('filename.ext', $days = 7)->execute();

$result = $storage->commands()->list('path/')->execute();

/** @var bool $exist */
$exist = $storage->commands()->exist('filename.ext')->execute();

/** @var string $url */
$url = $storage->commands()->getUrl('filename.ext')->execute();

/** @var string $signedUrl */
$signedUrl = $storage->commands()->getPresignedUrl('filename.ext', '+2 days')->execute();
```

### Short syntax

```php
/** @var \bilberrry\spaces\Service $storage */
$storage = Yii::$app->get('storage');

/** @var \Aws\ResultInterface $result */
$result = $storage->get('filename.ext');

$result = $storage->put('filename.ext', 'body');

$result = $storage->delete('filename.ext');

$result = $storage->upload('filename.ext', '/path/to/local/file.ext');

$result = $storage->restore('filename.ext', $days = 7);

$result = $storage->list('path/');

/** @var bool $exist */
$exist = $storage->exist('filename.ext');

/** @var string $url */
$url = $storage->getUrl('filename.ext');

/** @var string $signedUrl */
$signedUrl = $storage->getPresignedUrl('filename.ext', '+2 days');
```

### Asynchronous execution

```php
/** @var \bilberrry\spaces\Service $storage */
$storage = Yii::$app->get('storage');

/** @var \GuzzleHttp\Promise\PromiseInterface $promise */
$promise = $storage->commands()->get('filename.ext')->async()->execute();

$promise = $storage->commands()->put('filename.ext', 'body')->async()->execute();

$promise = $storage->commands()->delete('filename.ext')->async()->execute();

$promise = $storage->commands()->upload('filename.ext', 'source')->async()->execute();

$promise = $storage->commands()->list('path/')->async()->execute();
```

## Advanced usage

```php
/** @var \bilberrry\spaces\interfaces\Service $storage */
$storage = Yii::$app->get('storage');

/** @var \frostealth\yii2\aws\s3\commands\GetCommand $command */
$command = $storage->create(GetCommand::class);
$command->inBucket('my-another-bucket')->byFilename('filename.ext')->saveAs('/path/to/local/file.ext');

/** @var \Aws\ResultInterface $result */
$result = $storage->execute($command);

// or async
/** @var \GuzzleHttp\Promise\PromiseInterface $promise */
$promise = $storage->execute($command->async());
```

### Custom commands

Commands have two types: plain commands that's handled by the `PlainCommandHandler` and commands with their own handlers.
The plain commands wrap the native AWS S3 commands.

The plain commands must implement the `PlainCommand` interface and the rest must implement the `Command` interface.
If the command doesn't implement the `PlainCommand` interface, it must have its own handler.

Every handler must extend the `Handler` class or implement the `Handler` interface.
Handlers gets the `S3Client` instance into its constructor.

The implementation of the `HasBucket` and `HasAcl` interfaces allows the command builder to set the values
of bucket and acl by default.

To make the plain commands asynchronously, you have to implement the `Asynchronous` interface.
Also, you can use the `Async` trait to implement this interface.

Consider the following command:

```php
<?php

namespace app\components\s3\commands;

use frostealth\yii2\aws\s3\base\commands\traits\Options;
use frostealth\yii2\aws\s3\interfaces\commands\Command;
use frostealth\yii2\aws\s3\interfaces\commands\HasBucket;

class MyCommand implements Command, HasBucket
{
    use Options;

    protected $bucket;

    protected $something;

    public function getBucket()
    {
        return $this->bucket;
    }

    public function inBucket(string $bucket)
    {
        $this->bucket = $bucket;

        return $this;
    }

    public function getSomething()
    {
        return $this->something;
    }

    public function withSomething(string $something)
    {
        $this->something = $something;

        return $this;
    }
}
```

The handler for this command looks like this:

```php
<?php

namespace app\components\s3\handlers;

use app\components\s3\commands\MyCommand;
use frostealth\yii2\aws\s3\base\handlers\Handler;

class MyCommandHandler extends Handler
{
    public function handle(MyCommand $command)
    {
        return $this->s3Client->someAction(
            $command->getBucket(),
            $command->getSomething(),
            $command->getOptions()
        );
    }
}
```

And usage this command:

```php
/** @var \bilberrry\spaces\interfaces\Service */
$storage = Yii::$app->get('storage');

/** @var \app\components\s3\commands\MyCommand $command */
$command = $storage->create(MyCommand::class);
$command->withSomething('some value')->withOption('OptionName', 'value');

/** @var \Aws\ResultInterface $result */
$result = $storage->execute($command);
```

Custom plain command looks like this:

```php
<?php

namespace app\components\s3\commands;

use frostealth\yii2\aws\s3\interfaces\commands\HasBucket;
use frostealth\yii2\aws\s3\interfaces\commands\PlainCommand;

class MyPlainCommand implements PlainCommand, HasBucket
{
    protected $args = [];

    public function getBucket()
    {
        return $this->args['Bucket'] ?? '';
    }

    public function inBucket(string $bucket)
    {
        $this->args['Bucket'] = $bucket;

        return $this;
    }

    public function getSomething()
    {
        return $this->args['something'] ?? '';
    }

    public function withSomething($something)
    {
        $this->args['something'] = $something;

        return $this;
    }

    public function getName(): string
    {
        return 'AwsS3CommandName';
    }

    public function toArgs(): array
    {
        return $this->args;
    }
}
```

Any command can extend the `ExecutableCommand` class or implement the `Executable` interface that will
allow to execute this command immediately: `$command->withSomething('some value')->execute();`.

## License

Yii2 DigitalOcean Spaces is licensed under the MIT License.

See the [LICENSE](LICENSE) file for more information.
