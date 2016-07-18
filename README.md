StateMachine Renderer
=====================

For ease of designing StateMachine processes, `Renderer` present any processes as graphs in `PNG` or `SVG` files.

```php
$process = (new ArrayAdapter($schema))->getProcess();
$document = Document::fromProcess($process);
$renderer = new Renderer('/usr/bin/dot');
$pathToPng = $renderer->png($document, 'dot.png');
$pathToSvg = $renderer->svg($document, 'dot.svg');
```

`Renderer` requires [Graphviz](http://www.graphviz.org/) to draw graphs.
