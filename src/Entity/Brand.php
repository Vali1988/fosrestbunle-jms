<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
{
	use TimestampableTrait, UserTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="brand")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank(message="El campo debe estar relleno")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Gedmo\Slug(fields={"name"}, unique=true, updatable=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentsBrand", mappedBy="brand", orphanRemoval=true)
     */
    private $commentsBrands;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->commentsBrands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|CommentsBrand[]
     */
    public function getCommentsBrands(): Collection
    {
        return $this->commentsBrands;
    }

    public function addCommentsBrand(CommentsBrand $commentsBrand): self
    {
        if (!$this->commentsBrands->contains($commentsBrand)) {
            $this->commentsBrands[] = $commentsBrand;
            $commentsBrand->setBrand($this);
        }

        return $this;
    }

    public function removeCommentsBrand(CommentsBrand $commentsBrand): self
    {
        if ($this->commentsBrands->contains($commentsBrand)) {
            $this->commentsBrands->removeElement($commentsBrand);
            // set the owning side to null (unless already changed)
            if ($commentsBrand->getBrand() === $this) {
                $commentsBrand->setBrand(null);
            }
        }

        return $this;
    }

	public function getProductCount()
	{
		return $this->getProduct()->count();
    }

	public function getCommentCount()
	{
		return $this->getCommentsBrands()->count();
    }
}
