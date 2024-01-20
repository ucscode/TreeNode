<?php

namespace Ucscode\TreeNode;

use Ucscode\TreeNode\Abstract\AbstractTreeNode;
use Ucscode\TreeNode\Interface\TreeNodeInterface;

class TreeNode extends AbstractTreeNode
{
    /**
     * Adds a child node to the current TreeNode object.
     */
    public function addChild(string $name, array|TreeNodeInterface $component = []): TreeNodeInterface
    {
        $this->balanceChildren($name);
        $child = ($component instanceof TreeNodeInterface) ? $component : new self($name, $component);
        $child->parent = $this;
        $child->level = $this->level + 1;
        $child->traverseChildren(fn (TreeNodeInterface $node) => $node->level = ($node->parent->level + 1));
        return $this->children[$name] = $child;
    }

    /**
     * Retrieves a child node from the current TreeNode object.
     */
    public function getChild(string $name): ?TreeNodeInterface
    {
        return $this->children[$name] ?? null;
    }

    /**
     * Removes a child node from the current TreeNode object.
     */
    public function removeChild(string|TreeNodeInterface $context): ?TreeNodeInterface
    {
        $index = is_string($context) ? $context : array_search($context, $this->children, true);
        $child = $index === false ? null : $this->getChild($index);
        if(!empty($child)) {
            unset($this->children[$index]);
        }
        return $child;
    }

    /**
     * Test if the node has a child node
     */
    public function hasChild(string|TreeNodeInterface $context): bool
    {
        return ($context instanceof TreeNodeInterface) ?
            in_array($context, $this->children, true) :
            array_key_exists($context, $this->children);
    }

    /**
     * Retrieve the children of the current node
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Sorts the children of the TreeNode using a custom comparison function.
     */
    public function sortChildren(callable $func): void
    {
        usort($this->children, $func);
    }

    /**
     * Find a child node by index
     */
    public function findChildByIndex(int $index): ?TreeNodeInterface
    {
        $node = null;
        $this->traverseChildren(function (TreeNodeInterface $child) use (&$node, $index) {
            ($child->index === $index && is_null($node)) ? ($node = $child) : null;
        });
        return $node;
    }

    /**
     * Sets an attribute for the current TreeNode object.
     */
    public function setAttribute(string $name, mixed $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Retrieves the value of a specified attribute from the current TreeNode object.
     */
    public function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Removes a specified attribute from the current TreeNode object.
     */
    public function removeAttribute(string $name): self
    {
        if(array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }
        return $this;
    }

    /**
     * Retrieves all attributes from the current TreeNode object.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Recursively processes an array of children using a callback function.
     */
    public function traverseChildren(callable $callback): void
    {
        array_walk($this->children, function (TreeNodeInterface $child) use ($callback) {
            $callback($child);
            $child->traverseChildren($callback);
        });
    }
}
