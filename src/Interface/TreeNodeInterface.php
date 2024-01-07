<?php

namespace Ucscode\TreeNode\Interface;

use Ucscode\TreeNode\TreeNode;

interface TreeNodeInterface
{
    public function getLevel(): int;
    public function getName(): ?string;
    public function getIndex(): int;
    public function getIdentity(): string;
    public function addChild(string $name, array|TreeNode $component = []): TreeNode;
    public function getChild(string $name): ?TreeNode;
    public function hasChild(string|TreeNode $context): bool;
    public function removeChild(string|TreeNode $context): ?TreeNode;
    public function getChildren(): array;
    public function findChildByIndex(int $index): ?TreeNode;
    public function getParent(): ?TreeNode;
    public function setAttribute(string $name, mixed $value): self;
    public function getAttribute(string $name): mixed;
    public function removeAttribute(string $name): self;
    public function getAttributes(): array;
    public function sortChildren(callable $func): void;
    public function traverseChildren(callable $callback): void;
}
