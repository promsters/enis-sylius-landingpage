<?php

namespace Enis\SyliusLandingPagePlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="sylius_landing_page")
 * @ORM\Entity(repositoryClass="Enis\SyliusLandingPagePlugin\Repository\LandingPageRepository")
 */
class LandingPage implements ResourceInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $starts_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ends_at;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $template;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug() : ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getStartsAt() : ?\DateTimeInterface
    {
        return $this->starts_at;
    }

    public function setStartsAt(?\DateTimeInterface $start) : self
    {
        $this->starts_at = $start;
        return $this;
    }

    public function getEndsAt() : ?\DateTimeInterface
    {
        return $this->ends_at;
    }

    public function setEndsAt(?\DateTimeInterface $end) : self
    {
        $this->ends_at = $end;
        return $this;
    }

    public function getTemplate() : ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template) : self
    {
        $this->template = $template;
        return $this;
    }

    public function getStatus() : string
    {
        $now = new \DateTime();
        if($this->getStartsAt() && $this->getStartsAt() > $now)
        {
            return 'pending';
        }
        if($this->getEndsAt() && $this->getEndsAt() < $now)
        {
            return 'done';
        }

        return 'active';
    }
}
