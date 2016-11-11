<?php

namespace OpenCephalonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="item_id_atom", uniqueConstraints={@ORM\UniqueConstraint(name="item_id_atom_guid", columns={"source_id", "guid"})})
 * @ORM\HasLifecycleCallbacks
 */
class ItemIdAtom
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=false)
     */
    private $source;


    /**
     * @var string
     *
     * @ORM\Column(name="guid", type="text", nullable=true)
     */
    private $guid;

    /**
     * @return string
     */
    public function getGuid() {
        return $this->guid;
    }

    /**
     * @param string $guid
     */
    public function setGuid( $guid ) {
        $this->guid = $guid;
    }

    /**
     * @return mixed
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem( $item ) {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource( $source ) {
        $this->source = $source;
    }







}

