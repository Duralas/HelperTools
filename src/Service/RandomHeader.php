<?php

declare(strict_types=1);

namespace App\Service;

final class RandomHeader
{
    private array $headers;

    /** @param array<string, string[]> $headers */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function getHeader(): string
    {
        $season = $this->getSeason();
        return 'build/images/headers/' . $season . '/' . array_rand(array_flip($this->headers[$season]));
    }

    public function getSeason(): string
    {
        $month = (int) date('m');
        if ($month < 3) {
            $season = 'winter';
        } elseif ($month < 6) {
            $season = 'spring';
        } elseif ($month < 9) {
            $season = 'summer';
        } elseif ($month < 12) {
            $season = 'autumn';
        } else {
            $season = 'winter';
        }

        return $season;
    }
}
