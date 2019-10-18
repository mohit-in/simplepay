<?php 

trait IdentifiableEntity
{
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_modified_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    private function setCreatedAt()
    {
  	    $this->created_at = new \DateTime;

        return $this;
    }

    public function getLastModifiedAt(): ?\DateTimeInterface
    {
        return $this->last_modified_at;
    }

    private function setLastModifiedAt()
    {
        $this->last_modified_at = new \DateTime;

        return $this;
    }	
}