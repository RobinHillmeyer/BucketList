<?php

namespace App\Util;

class Censurator
{
    const BANNED_WORDS = ["pute", "fdp", "bite", "lucas"];

    public function purify(string $text): string
    {

        foreach(self::BANNED_WORDS as $bannedWord) {

            $replacement = str_repeat("*", mb_strlen($bannedWord));
            $text = str_ireplace($bannedWord, $replacement, $text);
        }
        return $text;
    }
}