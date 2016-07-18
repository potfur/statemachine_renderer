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

/**
 * Edge representing state machine event target and error path
 *
 * @package StateMachine
 */
final class Edge
{
    /**
     * Source state name
     *
     * @var string
     */
    private $fronNode;

    /**
     * Target state name
     *
     * @var string
     */
    private $toNode;

    /**
     * Event name
     *
     * @var string
     */
    private $event;

    /**
     * Style
     *
     * @var array
     */
    private $attributes;

    /**
     * Build edge/path between two nodes in dot format
     *
     * @param string $fromNode   source state
     * @param string $toNode     target state
     * @param string $event      event name
     * @param array  $attributes additional attributes
     */
    public function __construct($fromNode, $toNode, $event, array $attributes = [])
    {
        $this->fronNode = $fromNode;
        $this->toNode = $toNode;
        $this->event = $event;
        $this->attributes = $attributes;
    }

    /**
     * Create target transition (green)
     *
     * @param string $fromState
     * @param string $toState
     * @param string $event
     * @param array  $attributes
     *
     * @return Edge
     */
    public static function targetTransition($fromState, $toState, $event, array $attributes = []): Edge
    {
        return new static($fromState, $toState, $event, array_merge(['color' => '#66FF00'], $attributes));
    }

    /**
     * Create error transition (red)
     *
     * @param string $fromState
     * @param string $toState
     * @param string $event
     * @param array  $attributes
     *
     * @return Edge
     */
    public static function errorTransition($fromState, $toState, $event, array $attributes = []): Edge
    {
        return new static($fromState, $toState, $event, array_merge(['color' => '#FF2200'], $attributes));
    }

    /**
     * Return dot element string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            'edge[label=" %3$s"%4$s] node_%1$s -> node_%2$s;',
            $this->fronNode,
            $this->toNode,
            $this->event,
            $this->implodeAttributes($this->attributes)
        );
    }

    /**
     * Implodes attributes
     *
     * @param array $attributes
     *
     * @return string
     */
    private function implodeAttributes(array $attributes): string
    {
        $result = [];
        foreach ($attributes as $name => $value) {
            $result[] = sprintf('%s="%s"', $name, $value);
        }

        return empty($result) ? '' : ',' . implode(',', $result);
    }
}
