<?php

namespace BladeStyle\Sass;

use BladeStyle\Compiler\Compiler;
use BladeStyle\Engines\MinifierEngine;
use BladeStyle\Exceptions\StyleException;
use Illuminate\Filesystem\Filesystem;
use ScssPhp\ScssPhp\Compiler as ScssPhp;
use ScssPhp\ScssPhp\Exception\ParserException;

class SassCompiler extends Compiler
{
    /**
     * Sass compiler.
     *
     * @var \ScssPhp\ScssPhp\Compiler
     */
    protected $sass;

    /**
     * Create a new compiler instance.
     *
     * @param \BladeStyle\Engines\MinifierEngine $engine
     * @param \Illuminate\Filesystem\Filesystem  $files
     * @param string                             $cachePath
     *
     * @return void
     */
    public function __construct(MinifierEngine $engine, Filesystem $files, $cachePath)
    {
        parent::__construct($engine, $files, $cachePath);

        $this->sass = new ScssPhp();
    }

    /**
     * Compile style string.
     *
     * @see https://github.com/scssphp/scssphp
     *
     * @param  string $style
     * @return string
     *
     * @throws StyleException
     */
    public function compileString($style)
    {
        try {
            return $this->sass->compile($style);
        } catch (ParserException $e) {
            throw new StyleException($e->getMessage());
        }
    }
}
