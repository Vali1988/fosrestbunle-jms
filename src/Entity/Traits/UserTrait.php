<?php


namespace App\Entity\Traits;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait UserTrait
{
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 */
	private $createdBy;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 */
	private $updatedBy;

	public function getCreatedBy(): ?User
	{
		return $this->createdBy;
	}

	public function setCreatedBy(?User $createdBy): self
	{
		$this->createdBy = $createdBy;

		return $this;
	}

	public function getUpdatedBy(): ?User
	{
		return $this->updatedBy;
	}

	public function setUpdatedBy(?User $updatedBy): self
	{
		$this->updatedBy = $updatedBy;

		return $this;
	}
}