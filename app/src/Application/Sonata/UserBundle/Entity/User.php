<?php

namespace App\Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Catalogue;
use App\Entity\Country;
use App\Entity\Ecofunctional;
use App\Entity\Literature;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User extends BaseUser
{
	/**
	 * @var int $id
	 */
	protected $id;

	/**
	 * @var string
	 * @ORM\Column(name="Skype", type="string", length=255, nullable=true)
	 *
	 */
	protected $skype;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Catalogue")
	 */
	protected $soi;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Ecofunctional")
	 */
	protected $Eco;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Country")
	 */
	protected $country;


	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Literature", cascade={"all"}, orphanRemoval=true, mappedBy="users")
	 */
	protected $literature;

	public function __construct ()
	{
		parent::__construct ();
		$this->soi = new ArrayCollection();
		$this->Eco = new ArrayCollection();
		$this->literature = new ArrayCollection();
		$this->roles = ['ROLE_REGSITREDUSER'];
		// your code here
	}

	/**
	 * Get id.
	 *
	 * @return int $id
	 */
	public function getId ()
	{
		return $this->id;
	}

	public function getSkype (): ?string
	{
		return $this->skype;
	}

	public function setSkype (?string $skype): self
	{
		$this->skype = $skype;

		return $this;
	}

	/**
	 * @return Collection|Literature[]
	 */
	public function getLiterature (): Collection
	{
		return $this->literature;
	}

	public function addLiterature (Literature $literature): self
	{
		if (!$this->literature->contains ($literature)) {
			$this->literature[] = $literature;
			$literature->setUsers ($this);
		}

		return $this;
	}

	public function removeLiterature (Literature $literature): self
	{
		if ($this->literature->contains ($literature)) {
			$this->literature->removeElement ($literature);
			// set the owning side to null (unless already changed)
			if ($literature->getUsers () === $this) {
				$literature->setUsers (null);
			}
		}

		return $this;
	}

	public function getCountry (): ?Country
	{
		return $this->country;
	}

	public function setCountry (?Country $country): self
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * @return Collection|Catalogue[]
	 */
	public function getSoi (): Collection
	{
		return $this->soi;
	}

	public function addSoi (Catalogue $soi): self
	{
		if (!$this->soi->contains ($soi)) {
			$this->soi[] = $soi;
		}

		return $this;
	}

	public function removeSoi (Catalogue $soi): self
	{
		if ($this->soi->contains ($soi)) {
			$this->soi->removeElement ($soi);
		}

		return $this;
	}

	/**
	 * @return Collection|Ecofunctional[]
	 */
	public function getEco (): Collection
	{
		return $this->Eco;
	}

	public function addEco (Ecofunctional $eco): self
	{
		if (!$this->Eco->contains ($eco)) {
			$this->Eco[] = $eco;
		}

		return $this;
	}

	public function removeEco (Ecofunctional $eco): self
	{
		if ($this->Eco->contains ($eco)) {
			$this->Eco->removeElement ($eco);
		}

		return $this;
	}
}
