<?php

namespace Ucscode\TreeNode\Interface;

interface TreeNodeInterface
{
    public function getLevel(): int;
    public function getName(): ?string;
    public function getIndex(): int;
    public function getIdentity(): string;
    public function addChild(string $name, array|TreeNodeInterface $component = []): TreeNodeInterface;
    public function getChild(string $name): ?TreeNodeInterface;
    public function hasChild(string|TreeNodeInterface $context): bool;
    public function removeChild(string|TreeNodeInterface $context): ?TreeNodeInterface;
    public function getChildren(): array;
    public function findChildByIndex(int $index): ?TreeNodeInterface;
    public function getParent(): ?TreeNodeInterface;
    public function getParents(): array;
    public function setAttribute(string $name, mixed $value): self;
    public function getAttribute(string $name): mixed;
    public function removeAttribute(string $name): self;
    public function getAttributes(): array;
    public function sortChildren(callable $func): void;
    public function traverseChildren(callable $callback): void;
}
