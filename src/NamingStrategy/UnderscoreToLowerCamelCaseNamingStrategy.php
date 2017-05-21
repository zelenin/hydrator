<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\NamingStrategy;

final class UnderscoreToLowerCamelCaseNamingStrategy implements NamingStrategy
{
    /**
     * @inheritdoc
     */
    public function extract(string $name): string
    {
        $pattern = [
            '#(?<=(?:\p{Lu}))(\p{Lu}\p{Ll})#',
            '#(?<=(?:\p{Ll}|\p{Nd}))(\p{Lu})#',
        ];
        $replacement = [
            '_\1',
            '_\1',
        ];

        return mb_strtolower(preg_replace($pattern, $replacement, $name));
    }

    /**
     * @inheritdoc
     */
    public function hydrate(string $name): string
    {
        $pattern = '#(_)(\P{Z}{1})#u';

        $name = preg_replace_callback($pattern, function ($matches) {
            return strtoupper($matches[2]);
        }, $name);

        return $this->lowerCaseFirst($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function lowerCaseFirst(string $name): string
    {
        if (0 === mb_strlen($name)) {
            return $name;
        }

        return mb_strtolower(mb_substr($name, 0, 1)) . mb_substr($name, 1);
    }
}
