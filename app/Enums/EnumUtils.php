<?php

namespace App\Enums;

trait EnumUtils
{
    private static function getClassName(): string
    {
        $array = explode("\\", __CLASS__);
        return lcfirst(array_pop($array));
    }

    public static function getFromValue(mixed $value): self
    {
        foreach (self::cases() as $enum) {
            if($value === $enum->value){
                return $enum;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }

    public static function getFromName($value): self
    {
        foreach (self::cases() as $enum) {
            if($value === $enum->name ){
                return $enum;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $banner['name'] = $case->name;
            $banner['value'] = $case->value;
            $banner['description'] = __('enum.'.self::getClassName().'.'.$case->name);
            $array[] = $banner;
        }
        return $array;
    }
    public static function getWithData(mixed $element): array
    {
        if (is_null($element)) {
            return [];
        }
        $array = [];
        foreach (self::cases() as $case) {
            if ($case->value === $element) {
                $array['name'] = $case->name;
                $array['value'] = $case->value;
                $array['description'] = __('enum.'.self::getClassName().'.'.$case->name);
                return $array;
            }
        }
        return $array;
    }
}
