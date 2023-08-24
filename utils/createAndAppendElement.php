<?php

function createAndAppendElement($name, $value, $container, $dom) {
    $element = $dom->createElement($name, $value);
    $container->appendChild($element);
};