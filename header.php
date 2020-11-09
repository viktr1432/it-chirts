<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>

<body>
    <!-- modal -->
    <div class="modal" id="modal">
        <div class="modal__body">
            <div class="modal__header">
                <span class="modal__header-title">Корзина</span>
                <div data-close-button class="close-button"></div>
            </div>
            <div class="modal__content">

                    <div class="cart__item">
                        <div class="cart__item-del">
                            <a href="" class="cart__item-icon"></a>
                        </div>
                        <div class="cart__item-img">
                            <a href="ptoduct__link">
                                <img src="img/img1.jpg" alt="">
                            </a>
                        </div>
                        <div class="cart__item-title">
                            <a href="">Футболка «Развиваю инстинкт автосохранения» для тех, кому дороги нервы</a>
                            <span class="cart__item-atribute"><span class="cart__item-atribute__variation">Цвет: Белая</span><span class="cart__item-atribute__variation">Размер: M</span></span>
                            <span class=" cart__item-title__price">439 грн.</span>
                        </div>
                        <div class="cart__item-count">
                            <a class="count__minus" href=""></a>
                            <input class="count__number" type="text" value="1">
                            <a class="count__plus" href=""></a>
                        </div>
                        <div class="cart__item-price">
                            <span>439 грн.</span>
                        </div>
                    </div>
                    <div class="modal__footer">
                        <a class="bac__to__shop" href="/">Продолжить покупки</a>
                        <span class="modal__footer-tottal">
                            Итого:
                            <span class="woocommerce-Price-amount amount">
                                87811
                                <span class="woocommerce-Price-currencySymbol">
                                    грн.
                                </span>
                            </span>
                        </span>
                        <a class="modal__footer-checkout" href="/checkout/">Оформить заказ</a>
                    </div>
                    <!-- cart empty -->
                    <div class="is-cart__empty">
                        <div class="cart__empty"></div>
                        <strong>Ваша корзина пуста</strong>
                        <p>Чтобы это исправить выберите и купите понравившуюся футболку.</p>
                    </div>

                <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php do_action('woocommerce_before_cart_table'); ?>

                    <?php do_action('woocommerce_before_cart_contents'); ?>

                    <?php
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                            <div class="cart__item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                <div class="cart__item-del">
                                    <?php
                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="cart__item-icon remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'woocommerce'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>

                                <div class="cart__item-img">
                                    <?php
                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                    if (!$product_permalink) {
                                        echo $thumbnail; // PHPCS: XSS ok.
                                    } else {
                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                    }
                                    ?>
                                </div>

                                <div class="cart__item-title" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                    <a href="<?= get_permalink($_product->get_id()) ?>"><?= $_product->parent->name ?></a>
                                    <span class="cart__item-atribute"><span class="cart__item-atribute__variation">Цвет: <?= $_product->get_attribute('pa_color'); ?></span><span class="cart__item-atribute__variation">Размер: <?= $_product->get_attribute('pa_size'); ?></span></span>
                                    <span class=" cart__item-title__price"><?= $_product->get_price(); ?> грн.</span>
                                </div>

                                <div class="cart__item-count" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">

                                    <?php
                                    if ($_product->is_sold_individually()) {
                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                'min_value'    => '0',
                                                'product_name' => $_product->get_name(),
                                            ),
                                            $_product,
                                            false
                                        );
                                    }

                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                    ?>

                                </div>

                                <div class="cart__item-price" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <?php do_action('woocommerce_cart_contents'); ?>

                    <tr>
                        <td colspan="6" class="actions">

                            <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                            <?php do_action('woocommerce_cart_actions'); ?>

                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </td>
                    </tr>

                    <?php do_action('woocommerce_after_cart_contents'); ?>

                    <?php do_action('woocommerce_after_cart_table'); ?>
                </form>

                <?php do_action('woocommerce_before_cart_collaterals'); ?>

                <div class="cart__item">
                    <div class="cart__item-del">
                        <a href="" class="cart__item-icon"></a>
                    </div>
                    <div class="cart__item-img">
                        <a href="ptoduct__link"><img src="<?= get_template_directory_uri() ?>/assets/img/img1.jpg" alt=""></a>
                    </div>
                    <div class="cart__item-title">
                        <a href="">
                            Футболка «Развиваю инстинкт автосохранения» для тех, кому дороги
                            нервы
                        </a>
                        <span class="cart__item-atribute">
                            <span class="cart__item-atribute__variation">Цвет: Белая</span>
                            <span class="cart__item-atribute__variation">Размер: M</span>
                        </span>
                        <span class=" cart__item-title__price">439 грн.</span>
                    </div>
                    <div class="cart__item-count">
                        <a class="count__minus" href=""></a>
                        <input class="count__number" type="text" value="1" />
                        <a class="count__plus" href=""></a>
                    </div>
                    <div class="cart__item-price">
                        <span>439 грн.</span>
                    </div>
                </div>
                <div class="modal__footer">
                    <a class="bac__to__shop" href="/">
                        Продолжить покупки
                    </a>
                    <span class="modal__footer-tottal">
                        Итого:
                        <span class="woocommerce-Price-amount amount">
                            87811
                            <span class="woocommerce-Price-currencySymbol">грн.</span>
                        </span>
                    </span>
                    <a class="modal__footer-checkout" href="/checkout/">
                        Оформить заказ
                    </a>
                </div>

                <!-- cart empty -->

                <!-- <div class="is-cart__empty">
                    <div class="cart__empty"></div>
                    <strong>Ваша корзина пуста</strong>
                    <p>Чтобы это исправить выберите и купите понравившуюся футболку.</p>
                </div> -->
            </div>
        </div>
    </div>
    <div id="overlay"></div>
    <!-- preloader -->
    <div class="loader-wrap">
        <div class="logo">
            <svg width="93px" height="17px" viewBox="0 0 1221 224" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g id="#000000">
                    <path fill="#000000" opacity="1.00" d=" M 0.00 0.00 L 0.89 0.00 L 1.23 0.77 C 0.92 1.02 0.31 1.53 0.00 1.79 L 0.00 0.00 Z"></path>
                </g>
                <g id="#000000ff">
                    <path fill="#e74928" opacity="1.00" d=" M 0.89 0.00 L 4.69 0.00 C 23.80 0.98 42.91 2.06 62.01 3.11 C 67.00 3.37 72.02 3.39 76.97 4.09 C 79.10 4.27 78.93 6.91 79.34 8.45 C 82.44 30.00 85.81 51.51 88.84 73.06 C 89.42 74.80 87.87 76.41 86.12 76.20 C 61.77 75.52 37.43 74.42 13.08 73.57 C 11.11 73.68 10.23 71.70 10.15 70.03 C 6.79 47.51 3.29 25.01 0.00 2.48 L 0.00 1.79 C 0.31 1.53 0.92 1.02 1.23 0.77 L 0.89 0.00 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 1131.89 0.00 L 1167.70 0.00 C 1167.95 3.26 1167.90 6.53 1167.86 9.80 C 1163.81 9.87 1159.77 9.85 1155.74 9.84 C 1155.70 21.50 1155.80 33.15 1155.68 44.80 C 1151.80 44.87 1147.92 44.86 1144.05 44.82 C 1144.00 33.16 1144.04 21.50 1144.03 9.85 C 1139.97 9.85 1135.92 9.85 1131.87 9.84 C 1131.84 6.56 1131.84 3.28 1131.89 0.00 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 1172.11 0.25 C 1176.52 0.18 1180.94 0.21 1185.37 0.20 C 1189.13 9.64 1192.85 19.10 1196.52 28.58 C 1200.11 19.08 1203.88 9.65 1207.62 0.21 C 1212.07 0.21 1216.53 0.15 1221.00 0.30 L 1221.00 44.79 C 1217.51 44.85 1214.04 44.86 1210.57 44.83 C 1210.48 35.71 1210.43 26.59 1210.60 17.47 C 1207.15 26.46 1203.50 35.37 1199.84 44.27 C 1197.60 44.28 1195.37 44.28 1193.16 44.27 C 1189.47 35.30 1185.84 26.30 1182.31 17.26 C 1182.46 26.45 1182.41 35.64 1182.34 44.83 C 1178.93 44.85 1175.52 44.86 1172.11 44.81 C 1172.05 29.96 1172.06 15.11 1172.11 0.25 Z">
                    </path>
                    <path fill="#e74928" opacity="1.00" d=" M 101.32 5.42 C 104.88 4.88 108.50 5.58 112.08 5.71 C 163.73 8.50 215.39 11.31 267.04 14.12 C 269.73 14.29 272.48 14.10 275.12 14.72 C 276.98 15.32 276.87 17.34 276.55 18.87 C 273.55 39.31 270.69 59.76 267.70 80.19 C 267.65 81.56 266.52 83.04 265.03 82.83 C 252.69 82.64 240.37 81.67 228.03 81.63 C 226.06 81.33 225.60 83.58 225.76 85.05 C 225.76 129.73 225.74 174.42 225.77 219.10 C 225.75 220.41 225.85 221.91 224.70 222.84 C 221.86 223.51 218.90 223.36 216.01 223.37 C 199.34 223.14 182.68 223.38 166.01 223.12 C 161.75 223.03 157.44 223.54 153.21 222.80 C 151.85 221.98 152.11 220.34 152.05 219.00 C 152.07 173.32 152.07 127.63 152.05 81.95 C 152.25 80.61 151.71 78.99 150.23 78.76 C 137.50 77.71 124.69 78.06 111.97 77.04 C 110.23 77.08 109.89 75.24 109.63 73.91 C 106.51 52.65 103.38 31.39 100.21 10.13 C 100.02 8.51 99.52 6.35 101.32 5.42 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 331.75 40.53 C 341.97 26.81 358.46 19.00 375.11 16.57 C 399.05 13.34 424.75 17.97 444.53 32.36 C 453.26 38.68 460.55 46.94 465.78 56.36 C 467.19 58.96 468.81 61.56 469.14 64.56 C 453.76 72.70 438.51 81.08 423.00 88.94 C 420.73 85.78 419.29 82.10 416.80 79.10 C 411.45 72.13 402.85 67.49 393.97 67.81 C 390.12 67.67 386.04 68.34 382.98 70.84 C 379.70 73.64 378.99 78.86 381.70 82.30 C 385.29 86.89 391.13 88.72 396.36 90.78 C 414.67 97.23 434.15 101.49 450.57 112.35 C 461.37 119.36 469.95 130.19 472.81 142.89 C 476.46 159.07 474.63 177.14 465.23 191.12 C 457.58 202.55 445.33 210.20 432.37 214.24 C 417.07 219.20 400.79 219.60 384.88 218.68 C 366.90 216.99 348.75 211.83 334.21 200.77 C 323.65 192.91 315.55 181.86 311.16 169.46 C 312.39 168.21 313.86 167.25 315.43 166.47 C 330.54 158.60 345.48 150.37 360.63 142.58 C 362.29 141.54 363.13 144.11 363.82 145.21 C 367.58 153.27 373.84 160.44 382.15 163.93 C 390.42 167.41 399.78 167.92 408.53 166.34 C 412.84 165.57 417.74 162.88 418.04 158.00 C 418.13 152.82 413.26 149.64 408.97 147.95 C 399.77 144.30 390.00 142.37 380.62 139.27 C 365.83 134.50 351.18 128.06 339.48 117.61 C 328.48 107.90 321.32 93.75 320.90 79.00 C 319.83 65.44 323.40 51.39 331.75 40.53 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 488.06 24.86 C 498.05 24.57 508.09 25.47 518.08 26.02 C 526.43 25.94 534.71 27.16 543.06 27.15 C 544.38 26.91 545.61 27.85 545.60 29.22 C 545.86 51.15 545.40 73.10 545.83 95.03 C 558.56 95.30 571.25 96.41 583.99 96.11 C 584.14 74.72 583.99 53.32 584.06 31.93 C 583.60 30.18 585.39 28.88 587.00 29.31 C 596.00 30.27 605.08 29.87 614.08 30.88 C 622.27 31.11 630.48 31.31 638.61 32.33 C 639.23 33.81 638.91 35.48 639.02 37.05 C 638.87 97.67 639.19 158.29 638.86 218.91 C 632.92 219.41 626.96 219.04 621.01 219.00 C 608.69 219.00 596.37 219.00 584.06 218.99 C 584.05 195.89 584.04 172.80 584.06 149.70 C 579.78 148.70 575.35 149.06 571.00 148.98 C 562.59 149.01 554.19 148.72 545.78 148.77 C 545.52 168.84 545.74 188.92 545.67 209.00 C 545.57 212.31 546.05 215.72 545.08 218.95 C 526.71 219.00 508.35 218.98 489.99 218.92 C 488.24 219.21 487.73 217.32 487.99 215.98 C 488.06 152.28 487.92 88.57 488.06 24.86 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 662.12 33.99 C 662.35 33.78 662.80 33.35 663.03 33.14 C 669.70 32.80 676.32 34.11 682.99 34.06 C 690.01 34.00 696.97 35.16 704.00 35.08 C 709.72 35.13 715.42 35.83 721.13 36.20 C 721.74 52.12 721.22 68.09 721.39 84.03 C 721.40 126.68 721.38 169.33 721.41 211.98 C 721.31 214.29 721.71 216.70 720.95 218.93 C 718.11 220.04 714.97 219.28 712.02 219.41 C 695.34 219.45 678.68 219.24 662.01 219.27 C 662.08 157.51 661.86 95.74 662.12 33.99 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 743.24 38.21 C 745.21 36.81 747.69 37.87 749.91 37.85 C 767.64 38.47 785.33 39.76 803.06 40.41 C 808.97 41.18 815.00 40.69 820.86 41.93 C 835.02 44.20 848.61 50.93 858.31 61.61 C 871.44 75.74 876.54 96.16 873.94 115.03 C 872.07 130.77 862.92 145.41 849.49 153.87 C 859.65 174.96 870.09 195.92 880.23 217.02 C 881.26 218.38 879.65 220.33 878.10 219.89 C 862.75 219.88 847.40 219.95 832.06 219.78 C 830.70 219.88 830.40 218.16 829.81 217.30 C 821.47 199.44 812.89 181.69 804.62 163.80 C 800.71 163.44 796.77 163.30 792.86 163.58 C 792.70 181.39 792.86 199.21 792.78 217.02 C 793.09 218.64 791.68 220.08 790.05 219.73 C 775.69 219.80 761.33 219.66 746.98 219.67 C 745.65 219.69 744.37 219.38 743.12 219.05 C 742.96 161.35 743.10 103.65 743.05 45.95 C 743.06 43.37 742.90 40.78 743.24 38.21 M 792.88 87.79 C 792.74 98.57 792.74 109.36 792.88 120.14 C 798.90 120.51 804.92 120.90 810.95 121.04 C 816.19 121.28 821.94 119.32 824.77 114.64 C 829.69 106.30 827.07 93.15 817.38 89.56 C 809.51 86.92 801.03 88.27 792.88 87.79 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 877.89 44.74 C 883.21 43.59 888.60 45.39 893.98 45.06 C 917.00 46.12 939.99 47.46 963.02 48.44 C 971.32 49.35 979.70 48.87 988.00 49.88 C 995.99 50.06 1003.98 50.38 1011.93 51.18 C 1013.63 51.82 1012.75 53.77 1012.75 55.11 C 1010.78 68.74 1009.10 82.41 1007.19 96.06 C 1006.79 98.59 1006.94 101.29 1005.72 103.62 C 1001.50 104.21 997.22 103.56 993.00 103.46 C 986.22 102.87 979.42 102.96 972.63 102.87 C 972.09 134.90 972.55 166.96 972.39 199.01 C 972.23 205.93 972.76 212.88 972.06 219.77 C 959.37 220.19 946.67 219.82 933.98 219.92 C 929.76 219.81 925.51 220.19 921.32 219.70 C 920.31 218.31 920.51 216.55 920.49 214.95 C 920.53 188.64 920.49 162.34 920.51 136.03 C 920.36 124.34 920.80 112.63 920.28 100.95 C 909.48 100.66 898.71 99.76 887.90 99.83 C 884.56 100.36 884.72 96.37 884.31 94.15 C 882.35 77.66 879.39 61.27 877.89 44.74 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 1035.22 64.23 C 1045.51 56.14 1058.99 53.06 1071.89 53.84 C 1086.12 54.19 1100.32 59.44 1111.00 68.93 C 1118.25 75.25 1123.48 83.56 1127.14 92.40 C 1124.17 95.15 1120.42 96.81 1117.03 98.96 C 1108.96 103.66 1101.05 108.64 1092.87 113.14 C 1090.69 109.96 1089.28 106.30 1086.73 103.38 C 1082.90 98.76 1076.96 95.98 1070.98 95.97 C 1067.10 96.14 1062.35 97.82 1061.49 102.12 C 1060.03 107.28 1064.84 111.21 1069.08 112.99 C 1083.03 119.16 1098.48 122.10 1111.27 130.79 C 1120.28 136.62 1127.17 145.82 1129.45 156.38 C 1132.81 171.65 1130.59 189.09 1120.30 201.35 C 1111.65 211.76 1098.28 216.90 1085.15 218.50 C 1069.89 220.02 1053.91 218.85 1039.91 212.14 C 1026.05 205.68 1014.75 193.28 1010.75 178.40 C 1022.29 171.31 1034.02 164.54 1045.66 157.61 C 1046.57 156.77 1048.33 156.76 1048.78 158.13 C 1051.59 164.19 1055.28 170.29 1061.38 173.51 C 1068.40 177.15 1077.00 178.11 1084.49 175.33 C 1087.59 174.14 1089.98 170.54 1088.74 167.22 C 1087.71 164.11 1084.76 162.27 1081.91 161.04 C 1076.09 158.57 1069.92 157.11 1063.95 155.09 C 1050.12 150.50 1036.18 143.74 1027.12 131.92 C 1019.88 122.69 1017.04 110.65 1017.82 99.08 C 1018.16 85.68 1024.53 72.41 1035.22 64.23 Z">
                    </path>
                    <path fill="#e74928" opacity="1.00" d=" M 58.07 95.14 C 70.38 94.78 82.70 95.94 95.01 96.11 C 106.06 96.31 117.10 97.07 128.15 97.22 C 130.36 96.81 132.14 98.85 131.71 100.99 C 131.68 140.67 131.74 180.36 131.68 220.04 C 131.99 222.10 129.98 223.47 128.08 223.05 C 105.38 222.97 82.68 223.00 59.99 222.93 C 58.20 223.30 56.50 221.88 56.76 220.02 C 56.66 180.00 56.78 139.97 56.70 99.95 C 56.80 98.31 56.40 96.15 58.07 95.14 Z">
                    </path>
                    <path fill="#000000" opacity="1.00" d=" M 259.48 103.58 C 262.53 102.50 265.87 103.30 269.03 103.40 C 275.26 104.28 281.58 103.88 287.82 104.74 C 292.35 105.31 296.98 104.76 301.47 105.68 C 304.34 106.27 306.48 109.05 306.12 112.00 C 306.13 124.01 306.23 136.02 306.08 148.03 C 306.24 150.72 303.74 153.22 301.04 153.00 C 287.68 153.27 274.31 153.42 260.95 153.48 C 256.88 153.72 252.65 150.32 253.27 146.02 C 254.18 138.89 253.90 131.69 254.79 124.56 C 255.33 118.52 254.83 112.35 256.25 106.41 C 257.00 105.16 258.13 104.14 259.48 103.58 Z">
                    </path>
                </g>
            </svg>
        </div>
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- subscribe -->
    <div class="subscribe-instagram">
        <div class="subscribe-instagram__icon">
            <img src="<?= get_template_directory_uri() ?>/assets/img/instagram.svg" alt="" width="32" height="32">
        </div>
        <div class="subscribe-instagram__text">
            <a href="https://www.instagram.com/itshirts.store/">
                Подпишитесь <br>
                и не пропускайте <br>
                <strong>промокоды на скидку</strong>
            </a>
        </div>
        <i></i>
    </div>