<?php

namespace App\SDK\Application\Service;

use App\SDK\Domain\Model\ValueObject;
use InvalidArgumentException;
use ReflectionClass;

abstract class Enum extends ValueObject
{
    /** @var array */
    protected static $classConstantsCache = [];

    /** @var mixed */
    protected $value;

    public function __construct($value)
    {
        $this->guardIsValid($value);
        $this->value = $value;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function guardIsValid($value)
    {
        if (!static::isValid($value)) {
            $this->invalidValueException($value);
        }
    }

    protected static function isValid($value): bool
    {
        return in_array($value, static::validValues(), true);
    }

    public static function validValues(): array
    {
        if (false === isset(static::$classConstantsCache[static::class])) {
            static::$classConstantsCache[static::class] = array_filter(
                (new ReflectionClass(static::class))->getConstants(),
                static function ($value): bool {
                    return (false === is_array($value));
                }
            );
        }

        return array_values(static::$classConstantsCache[static::class]);
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    protected function invalidValueException($value)
    {
        throw new InvalidArgumentException(sprintf('%s value <%s> is invalid', get_class($this), $value));
    }

    public static function __callStatic(string $name, $arguments): self
    {
        $snake = (strtolower($name) == $name) ? $name : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $name));
        $value = constant(static::class . '::' . strtoupper($snake));

        return new static($value);
    }

    /** @return static */
    public static function fromString(string $value): self
    {
        return new static($value);
    }

    /** @return static[] */
    public static function validValuesByEnum(): array
    {
        return array_map(
            static function ($value): self {
                return new static($value);
            },
            self::validValues()
        );
    }

    public function equals($object): bool
    {
        return ($object instanceof Enum) && ($object == $this);
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public function value()
    {
        return $this->value;
    }
}
