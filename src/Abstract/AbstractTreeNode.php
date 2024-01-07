<?php

namespace Ucscode\TreeNode\Abstract;

use ReflectionClass;
use Ucscode\TreeNode\Interface\TreeNodeInterface;
use Ucscode\TreeNode\TreeNode;

abstract class AbstractTreeNode implements TreeNodeInterface
{
    protected int $level = 0;
    protected string $identity = '';
    protected array $children = [];
    protected array $attributes = [];
    protected static int $lastIndex = 0;
    
    public readonly int $index;
    public readonly ?string $name;
    protected ?TreeNode $parent = null;

    /**
     * Creates a new instance of the TreeNode class.
     *
     * @param string|null $name The name of the node. Defaults to the class name if not provided.
     * @param array $attributes The attributes of the node, specified as an associative array.
     */
    public function __construct(?string $name = null, array $attributes = [])
    {
        $this->index = self::$lastIndex;
        $this->identity = $this::class . '::' . (!$this->index ? 'ROOT' : 'INDEX_' . $this->index);
        $this->name = $name;
        array_walk($attributes, fn ($value, $key) => $this->setAttribute($key, $value));
        self::$lastIndex++;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIndex(): int
    {
        return $this->index;
    }
    
    public function getIdentity(): string
    {
        return $this->identity;
    }

    protected function inlineNodeRecursion(array $children, callable $callback): ?TreeNode
    {
        foreach($children as $child) {
            $value = $callback($child);
            $value ??= $this->inlineNodeRecursion($child->children, $callback);
            if($value !== null) {
                return $value;
            }
        };
        return null;
    }

    protected function childrenParser(array $children, AbstractIterator $iterator): void
    {
        foreach($children as $child) {

            $iterator->onIterate($child);

            if($iterator->hasBreak()) {
                break;
            }

            if($iterator->hasContinue()) {
                $iterator->setContinue(false);
                continue;
            }

            $this->childrenParser(
                $child->children,
                (new ReflectionClass($iterator))->newInstance()
            );

        };
    }
}