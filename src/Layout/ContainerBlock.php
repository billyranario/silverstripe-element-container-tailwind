<?php

namespace TheHustle\Layout;

use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;

class ContainerBlock extends BaseElement
{
    private static string $table_name = 'ContainerBlock';
    private static string $title = 'Group';
    private static string $description = 'Orderable list of elements';
    private static string $singular_name = 'Container Block';
    private static string $plural_name = 'Container Blocks';
    private static string $icon = 'font-icon-block-file-list';

    private static $db = [
        'CSSClass' => DBVarchar::class,
        'NoGutters' => DBBoolean::class,
    ];

    private static $has_one = [
        'Elements' => ElementalArea::class,
        'BackgroundImage' => Image::class,
    ];

    private static $owns = [
        'BackgroundImage',
        'Elements'
    ];

    private static array $cascade_deletes = [
        'Elements'
    ];

    private static array $cascade_duplicates = [
        'Elements'
    ];

    private static array $extensions = [
        ElementalAreasExtension::class
    ];

    public function getType(): string
    {
        return _t(__CLASS__ . '.BlockType', 'Container Blocks');
    }

    public function getSummary(): string
    {
        $count = $this->Elements()->Elements()->Count();
        $suffix = $count === 1 ? 'element' : 'elements';

        return 'Contains ' . $count . ' ' . $suffix;
    }

    public function getOwnedAreaRelationName(): string
    {
        $has_one = $this->config()->get('has_one');

        foreach ($has_one as $relationName => $relationClass) {
            if ($relationClass === ElementalArea::class && $relationName !== 'Parent') {
                return $relationName;
            }
        }

        return 'Elements';
    }

    public function inlineEditable(): bool
    {
        return false;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $cssClassField = TextField::create('CSSClass', 'Container CSS Class')
            ->setDescription('Add custom Tailwind or other CSS classes for the container.');

        $noGuttersField = CheckboxField::create('NoGutters', 'Remove Gutters (Padding)')
            ->setDescription('Removes padding from the container when checked.');

        $fields->addFieldsToTab('Root.Main', [
            $cssClassField,
            $noGuttersField
        ]);

        return $fields;
    }

    public function getContainerClasses()
    {
        $classes = ['relative', 'w-full'];

        if ($this->NoGutters) {
            $classes[] = 'p-0';
        } else {
            $classes[] = 'px-4';  // Default padding if gutters are enabled
        }

        if ($this->CSSClass) {
            $classes[] = $this->CSSClass;
        }

        return implode(' ', $classes);
    }
}
