<?php

/*
* This file is part of the statemachine package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace StateMachine\Renderer;

use StateMachine\Event;
use StateMachine\Process;
use StateMachine\State;
use StateMachineRenderer\Document;
use StateMachineRenderer\Edge;
use StateMachineRenderer\Node;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testAddState()
    {
        $document = new Document('test');
        $document->addNode(new Node('nodeName'));

        $this->assertEquals(
            'digraph test {dpi="75";pad="1";fontname="Courier";nodesep="1";rankdir="TD";ranksep="0.5";node[label="nodeName"]{ node_nodeName };}',
            (string) $document
        );
    }

    public function testAddEdge()
    {
        $document = new Document('test');
        $document->addNode(new Node('fromNode'));
        $document->addNode(new Node('toNode'));
        $document->addEdge(new Edge('fromNode', 'toNode', 'eventName'));

        $this->assertEquals(
            'digraph test {dpi="75";pad="1";fontname="Courier";nodesep="1";rankdir="TD";ranksep="0.5";node[label="fromNode"]{ node_fromNode };node[label="toNode"]{ node_toNode };edge[label=" eventName"] node_fromNode -> node_toNode;}',
            (string) $document
        );
    }

    public function testCreateFromProcess()
    {
        $process = new Process('test', 'fromNode', [
            new State('fromNode', [new Event('eventName', 'targetNode', 'errorNode')]),
            new State('targetNode'),
            new State('errorNode'),
        ]);

        $document = Document::fromProcess($process);

        $this->assertEquals(
            'digraph test {dpi="75";pad="1";fontname="Courier";nodesep="1";rankdir="TD";ranksep="0.5";node[label="fromNode"]{ node_fromNode };node[label="targetNode"]{ node_targetNode };node[label="errorNode"]{ node_errorNode };edge[label=" eventName",color="#66FF00"] node_fromNode -> node_targetNode;edge[label=" eventName",color="#FF2200"] node_fromNode -> node_errorNode;}',
            (string) $document
        );
    }
}
