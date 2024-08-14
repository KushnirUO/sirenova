<?php 
class Footer_Menu_Walker extends Walker_Nav_Menu {
    // Starts the list before the elements are added.
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"footer-catalog__list js-footer-category-list hide\">\n";
    }

    // Ends the list of after the elements are added.
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    // Starts the element output.
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        if ($depth == 0) {
            $output .= $indent . '<div class="footer-catalog__block js-footer-category-block">';
            $output .= '<h3 class="footer-catalog__title ">';
            $output .= '<a href="' . esc_attr($item->url) . '">' . esc_html($item->title) . '</a>';
            $output .= '<div class="js-footer-category-toggle-btn"><span class="caret"></span></div>';
            $output .= '</h3>';
        } else {
            $output .= $indent . '<li class="footer-catalog__list-item">';
            $output .= '<a class="footer-catalog__list-link" href="' . esc_attr($item->url) . '">' . esc_html($item->title) . '</a>';
            $output .= '</li>';
        }
    }

    // Ends the element output, if needed.
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        if ($depth == 0) {
            $output .= '</div>';
        }
    }
}

?>
