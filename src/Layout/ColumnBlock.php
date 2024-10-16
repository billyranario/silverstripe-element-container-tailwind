<?php

namespace TheHustle\Layout;

use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;

class ColumnBlock extends BaseElement
{
    private static string $table_name = 'ColumnBlock';
    private static string $title = 'Group';
    private static string $description = 'Orderable list of elements';
    private static string $singular_name = 'Column Block';
    private static string $plural_name = 'Column Blocks';
    private static string $icon = 'font-icon-block-file-list';

    private static $db = [
        'CSSClass' => DBVarchar::class,
        'ColumnWidth' => DBVarchar::class,
        'ColumnWidthSm' => DBVarchar::class,
        'ColumnWidthLg' => DBVarchar::class,
    ];

    private static $column_width_sizes = [
        '' => 'None',
        '1/12' => '1/12 (about 8%)',
        '2/12' => '1/6 (about 17%)',
        '3/12' => '1/4 (25%)',
        '4/12' => '1/3 (33%)',
        '5/12' => '5/12 (about 42%)',
        '6/12' => 'Half (6/12, 50%)',
        '7/12' => '7/12 (about 58%)',
        '8/12' => '2/3 (67%)',
        '9/12' => '3/4 (75%)',
        '10/12' => '5/6 (about 83%)',
        '11/12' => '11/12 (about 92%)',
        '12/12' => 'Full (100%)',
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
        return _t(__CLASS__ . '.BlockType', 'Container Column Blocks');
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

        $cssField = TextField::create('CSSClass', 'Column CSS Class');

        $columnWidthSizes = self::$column_width_sizes;

        $fields->addFieldsToTab('Root.Main', [
            DropdownField::create('ColumnWidth', 'Desktop Width', $columnWidthSizes),
            DropdownField::create('ColumnWidthLg', 'Tablet Width (Large)', $columnWidthSizes),
            DropdownField::create('ColumnWidthSm', 'Mobile Width (Small)', $columnWidthSizes),
            $cssField->setDescription('Separate multiple classes with spaces. e.g., "bg-primary"')
        ]);

        return $fields;
    }

    public function getTailwindColumnClass()
    {
        $classes = [];

        if ($this->ColumnWidth) {
            $classes[] = 'lg:w-' . str_replace('/', '-', $this->ColumnWidth);
        }

        if ($this->ColumnWidthLg) {
            $classes[] = 'md:w-' . str_replace('/', '-', $this->ColumnWidthLg);
        }

        if ($this->ColumnWidthSm) {
            $classes[] = 'sm:w-' . str_replace('/', '-', $this->ColumnWidthSm);
        }

        return implode(' ', $classes);
    }
}
