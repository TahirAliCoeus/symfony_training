<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Blog
{
    private string $thumbnailName;
    /**
     *@Assert\NotBlank
     */
   private string $title;


   /**
   *@Assert\NotBlank
    */
   private string $content;


    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $thumbnailName
     */
    public function setThumbnailName(string $thumbnailName): void
    {
        $this->thumbnailName = $thumbnailName;
    }

    /**
     * @return string
     */
    public function getThumbnailName(): string
    {
        return $this->thumbnailName;
    }



}