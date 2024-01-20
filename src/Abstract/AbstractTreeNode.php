<?php

namespace Ucscode\TreeNode\Abstract;

use Exception;
use Ucscode\TreeNode\Interface\TreeNodeInterface;

abstract class AbstractTreeNode extends AbstractTreeNodeFoundation
{
    /**
     * Get the parent node of the current node
     */
    public function getParent(): ?TreeNodeInterface
    {
        return $this->parent;
    }

    public function getParents(): array
    {
        $parents = [];
        $node = $this;
        while($node) {
            $node = $node->getParent();
            $parents[] = $node;
        }
        return array_filter($parents);
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

    protected function balanceChildren(string $name): void
    {
        if (!empty($this->children[$name])) {
            throw new Exception(
                sprintf("Duplicate Child: '%s' already added to '%s'", $name, $this->name)
            );
        }
    }
}