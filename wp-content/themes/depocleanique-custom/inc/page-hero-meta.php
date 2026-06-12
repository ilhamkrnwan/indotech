<?php
/**
 * Internal page hero fields.
 *
 * Native post meta is used so About/Contact hero content can be edited from
 * the WordPress dashboard without adding plugin dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function dc_page_hero_fields() {
    return [
        'eyebrow'      => [
            'label' => __( 'Eyebrow / Label', 'depocleanique-custom' ),
            'type'  => 'text',
        ],
        'title_line_1' => [
            'label' => __( 'Headline Baris 1', 'depocleanique-custom' ),
            'type'  => 'text',
        ],
        'title_line_2' => [
            'label' => __( 'Headline Baris 2', 'depocleanique-custom' ),
            'type'  => 'text',
        ],
        'description'  => [
            'label' => __( 'Deskripsi Hero', 'depocleanique-custom' ),
            'type'  => 'textarea',
        ],
        'button_label' => [
            'label' => __( 'Label Tombol Opsional', 'depocleanique-custom' ),
            'type'  => 'text',
        ],
        'button_url'   => [
            'label' => __( 'URL Tombol Opsional', 'depocleanique-custom' ),
            'type'  => 'url',
        ],
        'visual_url'   => [
            'label' => __( 'URL Gambar Visual Opsional', 'depocleanique-custom' ),
            'type'  => 'url',
        ],
    ];
}

function dc_page_hero_meta_key( $field ) {
    return 'dc_page_hero_' . sanitize_key( $field );
}

function dc_get_page_hero_meta_value( $post_id, $field, $fallback = '' ) {
    $value = get_post_meta( $post_id, dc_page_hero_meta_key( $field ), true );

    if ( is_string( $value ) && '' !== trim( $value ) ) {
        return $value;
    }

    return $fallback;
}

function dc_get_page_hero_description( $post_id, $fallback = '' ) {
    $description = dc_get_page_hero_meta_value( $post_id, 'description', '' );

    if ( '' !== trim( $description ) ) {
        return $description;
    }

    if ( has_excerpt( $post_id ) ) {
        return wp_strip_all_tags( get_the_excerpt( $post_id ) );
    }

    return $fallback;
}

add_action( 'add_meta_boxes', 'dc_register_page_hero_meta_box' );

function dc_register_page_hero_meta_box() {
    add_meta_box(
        'dc-page-hero',
        __( 'Hero Halaman Internal', 'depocleanique-custom' ),
        'dc_render_page_hero_meta_box',
        'page',
        'normal',
        'high'
    );
}

function dc_render_page_hero_meta_box( $post ) {
    wp_nonce_field( 'dc_save_page_hero_meta', 'dc_page_hero_nonce' );

    echo '<p style="margin-top:0;color:#646970;">' . esc_html__( 'Kosongkan field untuk memakai fallback dari template halaman, excerpt, atau judul halaman.', 'depocleanique-custom' ) . '</p>';
    echo '<div class="dc-page-hero-fields" style="display:grid;gap:14px;">';

    foreach ( dc_page_hero_fields() as $field => $config ) {
        $key   = dc_page_hero_meta_key( $field );
        $value = get_post_meta( $post->ID, $key, true );

        echo '<label style="display:grid;gap:6px;">';
        echo '<span style="font-weight:600;">' . esc_html( $config['label'] ) . '</span>';

        if ( 'textarea' === $config['type'] ) {
            echo '<textarea name="' . esc_attr( $key ) . '" rows="3" style="width:100%;">' . esc_textarea( $value ) . '</textarea>';
        } else {
            echo '<input type="' . esc_attr( $config['type'] ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;">';
        }

        echo '</label>';
    }

    echo '</div>';
}

add_action( 'save_post_page', 'dc_save_page_hero_meta' );

function dc_save_page_hero_meta( $post_id ) {
    if ( ! isset( $_POST['dc_page_hero_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dc_page_hero_nonce'] ) ), 'dc_save_page_hero_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    foreach ( dc_page_hero_fields() as $field => $config ) {
        $key = dc_page_hero_meta_key( $field );
        $raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';

        if ( 'url' === $config['type'] ) {
            $value = esc_url_raw( $raw );
        } elseif ( 'textarea' === $config['type'] ) {
            $value = sanitize_textarea_field( $raw );
        } else {
            $value = sanitize_text_field( $raw );
        }

        if ( '' === $value ) {
            delete_post_meta( $post_id, $key );
        } else {
            update_post_meta( $post_id, $key, $value );
        }
    }
}
