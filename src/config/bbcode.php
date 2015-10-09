<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BBcode-settings
    |--------------------------------------------------------------------------
    */

    'bbcode' => [

        // Enable the WysiBB-editor on create-post-forms and proper decoding of BBCODE.
        'enabled' => true,

        // Enable or disable the allowed BBcode-tags
        'tags'  => [

            // Basic tags
            'b'     => true,    // Bold
            'i'     => true,    // Italics
            'u'     => true,    // Underline
            's'     => true,    // Strike through
            'sup'   => true,    // Super-script
            'sub'   => true,    // Sub-script

            // Links and embeddings
            'img'   => true,    // Image
            'video' => true,    // Video
            'url'   => true,    // Url

            // Lists
            'list'  => true,    // Unordered bullet list
            'olist' => true,    // Ordered numeric list

            // Fonts
            'font'  => true,    // Font family
            'size'  => true,    // Font size
            'color' => true,    // Font color

            // Text alignment
            'left'  => true,    // Align left
            'center'=> true,    // Align center
            'right' => true,    // Align right

            // Misc tags
            'quote' => true,    // Blockquotes
            'code'  => true,    // Code blocks
            'table' => true,    // Tables
        ],

        // Set desired width and height of videos.
        'video_width'   => '320',
        'video_height'  => '240',
    ],

    /*
    |--------------------------------------------------------------------------
    | Emoticon-settings
    |--------------------------------------------------------------------------
    */

    'emoticons' => [

        // Enable emoticons
        'enabled' => true,

        // The path to the folder containing the emoticon-images (incl. trailing slash).
        'path' => '/vendor/mandark/bbcode/img/emoticons/',

        // Mapping of emoticons to a list of smilies that represents it.
        // The smiley will be replaced with an image that uses the emoticon name.
        // You can freely add and configure these emoticons.
        // Just be sure, a png-image with the emoticon-name is present for each of them in the above configured path.
        'list' => [
            'happy'     => [':)', ':]', ':happy:'],
            'wink'      => [';)', ';]', ';D', ':wink:'],
            'sad'       => [':(', ':[', ';(', ';[', ':\'(', ':\'[', ';\'(', ';\'[', ':sad:'],
            'angry'     => ['&gt;(', '&gt;:(', '&gt;[', '&gt;:[', ':angry:'],
            'aw'        => [':aw:'],
            'cool'      => ['8)', '8]', ':cool:'],
            'ecstatic'  => [':D', '8D', ':ecstatic:'],
            'furious'   => ['&gt;:D', '&gt;&lt;', ':furious:'],
            'gah'       => ['D:', ':O', ':gah:'],
            'heart'     => ['&lt;3', ':heart:'],
            'hm'        => [':/', ':\\', ':hm:'],
            'kiss'      => [':3', ':kiss:'],
            'meh'       => [':|', '-.-', '&lt;_&lt;', '&gt;_&gt;', ':meh:'],
            'mmf'       => [':x', ':X', ':mmf:'],
            'tongue'    => [':P', ':p', ':tongue:'],
            'what'      => [':o', ':?', ':what:'],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Censorship-settings
    |--------------------------------------------------------------------------
    */

    'censorship' => [

        // Enable censorship.
        'enabled' => true,

        // List of censored words.
        'list' => [
            'asshole',
            'bitch',
            'btch',
            'blowjob',
            'cock',
            'cawk',
            'clt',
            'clit',
            'clitoris',
            'cock',
            'cocksucker',
            'cum',
            'cunt',
            'cnt',
            'dildo',
            'dick',
            'douche',
            'fag',
            'faggot',
            'fcuk',
            'fuck',
            'fuk',
            'motherfucker',
            'nigga',
            'nigger',
            'nig',
            'penis',
            'pussy',
            'rimjaw',
            'scrotum',
            'shit',
            'sht',
            'slut',
            'twat',
            'whore',
            'whre',
            'vagina',
            'vag',
            'rape',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Misc settings
    |--------------------------------------------------------------------------
    */

    // Convert URLs and emails (not wrapped in tags) into clickable links.
    'auto_links' => true,

];
