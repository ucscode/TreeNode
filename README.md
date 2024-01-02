# TreeNode: Simplifying Parent-Child Relationships

The `TreeNode` class is a versatile tool designed to simplify the management of parent-child relationships within a hierarchical structure. It is efficient in dealing with organizational charts, family trees, or any scenario involving hierarchical data and also provides an intuitive way to handle relationships.

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
  - [Creating Root Node](#creating-root-node)
  - [Creating Children](#creating-children)
  - [Adding A Child](#adding-a-child)
  - [Getting A Child](#getting-a-child)
  - [Removing A Child](#removing-a-child)
  - [Getting Children](#getting-children)
  - [Getting Ancestors](#getting-ancestors)
  - [Getting A Child Attribute](#getting-a-child-attribute)
  - [Setting A Child Attribute](#setting-a-child-attribute)
  - [Removing A Child Attribute](#removing-a-child-attribute)
- [Conclusion](#conclusion)

## Introduction

Managing hierarchical relationships can be complex, especially when dealing with varying levels of parent-child connections. The `TreeNode` class aims to streamline this process by providing methods to add relationships, retrieve children, and find ancestors within the hierarchy.

## Installation

To use the `TreeNode` class, follow these simple steps:

1. Download the class file.
2. Include the file in your project.
3. Instantiate the class to start managing your hierarchical data.

For Composer Installation

```bash
composer require ucscode/tree-node
```

## Usage

### Creating Root Node

```php
use Ucscode\TreeNode\TreeNode;

$ceo = new TreeNode('Ucscode');
```

### Creating Children

```php
// Create Children with (or without) name & attribute

$manager = new TreeNode('Elizabeth');

$staff = new TreeNode('Serena Paul', ['active' => true]);

$staff2 = new TreeNode(null, ['name' => 'Unknown'])
```

### Adding A Child

```php
// Position each node under a dedicated parent

$ceo->addChild('manager', $manager);

$manager->addChild('staff', $staff);

$manager->addChild('staff2', $staff2);
```

### Getting A Child

```php
$manager = $ceo->getChild('manager');
```

## Removing A Child

```php
$manager->removeChild('supervisor');
```

### Getting Children

```php
$manager->getChildren(); // Array of TreeNodes
```
This retrieves an array of children for the `SuperVisor` node, which, in this case, would include `Staff` and `Staff 2`.

### Getting Ancestors

TreeNode also allows `Chaining` in the opposite direction.

```php
$staff2 = $treeNode->getParent(); // Manager

$ceo = $staff2
        ->getParent() // Manager
            ->getParent(); // Ceo
```

This returns an array of ancestors for the 'Supervisor' context. In the example above, it would include 'Manager' and 'CEO'.

## Getting A Child Attribute

```php
$staff2->getAttribute('name'); // "Unknown"
```

### Setting A Child Attribute

```php
$ceo->setAttribute('location', 'Log Angeles');
```

### Removing A Child Attribute

```php
$staff->removeAttribute('active');
```

## Conclusion

The `TreeNode` class provides a straightforward solution for handling hierarchical relationships. By offering methods to add relationships, retrieve children, and find ancestors, this class empowers developers to efficiently manage and navigate complex hierarchical structures in their applications. Simplify your hierarchical data management with the `TreeNode` class today!