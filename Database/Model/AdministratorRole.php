<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\Database\Model;

use Neo\Core\Database\ORM\Model\AbstractModel;

class AdministratorRole extends AbstractModel 
{
    protected static ?string $table = 'administrator_role';
    protected array $hidden = [];
    
    public ?int $id = null;

    public string $label;

    public string $description;

    public ?\DateTime $created_at = null;

    public ?\DateTime $updated_at = null;

    public ?\DateTime $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        return $this->setAttribute('id', $id);
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        return $this->setAttribute('label', $label);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        return $this->setAttribute('description', $description);
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at): static
    {
        return $this->setAttribute('created_at', $created_at);
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): static
    {
        return $this->setAttribute('updated_at', $updated_at);
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTime $deleted_at): static
    {
        return $this->setAttribute('deleted_at', $deleted_at);
    }
}