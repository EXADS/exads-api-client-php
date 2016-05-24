<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude(array('vendor'))
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'ereg_to_preg',
        'header_comment',
        'no_useless_return',
        'newline_after_open_tag',
        'ordered_use',
        'phpdoc_order',
        'long_array_syntax',
        'strict',
        'strict_param',
    ))
    ->finder($finder)
;
