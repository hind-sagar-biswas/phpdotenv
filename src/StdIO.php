<?php

namespace Hindbiswas\Phpdotenv;

class StdIO
{
    public static array $colors = [
        "black" => "0;30",
        "dark grey" => "1;30",
        "red" => "0;31",
        "light red" => "1;31",
        "green" => "0;32",
        "light green" => "1;32",
        "brown" => "0;33",
        "yellow" => "1;33",
        "blue" => "0;34",
        "light blue" => "1;34",
        "magenta" => "0;35",
        "light magenta" => "1;35",
        "cyan" => "0;36",
        "light cyan" => "1;36",
        "light grey" => "0;37",
        "white" => "1;37"
    ];

    public static function wrap_in_color(string $text, string $color)
    {
        $color = (array_key_exists($color, self::$colors)) ? self::$colors[$color] : self::$colors["dark grey"];
        return "\e[" . $color . "m$text\e[0m";
    }

    public static function red(string $text)
    {
        return self::wrap_in_color($text, "light red");
    }

    public static function yellow(string $text)
    {
        return self::wrap_in_color($text, "yellow");
    }

    public static function blue(string $text)
    {
        return self::wrap_in_color($text, "light blue");
    }

    public static function green(string $text)
    {
        return self::wrap_in_color($text, "light green");
    }

    public static function get(string $prompt, $default = null, ?array $options = null): ?string
    {
        $default_show = ($default) ? "[default: " . self::green($default) . "]" : '';
        if ($options) {
            $colored_opt = array_map(fn ($val): string => self::yellow($val), $options);
            $default_show .= ' [' . implode('/', $colored_opt) . "]";
        }
        self::put("$prompt $default_show ");
        $input = readline(">> ");
        $result = (trim($input) == "") ? $default : $input;

        if ($options && !in_array($result, $options)) {
            $result = $default;
        }

        return $result;
    }

    public static function put($value, int $multiplier = 1): void
    {
        $output_text = '';
        for ($i = 0; $i < $multiplier; $i++) {
            $output_text = $output_text . $value;
        }
        echo $output_text . PHP_EOL;
    }
}
