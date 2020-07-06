<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2020-07
 */

namespace FastD\DI;

use FastD\Container\Container;
use ReflectionFunction;
use ReflectionMethod;

class Builder
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function call($callback, array $parameters = [])
    {
        $methodDependencies = $this->getMethodDependencies($callback);

        $dependencies = [];

        foreach ($methodDependencies as $methodDependency) {
            if (isset($parameters[$methodDependency->getName()])) {
                $dependencies[] = $parameters[$methodDependency->getName()];
                continue;
            }

            if (is_null($methodDependency->getClass())) {
                if (!$methodDependency->isOptional()) {
                    throw new \InvalidArgumentException(sprintf(
                        'parameter %s has no default value',
                        $methodDependency->getName()
                    ));
                }
                $dependencies[] = $methodDependency->getDefaultValue();
                continue;
            }

            try {
                $obj = $this->container->get($methodDependency->getClass()->getName());
            } catch (\Exception $exception) {
                if (!$methodDependency->isOptional()) {
                    throw $exception;
                }
                $obj = $methodDependency->getDefaultValue();
            }
            $dependencies[] = $obj;
        }

        return call_user_func_array($callback, $dependencies);
    }

    /**
     * @param $callback
     * @return \ReflectionParameter[]
     * @throws \ReflectionException
     */
    protected function getMethodDependencies($callback): array
    {
        if (is_array($callback)) {
            return (new ReflectionMethod($callback[0], $callback[1]))->getParameters();
        }
        return (new ReflectionFunction($callback))->getParameters();
    }
}
