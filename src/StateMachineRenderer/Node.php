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
 * State node
 *
 * @package StateMachine
 */
final class Node
{
    /**
     * State name
     *
     * @var string
     */
    private $state;

    /**
     * Additional attributes
     *
     * @var array
     */
    private $attributes;

    /**
     * Create node
     *
     * @param string $name       node name
     * @param array  $attributes additional attributes
     */
    public function __construct($name, array $attributes = [])
    {
        $this->state = $name;
        $this->attributes = $attributes;
    }

    /**
     * Return dot element string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            'node[label="%1$s"%2$s]{ node_%1$s };',
            $this->state,
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
