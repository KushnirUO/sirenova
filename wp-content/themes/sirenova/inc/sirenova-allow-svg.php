<?php
// Allow uploading of SVG files
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Allow SVG to be displayed in the media library
function fix_svg_display()
{
    echo '<style>
    .attachment-svg {
        max-width: 100%;
        height: auto;
    }

    .wp-post-image {
        max-width: 100%;
        height: auto;
    }
</style>';
}
add_action('admin_head', 'fix_svg_display');