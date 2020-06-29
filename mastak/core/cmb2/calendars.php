<?php
    add_action( 'cmb2_admin_init', 'kg_calendars_metabox' );

    function kg_calendars_metabox() {
        $prefix = 'kg_calendars_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $cmb_term = new_cmb2_box( array(
            'id'               => $prefix .'term',
            'title'            => esc_html__( 'Настройки календаря', 'cmb2' ), // Doesn't output for term boxes
            'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
            'taxonomies'       => array( 'sbc_calendars' ), // Tells CMB2 which taxonomies should have these fields
            // 'new_term_section' => true, // Will display in the "Add New Category" section
        ) );
    
        $cmb_term->add_field( array(
            'name' => esc_html__( 'Максимальное количество человек', 'cmb2' ),
            'id'   => $prefix . 'persons_count',
            'type' => 'text',
        ) );

    }