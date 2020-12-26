<?php


namespace App\Helper;

set_time_limit(0);


class PrioritySorting {


    private $size;
    private $liststart;

    function __construct($comparator) {

        $this->size      = 0;
        $this->liststart = null;
        $this->listend   = null;
    }


    function add($x) {

        $this->size = $this->size + 1;

        if($this->liststart == null) {

            $this->liststart = $this -> next($x);

        } else {

            $node     = $this->liststart;
            $newnode  = $this -> next($x);
            $lastnode = null;
            $added    = false;

            while($node) {

                if ($this->compareRoute($newnode, $node) < 0) {
                    //Higher priority
                    $newnode->next = $node;
                    if ($lastnode == null) {

                        $this->liststart = $newnode;

                    } else {

                        $lastnode->next = $newnode;

                    }

                    $added = true;
                    break;

                }

                $lastnode = $node;
                $node = $node->next;
            }
            if (!$added) {

                $lastnode->next = $newnode;

            }

        }

    }

    public function size() {

        return $this->size;

    }

    public function peak() {

        return $this->liststart->data;

    }

    public function remove() {

        $x = $this->peak();
        $this->size = $this->size - 1;
        $this->liststart = $this->liststart->next;
        return $x;

    }

    public function next( $x )
    {

        $arr = [];
        $arr['next'] = null;
        $arr['data'] = $x;

        return (object) $arr;

    }

    public function compareRoute($a, $b) {

        return $a->data[0] - $b->data[0];

    }


}
