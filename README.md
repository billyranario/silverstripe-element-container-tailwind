## Installation

Install the module via Composer:

```bash
composer require thehustle/silverstripe-element-container-tailwind
```

This command installs its dependencies as well, including the `dnadesign/silverstripe-elemental` module and `dnadesign/silverstripe-elemental-list` module so you don't have to install them separately.

After installation, you will need to run `http://yourdomain.com/dev/build` or `http://yourdomain.com/dev/build?flush=all` to create the database tables and flush the cache.

## Overriding Layouts

To override Container Block and Column Block layouts, you can create a new template file in your app/templates directory. 

Make sure to follow the Namespace and Directory structure of the original template file.

```bash
mkdir app/templates/TheHustle/Layout/
touch ColumnBlock.ss
touch ContainerBlock.ss
```

Don't forget to run `dev/build` or `dev/build?flush=all` after creating the new template files.

```bash
http://yourdomain.com/dev/build

```

or 

```bash
http://yourdomain.com/dev/build?flush=all
```

## Styling
After running the tasks, there will be files being copied to your root directory. 

`/assets/css/layout.css`

Move the file to your theme's css directory and include it in your theme's `Page.ss` file.
