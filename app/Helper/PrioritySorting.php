<?php


namespace App\Helper;

set_time_limit(0);


class PrioritySorting {


    private $size;
    private $listStart;

    function __construct() {

        $this->size      = 0;
        $this->listStart = null;
    }


    public function size() {

        return $this->size;

    }


    public function peak() {

        return $this->listStart->data;

    }


    public function compareRoute($a, $b) {

        return $a->data[0] - $b->data[0];

    }


    function add($x) {

        $this->size = $this->size + 1;

        if($this->listStart == null) {

             return $this->listStart = $this -> next($x);

        }

        $node     = $this->listStart;
        $newNode  = $this -> next($x);
        $lastNode = null;
        $added    = false;

        while($node) {
            if ($this->compareRoute($newNode, $node) < 0) {
                //Higher priority
                $newNode->next = $node;
                $lastNode == null ? $this->listStart = $newNode : $lastNode->next = $newNode;
                $added = true;
                break;
            }

            $lastNode = $node;
            $node = $node->next;
        }
        if (!$added) {
            $lastNode->next = $newNode;
        }

    }


    public function remove() {

        $x = $this->peak();
        $this->size = $this->size - 1;
        $this->listStart = $this->listStart->next;
        return $x;

    }


    public function next( $x )
    {

        $arr = [];
        $arr['next'] = null;
        $arr['data'] = $x;

        return (object)$arr;

    }


}
