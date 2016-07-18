<?php

/*
* This file is part of the StateMachineRenderer package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace StateMachineRenderer;

use StateMachine\Process;

/**
 * Process
 *
 * @package StateMachine
 */
final class Document
{
    /**
     * Document name
     *
     * @var string
     */
    private $name;

    /**
     * Document density
     *
     * @var int
     */
    private $dpi;

    /**
     * Font style
     *
     * @var string
     */
    private $font;

    /**
     * List of states
     *
     * @var Node[]
     */
    private $nodes = [];

    /**
     * List of edges
     *
     * @var Edge[]
     */
    private $edges = [];

    /**
     * Constructor
     *
     * @param string $name document name
     * @param int    $dpi  density
     * @param string $font font family
     */
    public function __construct($name, $dpi = 75, $font = 'Courier')
    {
        $this->name = $name;
        $this->dpi = (int) $dpi;
        $this->font = $font;
    }

    /**
     * Create document from Process
     *
     * @param Process $process
     *
     * @return Document
     */
    public static function fromProcess(Process $process): Document
    {
        $document = new Document($process->name());

        foreach ($process->states() as $state) {
            $document->addNode(new Node($state->name()));

            foreach ($state->events() as $event) {
                $transitions = array_filter(['target' => $event->targetState(), 'error' => $event->errorState()]);
                foreach ($transitions as $type => $target) {
                    switch($type) {
                        case 'target':
                            $document->addEdge(Edge::targetTransition($state->name(), $target, $event->name()));
                            break;
                        case 'error':
                            $document->addEdge(Edge::errorTransition($state->name(), $target, $event->name()));
                            break;
                        default:
                            $document->addEdge(new Edge($state->name(), $target, $event->name()));
                    }
                }
            }
        }

        return $document;
    }

    /**
     * Add state to process
     *
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * Add state to process
     *
     * @param Edge $edge
     */
    public function addEdge(Edge $edge)
    {
        $this->edges[] = $edge;
    }

    /**
     * Return dot element string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            'digraph %1$s {dpi="%2$s";pad="1";fontname="%3$s";nodesep="1";rankdir="TD";ranksep="0.5";%4$s%5$s}',
            $this->name,
            $this->dpi,
            $this->font,
            implode($this->nodes),
            implode($this->edges)
        );
    }
}
