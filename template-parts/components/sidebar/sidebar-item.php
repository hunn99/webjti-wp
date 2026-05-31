<?php
/**
 * Sidebar Menu Item
 *
 * @package WebJTI_Theme
 */

$item =
    $args['item'] ?? [];

if (empty($item)) {
    return;
}

$current_url =
    trim(
        parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        ),
        '/'
    );

$current_clean = trim($current_url, '/');
$item_clean    = trim($item['slug'], '/');
$is_active     = ($current_clean === $item_clean) || (!empty($item_clean) && strpos($current_clean, $item_clean . '/') === 0);

$icon_class =
    $is_active
        ? 'ph-fill ph-' . $item['icon']
        : 'ph ph-' . $item['icon'];

?>

<li class="sidebar-menu-item <?php echo $is_active ? 'active' : ''; ?>">

    <a
        href="<?php echo esc_url(home_url('/' . $item['slug'])); ?>"
        class="sidebar-menu-link"
    >

        <span class="sidebar-menu-icon">

            <i class="<?php echo esc_attr($icon_class); ?>"></i>

        </span>

        <span class="sidebar-menu-text">

            <?php echo esc_html($item['label']); ?>

        </span>

    </a>

</li>