<?php

namespace TheHustle\Layout;

use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Assets\Image;

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

    public function inlineEditable(): bool
    {
        return false;
    }
}
