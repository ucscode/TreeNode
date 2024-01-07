<?php

namespace Ucscode\TreeNode;

use Exception;
use Ucscode\TreeNode\Abstract\AbstractTreeNode;

class TreeNode extends AbstractTreeNode
{
    /**
     * Adds a child node to the current TreeNode object.
     */
    public function addChild(string $name, array|TreeNode $component = []): TreeNode
    {
        if (!empty($this->children[$name])) {
            throw new Exception(
                sprintf("Duplicate Child: '%s' already added to '%s'", $name, $this->name)
            );
        }

        $child = ($component instanceof TreeNode) ? $component : new self($name, $component);
        $child->parent = $this;
        $child->level = $this->level + 1;
        $child->traverseChildren(fn (TreeNode $node) => $node->level = ($node->parent->level + 1));

        return $this->children[$name] = $child;
    }

    /**
     * Retrieves a child node from the current TreeNode object.
     */
    public function getChild(string $name): ?TreeNode
    {
        return $this->children[$name] ?? null;
    }

    /**
     * Removes a child node from the current TreeNode object.
     */
    public function removeChild(string|TreeNode $context): ?TreeNode
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
    public function hasChild(string|TreeNode $context): bool
    {
        return ($context instanceof TreeNode) ?
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
    public function findChildByIndex(int $index): ?TreeNode
    {
        $node = null;
        $this->traverseChildren(function (TreeNode $child) use (&$node, $index) {
            ($child->index === $index && is_null($node)) ? ($node = $child) : null;
        });
        return $node;
    }

    /**
     * Get the parent node of the current node
     */
    public function getParent(): ?TreeNode
    {
        return $this->parent;
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
        array_walk($this->children, function (TreeNode $child) use ($callback) {
            $callback($child);
            $child->traverseChildren($callback);
        });
    }

    /**
     * Debug Information
     *
     * Render the most relevant node information for debugging purpose
     */
    public function __debuginfo(): array
    {
        $debugInfo = [
            '::identity' => $this->identity,
            'name' => $this->name,
            'index' => $this->index,
            'level' => $this->level,
        ];

        $optional = [
            'attributes' => $this->attributes,
            'children' => $this->children,
        ];

        foreach($optional as $name => $value) {
            if(!empty($this->{$name}) || $this->level) {
                $debugInfo[$name] = $value;
            }
        };

        $parentName = $this->parent->name ?? 'NULL';
        $debugInfo['::parent'] = !$this->parent ? null : $this->parent->identity . " ({$parentName})";

        return $debugInfo;
    }
}
