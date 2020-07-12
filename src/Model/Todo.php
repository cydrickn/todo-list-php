<?php

namespace Model;

class Todo
{
    private ?int $id;
    private string $title;
    private string $description;
    private bool $isDone;

    public function __construct(?int $id, string $title, string $description, bool $isDone = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->isDone = $isDone;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setToDone(): self
    {
        $this->isDone = true;
    }

    public function setToUndone(): self
    {
        $this->isDone = false;
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'title' => $this->title, 'description' => $this->description];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}