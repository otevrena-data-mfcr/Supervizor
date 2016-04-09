<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette;

/**
 * Class BudgetGroup
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="budget_group")
 */
class BudgetGroup extends Nette\Object
{
    use Identifier;
    
    /**
     * @var string
     * @ORM\Column(type="string",length=255,nullable=false)
     */
    private $name;
    
    /**
     * @var string
     * @ORM\Column(type="string",length=6000,nullable=false)
     */
    private $description;
    
    /**
     * @var int
     * @ORM\Column(type="integer",nullable=false)
     */
    private $x;
    
    /**
     * @var int
     * @ORM\Column(type="integer",nullable=false)
     */
    private $y;
    
    /**
     * @var string
     * @ORM\Column(type="string",length=6,nullable=false)
     */
    private $color;
    
    /**
     * @var ArrayCollection|BudgetItem[]
     * @ORM\OneToMany(targetEntity="BudgetItem", mappedBy="budgetGroup",cascade={"persist"})
     */
    private $budgetItems;
    
    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $created;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $updated;

    /**
     * BudgetGroup constructor.
     * @param string $name
     * @param string $description
     * @param int $x
     * @param int $y
     * @param string $color
     */
    public function __construct($name, $description, $x, $y, $color)
    {
        $this->name = $name;
        $this->description = $description;
        $this->setX($x);
        $this->setY($y);
        $this->setColor($color);
        $this->budgetItems = new ArrayCollection();
    }
    
    /**
     * @param int $x
     */
    protected function setX($x)
    {
        if (!is_numeric($x) || !$x) 
        {
            throw new Nette\InvalidArgumentException('Invalid $x value');
        }
        $this->x = $x;
    }
    
    /**
     * @param int $y
     */
    protected function setY($y)
    {
        if (!is_numeric($y) || !$y) 
        {
            throw new Nette\InvalidArgumentException('Invalid $y value');
        }
        $this->y = $y;
    }
    
    /**
     * @param string $color
     */
    protected function setColor($color)
    {
        if (Nette\Utils\Strings::length($color) !== 6)  
        {
            throw new Nette\InvalidArgumentException('Invalid $color value');
        }
        $this->color = $color;
    }
    
    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = $this->updated = new \DateTime();
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime();
    }
    
    /**
     * @return BudgetItems[]|ArrayCollection
     */
    public function getPlanets()
    {
        return $this->budgetItems;
    }
}
