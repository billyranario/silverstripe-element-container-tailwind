<?php

namespace TheHustle\Layout;

use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;

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
        'Columns' => DBInt::class
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

        $columnsField = NumericField::create('Columns', 'Number of Columns')
            ->setDescription('Define the number of columns for this container')
            ->setMin(1)
            ->setMax(12)
            ->setValue(1); // Default to 1 column

        $fields->addFieldsToTab('Root.Main', [
            $cssClassField,
            $noGuttersField,
            $columnsField
        ]);

        return $fields;
    }

    public function getGridClasses()
    {
        $columns = $this->Columns ?: 1;  // Default to 1 if not set
        $gutterClass = $this->NoGutters ? 'gap-0' : 'gap-4';

        return "grid grid-cols-1 md:grid-cols-{$columns} {$gutterClass}";
    }
}
