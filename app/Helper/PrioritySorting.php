<?php


namespace App\Helper;

ini_set('memory_limit','-1' );


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

                if (compareRoute($newnode, $node) < 0) {
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

    function size() {

        return $this->size;

    }

    function peak() {

        return $this->liststart->data;

    }

    function remove() {

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

}
