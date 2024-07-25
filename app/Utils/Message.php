<?php

namespace App\Utils;

class Message
{
    const LABEL = 'response_message';

    /**
     * Output a formatted message string.
     *
     * @param string $type Type of the message.
     * @param string $displayText Text to display.
     * @param string $addOnClasses Additional classes to add to the tag.
     * @return string Formatted message string.
     */
    public static function out(string $type, string $displayText, string $addOnClasses = ''): string
    {
        return "<small class=\"text-{$type} {$addOnClasses}\">{$displayText}</small>";
    }

        public static function PRIMARY(string $displayText, string $addOnClasses = '')
    {
        return self::out('primary', $displayText, $addOnClasses);
    }
    public static function DANGER(string $displayText, string $addOnClasses = '')
    {
        return self::out('danger', $displayText, $addOnClasses);
    }
    public static function INFO(string $displayText, string $addOnClasses = '')
    {
        return self::out('info', $displayText, $addOnClasses);
    }
    public static function SUCCESS(string $displayText, string $addOnClasses = '')
    {
        return self::out('success', $displayText, $addOnClasses);
    }
    public static function SECONDARY(string $displayText, string $addOnClasses = '')
    {
        return self::out('secondary', $displayText, $addOnClasses);
    }
}
