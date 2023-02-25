<?php

namespace HackbartPR\Entity;

use InvalidArgumentException;

class Video
{
    private ?int $id;
    public readonly string $title;
    public readonly string $url;
    private ?string $image_path;

    public function __construct(?int $id, string $title, string $url, ?string $image_path)
    {
        $this->id = $id;
        $this->title = $title;
        $this->setUrl($url);
        $this->image_path = $image_path;
    }

    private function setUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException();
        }

        $this->url = $url;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function image_path(): ?string
    {
        return $this->image_path;
    }    
}