<?php

namespace Ucscode\TreeNode\Abstract;

use Ucscode\TreeNode\TreeNode;

abstract class AbstractTreeNodeIterator
{
    abstract public function onIterate(TreeNode $child): void;
    
    private bool $breakIteration = false;
    private bool $continueIteration = false;

    final public function setBreak(): void
    {
        $this->breakIteration = true;
    }

    final public function setContinue(bool $continue = true): void
    {
        $this->continueIteration = $continue;
    }

    final public function hasBreak(): bool
    {
        return $this->breakIteration;
    }

    final public function hasContinue(): bool
    {
        return $this->continueIteration;
    }
}
