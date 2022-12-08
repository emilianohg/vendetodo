<?php

namespace App\Domain\Common;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use stdClass;

abstract class DomainElement
{

    public abstract static function from(array $values): self;

    /**
     * @param array $listValues
     * @return DomainElement[]
     */
    public abstract static function fromArray(array $listValues): array;

    /**
     * @template T
     * @param class-string<T> $className
     * @return object
     */
    protected static function make(string $className, array | stdClass $value): object
    {
        if($value instanceof stdClass)
        {
            $value = (array)$value;
        }
        $reflectionClass = new ReflectionClass($className);
        $constructor = new ReflectionMethod($reflectionClass->getName(), '__construct');

        $attributes = [];

        foreach ($constructor->getParameters() as $parameter) {

            // Reviso si values tiene un valor para el parametro actual
            if(!isset($value[$parameter->getName()])) {
                continue;
            }

            // Remuevo el signo de interrogacion de los parametros opcionales
            // ?App\Domain\Marca -> App\Domain\Marca
            // int -> int
            $typeParameter = ltrim($parameter->getType(), '?');

            // Si es primitivo
            if (self::isPrimitive($typeParameter)) {
                $attributes[$parameter->getName()] = $value[$parameter->getName()];
                continue;
            }

            // Si es un arreglo
            if ($typeParameter == 'array') {
                $arrayOfClasses = $value[$parameter->getName()];

                $classNameOfArray = self::getTypeByDocs($constructor, $parameter->getName());

                if ($classNameOfArray == null) {
                    $attributes[$parameter->getName()] = $arrayOfClasses;
                    continue;
                }

                $arrayObjective = [];

                foreach ($arrayOfClasses as $classOfArray) {
                    $attributeClass = new ReflectionClass($classNameOfArray);
                    if ($attributeClass->isSubclassOf(DomainElement::class)) {
                        $instance = $attributeClass->newInstanceWithoutConstructor();
                        $arrayObjective[] = $instance->from($classOfArray);
                    }
                }

                $attributes[$parameter->getName()] = $arrayObjective;

                continue;
            }

            // Si es una clase que hereda de DomainElement::class
            $attributeClass = new ReflectionClass($typeParameter);
            if ($attributeClass->isSubclassOf(DomainElement::class)) {
                $instance = $attributeClass->newInstanceWithoutConstructor();
                $attributes[$parameter->getName()] = $instance->from($value[$parameter->getName()]);
            }

        }

        return $reflectionClass->newInstanceArgs($attributes);
    }

    private static function isPrimitive(string $type) {
        return in_array($type, ['int', 'float', 'boolean', 'string', 'object']);
    }

    private static function getTypeByDocs(ReflectionMethod $method, string $paramName): ?string {

        $comment = $method->getDocComment();

        $starting_word = '@param';
        $ending_word = '$' . $paramName;

        foreach (preg_split("/\r\n|\n|\r/", $comment) as $line) {
            if (!str_contains($line, $starting_word) || !str_contains($line, $ending_word)) {
                continue;
            }

            $subtring_start = strpos($line, $starting_word);
            $subtring_start += strlen($starting_word);
            $size = strpos($line, $ending_word, $subtring_start) - $subtring_start;

            $classNameArray = trim(substr($line, $subtring_start, $size));

            return substr(str_replace('[]', '', $classNameArray), 1);
        }

        return null;
    }

}