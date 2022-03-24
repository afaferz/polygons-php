<?php

require_once(__DIR__ . '/vendor/autoload.php');

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Action\ExitAction;
use PhpSchool\CliMenu\MenuItem\AsciiArtItem;
use Polygons\Php\Model\Rectangle;
use Polygons\Php\Model\Square;
use Polygons\Php\Model\Triangle;

$art = <<<ART
        _ __ _
       / |..| \
       \/ || \/
        |_''_|
      PHP SCHOOL
LEARNING FOR ELEPHANTS
ART;

$choise = "";
$sides = [];

$itemCallable = function (CliMenu $menu) {
    $GLOBALS['choise'] = $menu->getSelectedItemIndex() - 1;
    $itemText = $menu->getSelectedItem()->getText();

    switch ($itemText) {
        case "Triangle":
            $placeholder = 'Ex: 3,4,5';
            break;
        case "Square":
            $placeholder = 'Ex: 2,2,2,2';
            break;
        case "Rectangle":
            $placeholder = 'Ex: 2,7,2,7';
            break;
    }

    $result = $menu->askText()
        ->setPromptText("Enter values of side {$itemText}")
        ->setPlaceholderText("{$placeholder}")
        ->setValidationFailedText('Please enter your name')
        ->ask();

    $arrayValues = explode(",", $result->fetch());
    $GLOBALS['sides'] = array_map("intval", $arrayValues);

    execute($GLOBALS['choise'], $GLOBALS['sides']);
};

$exit = function (CliMenu $menu) {
    $menu->close();
};

$menu = (new CliMenuBuilder)
    ->addAsciiArt($art, AsciiArtItem::POSITION_LEFT)
    ->addLineBreak('=')
    ->disableDefaultItems()
    ->setTitle('Select a polygon')
    ->addItems([
        ['Triangle', $itemCallable],
        ['Square', $itemCallable],
        ['Rectangle', $itemCallable],
    ])
    ->addItem("I want a CIRCLE :'( - EXIT", new ExitAction)
    ->addLineBreak('-')
    ->setTitle('Press X to close')
    ->setBorder(1, 2, 'black')
    ->setPadding(2, 4)
    ->setMarginAuto()
    ->build();

$menu->addCustomControlMapping("x", $exit);

$menu->open();

function execute(int $choise, array $sides)
{
    $options = [
        Triangle::class,
        Square::class,
        Rectangle::class
    ];
    if ($choise != "") {
        $polygon = new $options[$choise - 1]($sides);
        $polygon->executeAll();

        $vars = array(
            '$perimeter' => number_format($polygon->perimeter, 2),
            '$area' => number_format($polygon->area, 2),
            '$sumOfAngles' => $polygon->sumOfAngles,
            '$numberOfDiagonals' => $polygon->numberOfDiagonals,
        );

        // Formatar depois
        $template = '
            ---------------------------------------------
            | PERIMETER: $perimeter cm                          |
            | AREA: $area cm                                |
            | NUMBER OF DIAGONALS: $numberOfDiagonals;                  |
            | SUM OF ANGLES: $sumOfAngles°;                      |
            ---------------------------------------------
        ';

        echo strtr($template, $vars);
    }
};
