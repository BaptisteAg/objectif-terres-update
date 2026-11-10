<?php

return [

    /*
    |--------------------------------------------------------------------------------
    | CKEditor Model
    |--------------------------------------------------------------------------------
    |
    | The fully qualified class name of models.
    |
    */

    'attachment_model' => \NumaxLab\NovaCKEditor5Classic\Models\Attachment::class,
    'pending_attachment_model' => \NumaxLab\NovaCKEditor5Classic\Models\PendingAttachment::class,

    /*
    |--------------------------------------------------------------------------------
    | CKEditor Options
    |--------------------------------------------------------------------------------
    |
    | To view a list of all available options checkout the CKEditor API documentation
    | https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/configuration.html
    |
    */

    'options' => [
        'language' => 'fr',
        'toolbar' => [
            'Heading',
            'Bold',
            'Italic',
            '-',
            'Link',
            'styles' => [
                // This option is equal to a situation where no style is applied.
                'full',
                // This represents an image aligned to the left.
                'alignLeft',
                // This represents an image aligned to the right.
                'alignRight',
            ],
            '-',
            'NumberedList',
            'BulletedList',
            'BlockQuote',
            '-',
            'MediaEmbed',
            'imageUpload',
            '-',
            'undo',
            'redo',
        ],
        'image' => [
            'toolbar' => [
                'imageTextAlternative', '|',
                'imageStyle:alignLeft',
                'imageStyle:full',
                'imageStyle:alignRight',
            ],
            'styles' => [
                // This option is equal to a situation where no style is applied.
                'full',
                // This represents an image aligned to the left.
                'alignLeft',
                // This represents an image aligned to the right.
                'alignRight',
            ],
        ],
        'heading' => [
            'options' => [
                ['model' => 'paragraph', 'title' => 'Paragraphe', 'class' => 'ck-heading_paragraph'],
                ['model' => 'heading1', 'view' => 'h1', 'title' => 'Titre 1', 'class' => 'ck-heading_heading1'],
                ['model' => 'heading2', 'view' => 'h2', 'title' => 'Titre 2', 'class' => 'ck-heading_heading2'],
                ['model' => 'heading3', 'view' => 'h3', 'title' => 'Titre 3', 'class' => 'ck-heading_heading3'],
                ['model' => 'heading4', 'view' => 'h4', 'title' => 'Titre 4', 'class' => 'ck-heading_heading4'],
            ],
        ],
    ],

];
