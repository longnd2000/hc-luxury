<?php
/**
 * Widget Name: LX Breadcrumbs
 * Description: Hiển thị đường dẫn (Breadcrumbs) thông qua hệ thống lx_get_breadcrumbs.
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;

class LX_Breadcrumbs_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'lx_breadcrumbs_widget';
    }

    public function get_title()
    {
        return __('LX — Breadcrumbs', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-product-breadcrumbs';
    }

    public function get_categories()
    {
        return ['lx_breadcrumbs'];
    }

    protected function render()
    {
        if (function_exists('lx_get_breadcrumbs')) {
            echo lx_get_breadcrumbs();
        }
    }
}
