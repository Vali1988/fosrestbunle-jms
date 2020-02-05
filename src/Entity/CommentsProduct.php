<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsProductRepository")
 */
class CommentsProduct extends Comments
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="commentsProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
