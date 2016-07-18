<?php

/*
* This file is part of the StateMachineRenderer package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace unit\StateMachineRenderer;

use StateMachineRenderer\Node;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateWithAttributes()
    {
        $result = (string) new Node('nodeName', ['color' => '#FF00FF']);
        $this->assertEquals('node[label="nodeName",color="#FF00FF"]{ node_nodeName };', $result);
    }
}
