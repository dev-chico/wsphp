<?php

function createAndAppendAttribute($name, $value, $container, $dom) {
    $attr = $dom->createAttribute($name);
    $attr->value = $value;
    $container->appendChild($attr);
};