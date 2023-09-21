<?php

namespace App\Services;

use Faker\Factory;
use Faker\Generator;

class HtmlGeneratorService
{
    /** @var array|string[] The Html tags that the class will randomly generate from */
    protected array $tags = ['h1', 'h2', 'h3', 'h6', 'h7', 'p', 'ul', 'li'];
    /** @var int The number of tags the class will generate */
    protected int $numElements;
    /** @var string The Faker locale to generate language from */
    protected string $locale;
    /** @var Generator Faker to generate fake language */
    private Generator $faker;

    public function __construct(int $numElements = 15, string $locale = 'en_US')
    {
        $this->numElements = $numElements;
        $this->locale = $locale;
        $this->faker = Factory::create(locale: $this->locale);
    }


    /**
     * This function will generate a random Html
     * @return string
     */
    public function generateRandomHtmlContent(): string
    {
        shuffle($this->tags);
        $htmlContent = '';

        for ($i = 0; $i < $this->numElements; $i++) {
            $tag = $this->tags[$i % count($this->tags)];
            $content = $this->faker->sentence;

            if ($tag === 'ul') {
                $numListItems = $this->faker->numberBetween(2, 5);
                $listItems = '';

                for ($j = 0; $j < $numListItems; $j++) {
                    $listItems .= '<li>' . $this->faker->sentence . '</li>';
                }

                $content = '<' . $tag . '>' . $listItems . '</' . $tag . '>';
            } else {
                $content = '<' . $tag . '>' . $content . '</' . $tag . '>';
            }

            $htmlContent .= $content;
        }

        return $htmlContent;
    }
}
