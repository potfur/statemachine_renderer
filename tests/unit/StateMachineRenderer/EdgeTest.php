<?php

/*
* This file is part of the NodeMachineRenderer package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace unit\NodeMachineRenderer;

use StateMachineRenderer\Edge;

class EdgeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateWithAttributes()
    {
        $result = (string) new Edge('fromNode', 'toNode', 'eventName', ['color' => '#FF00FF']);
        $this->assertEquals('edge[label=" eventName",color="#FF00FF"] node_fromNode -> node_toNode;', $result);
    }

    public function testCreateForTargetTransition()
    {
        $result = (string) Edge::targetTransition('fromNode', 'toNode', 'eventName');
        $this->assertEquals('edge[label=" eventName",color="#66FF00"] node_fromNode -> node_toNode;', $result);
    }

    public function testCreateForErrorTransition()
    {
        $result = (string) Edge::errorTransition('fromNode', 'toNode', 'eventName');
        $this->assertEquals('edge[label=" eventName",color="#FF2200"] node_fromNode -> node_toNode;', $result);
    }
}
