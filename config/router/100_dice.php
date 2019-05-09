<?php
/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "Dice controller",
            "mount" => "dice1",
            "handler" => "\Mada\Dice\DiceController",
        ],

    ]
];