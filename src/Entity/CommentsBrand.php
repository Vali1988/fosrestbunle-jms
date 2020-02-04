<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsBrandRepository")
 */
class CommentsBrand extends Comments
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="commentsBrands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
