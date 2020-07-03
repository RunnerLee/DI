# DI
Dependency injection 

### Requirements

* PHP >=7.4

### Installation

```
composer require "fastd/container"
```

### Usage

```php
$container = new Container();
$container->add('container', $container);
$factory = new Factory($container);
$factory->bind(Factory::class);
try {
    $factory = $factory->make();
    $this->assertInstanceOf(Factory::class, $factory);
} catch (Exception $e) {

}
```

### Testing

```php
bin/phpunit
```

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

如果你乐于此，却又不知如何开始，可以试试下面这些事情：

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/JanHuang/fastD/issues)。
* 有更好的建议？欢迎联系 [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com) 或 [新浪微博:编码侠](http://weibo.com/ecbboyjan)。

### 联系

如果你在使用中遇到问题，请联系: [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com). 微博: [编码侠](http://weibo.com/ecbboyjan)

## License MIT

