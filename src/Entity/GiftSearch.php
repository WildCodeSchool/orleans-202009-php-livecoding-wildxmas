<?php

namespace App\Entity;

class GiftSearch
{
    private ?string $input = '';
    private ?Category $category = null;

    /**
     * @return string|null
     */
    public function getInput(): ?string
    {
        return $this->input;
    }

    /**
     * @param string|null $input
     * @return GiftSearch
     */
    public function setInput(?string $input): GiftSearch
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return GiftSearch
     */
    public function setCategory(?Category $category): GiftSearch
    {
        $this->category = $category;

        return $this;
    }
}
