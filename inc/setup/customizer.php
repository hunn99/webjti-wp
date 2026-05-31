<?php
/**
 * Theme Customizer
 *
 * @package WebJTI_Theme
 */

function webjti_customize_register($wp_customize) {

    // Add Section for Theme Pages Setup
    $wp_customize->add_section('webjti_pages_section', [
        'title'    => __('Pengaturan Halaman Tema', 'webjti-theme'),
        'priority' => 120,
        'description' => __('Atur halaman mana saja yang difungsikan sebagai halaman utama untuk masing-masing bagian.', 'webjti-theme'),
    ]);

    // Setting: Halaman Prestasi
    $wp_customize->add_setting('jti_page_prestasi', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('jti_page_prestasi', [
        'label'       => __('Halaman Prestasi', 'webjti-theme'),
        'description' => __('Pilih halaman utama untuk bagian Prestasi Mahasiswa.', 'webjti-theme'),
        'section'     => 'webjti_pages_section',
        'type'        => 'dropdown-pages',
    ]);

    // Setting: Halaman Informasi
    $wp_customize->add_setting('jti_page_informasi', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('jti_page_informasi', [
        'label'       => __('Halaman Informasi', 'webjti-theme'),
        'description' => __('Pilih halaman utama untuk bagian Informasi (Berita, Agenda, Pengumuman).', 'webjti-theme'),
        'section'     => 'webjti_pages_section',
        'type'        => 'dropdown-pages',
    ]);

    // Setting: Halaman Tentang Kami
    $wp_customize->add_setting('jti_page_tentang_kami', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('jti_page_tentang_kami', [
        'label'       => __('Halaman Tentang Kami', 'webjti-theme'),
        'description' => __('Pilih halaman utama untuk bagian Tentang Kami.', 'webjti-theme'),
        'section'     => 'webjti_pages_section',
        'type'        => 'dropdown-pages',
    ]);

    // Setting: Halaman Akademik
    $wp_customize->add_setting('jti_page_akademik', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('jti_page_akademik', [
        'label'       => __('Halaman Akademik', 'webjti-theme'),
        'description' => __('Pilih halaman utama untuk bagian Akademik.', 'webjti-theme'),
        'section'     => 'webjti_pages_section',
        'type'        => 'dropdown-pages',
    ]);

    // Topbar settings
    $wp_customize->add_section('webjti_topbar_section', [
        'title'       => __('Topbar', 'webjti-theme'),
        'priority'    => 130,
        'description' => __('Atur konten dan visibilitas topbar.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('jti_topbar_enabled', [
        'default'           => true,
        'sanitize_callback' => 'webjti_sanitize_checkbox',
    ]);

    $wp_customize->add_control('jti_topbar_enabled', [
        'label'   => __('Tampilkan Topbar', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'checkbox',
    ]);

    $wp_customize->add_setting('jti_topbar_email', [
        'default'           => 'jti@polinema.ac.id',
        'sanitize_callback' => 'sanitize_email',
    ]);

    $wp_customize->add_control('jti_topbar_email', [
        'label'   => __('Email', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_topbar_phone', [
        'default'           => '(0341) 404424',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_topbar_phone', [
        'label'   => __('Telepon (teks)', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_topbar_phone_link', [
        'default'           => '+(0341) 404424',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_topbar_phone_link', [
        'label'   => __('Telepon (href)', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'text',
    ]);

    $links = [
        ['key' => '1', 'label' => 'Mahasiswa', 'url' => '/mahasiswa'],
        ['key' => '2', 'label' => 'Lecturer', 'url' => '/lecturer'],
        ['key' => '3', 'label' => 'Calon Mahasiswa', 'url' => '/calon-mahasiswa'],
        ['key' => '4', 'label' => 'Alumni', 'url' => '/alumni'],
    ];

    foreach ($links as $link) {
        $wp_customize->add_setting('jti_topbar_link_label_' . $link['key'], [
            'default'           => $link['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('jti_topbar_link_label_' . $link['key'], [
            'label'   => sprintf(__('Shortcut %s (label)', 'webjti-theme'), $link['key']),
            'section' => 'webjti_topbar_section',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting('jti_topbar_link_url_' . $link['key'], [
            'default'           => $link['url'],
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control('jti_topbar_link_url_' . $link['key'], [
            'label'   => sprintf(__('Shortcut %s (url)', 'webjti-theme'), $link['key']),
            'section' => 'webjti_topbar_section',
            'type'    => 'url',
        ]);
    }

    $wp_customize->add_setting('jti_topbar_lang_enabled', [
        'default'           => true,
        'sanitize_callback' => 'webjti_sanitize_checkbox',
    ]);

    $wp_customize->add_control('jti_topbar_lang_enabled', [
        'label'   => __('Tampilkan Switch Bahasa', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'checkbox',
    ]);

    $wp_customize->add_setting('jti_topbar_lang_active', [
        'default'           => 'id',
        'sanitize_callback' => 'webjti_sanitize_lang',
    ]);

    $wp_customize->add_control('jti_topbar_lang_active', [
        'label'   => __('Bahasa Aktif', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'select',
        'choices' => [
            'en' => __('English', 'webjti-theme'),
            'id' => __('Indonesia', 'webjti-theme'),
        ],
    ]);

    $wp_customize->add_setting('jti_topbar_lang_en_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('jti_topbar_lang_en_url', [
        'label'   => __('URL English', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('jti_topbar_lang_id_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('jti_topbar_lang_id_url', [
        'label'   => __('URL Indonesia', 'webjti-theme'),
        'section' => 'webjti_topbar_section',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('jti_topbar_lang_en_icon', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jti_topbar_lang_en_icon_control',
        [
            'label'    => __('Icon English', 'webjti-theme'),
            'section'  => 'webjti_topbar_section',
            'settings' => 'jti_topbar_lang_en_icon',
        ]
    ));

    $wp_customize->add_setting('jti_topbar_lang_id_icon', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jti_topbar_lang_id_icon_control',
        [
            'label'    => __('Icon Indonesia', 'webjti-theme'),
            'section'  => 'webjti_topbar_section',
            'settings' => 'jti_topbar_lang_id_icon',
        ]
    ));


    // Stats Section
    $wp_customize->add_section('webjti_stats_section', [
        'title'       => __('Statistik Kampus', 'webjti-theme'),
        'priority'    => 140,
        'description' => __('Atur angka statistik yang ditampilkan di halaman depan.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('webjti_total_mahasiswa', [
        'default'           => '1245+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('webjti_total_mahasiswa', [
        'label'   => __('Total Mahasiswa Aktif', 'webjti-theme'),
        'section' => 'webjti_stats_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('webjti_total_alumni', [
        'default'           => '4567+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('webjti_total_alumni', [
        'label'   => __('Total Alumni', 'webjti-theme'),
        'section' => 'webjti_stats_section',
        'type'    => 'text',
    ]);

    // Information Section
    $wp_customize->add_section('webjti_information_section', [
        'title'       => __('Information Section', 'webjti-theme'),
        'priority'    => 145,
        'description' => __('Atur judul dan tag untuk area informasi di halaman depan.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('jti_info_badge_text', [
        'default'           => 'Informasi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_info_badge_text', [
        'label'   => __('Label (Tag)', 'webjti-theme'),
        'section' => 'webjti_information_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_info_title_text', [
        'default'           => 'Berita Terkini dan Informasi Menarik dari Kampus',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('jti_info_title_text', [
        'label'   => __('Judul Utama', 'webjti-theme'),
        'section' => 'webjti_information_section',
        'type'    => 'textarea',
    ]);

    // Checkbox: Sembunyikan Postingan Default / Fallback
    $wp_customize->add_setting('jti_disable_default_posts', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);

    $wp_customize->add_control('jti_disable_default_posts', [
        'label'   => __('Sembunyikan Postingan Default / Fallback', 'webjti-theme'),
        'description' => __('Centang ini jika ingin menghapus postingan default/fallback dan hanya menampilkan postingan asli dari database.', 'webjti-theme'),
        'section' => 'webjti_information_section',
        'type'    => 'checkbox',
    ]);


    // Study Program Section
    $wp_customize->add_section('webjti_prodi_section', [
        'title'       => __('Program Studi Section', 'webjti-theme'),
        'priority'    => 146,
        'description' => __('Atur judul dan tag untuk area program studi di halaman depan.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('jti_prodi_badge_text', [
        'default'           => 'PROGRAM STUDI',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_prodi_badge_text', [
        'label'   => __('Label (Tag)', 'webjti-theme'),
        'section' => 'webjti_prodi_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_prodi_title_text', [
        'default'           => 'Pilih Jalur Karier Teknologi yang Pas Buatmu',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('jti_prodi_title_text', [
        'label'   => __('Judul Utama', 'webjti-theme'),
        'section' => 'webjti_prodi_section',
        'type'    => 'textarea',
    ]);

    // Video Section
    $wp_customize->add_section('webjti_video_section', [
        'title'       => __('Video Profil Section', 'webjti-theme'),
        'priority'    => 147,
        'description' => __('Atur judul, tag, link video youtube dan link button youtube channel.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('jti_video_badge_text', [
        'default'           => 'VIDEO PROFIL',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_video_badge_text', [
        'label'   => __('Label (Tag)', 'webjti-theme'),
        'section' => 'webjti_video_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_video_title_text', [
        'default'           => 'Kenali Lebih Dekat JTI Polinema Sekarang',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('jti_video_title_text', [
        'label'   => __('Judul Utama', 'webjti-theme'),
        'section' => 'webjti_video_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('jti_video_url_text', [
        'default'           => 'https://youtu.be/aJYMCM1aEcA',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('jti_video_url_text', [
        'label'   => __('Link Video YouTube', 'webjti-theme'),
        'section' => 'webjti_video_section',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('jti_video_button_url', [
        'default'           => 'https://www.youtube.com/@jtipolinema367/featured',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('jti_video_button_url', [
        'label'   => __('Link Button YouTube Channel', 'webjti-theme'),
        'section' => 'webjti_video_section',
        'type'    => 'url',
    ]);

    // Campus Section
    $wp_customize->add_section('webjti_campus_section', [
        'title'       => __('Cabang JTI Section', 'webjti-theme'),
        'priority'    => 148,
        'description' => __('Atur judul, tag, serta informasi detail dari 4 cabang JTI.', 'webjti-theme'),
    ]);

    $wp_customize->add_setting('jti_campus_badge_text', [
        'default'           => 'CABANG JTI',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('jti_campus_badge_text', [
        'label'   => __('Label (Tag)', 'webjti-theme'),
        'section' => 'webjti_campus_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('jti_campus_title_text', [
        'default'           => 'Mengenal Kampus JTI di Berbagai Daerah',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('jti_campus_title_text', [
        'label'   => __('Judul Utama', 'webjti-theme'),
        'section' => 'webjti_campus_section',
        'type'    => 'textarea',
    ]);

    // Loop for Campuses
    $campus_defaults = [
        1 => [
            'title'   => 'JTI Kampus Utama',
            'address' => 'Jl. Soekarno Hatta No. 9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141',
            'email'   => 'humas@jti.polinema.ac.id',
        ],
        2 => [
            'title'   => 'JTI Kampus Lumajang',
            'address' => 'Jl. Raya Klakah No. 123, Kec. Klakah, Kabupaten Lumajang, Jawa Timur 67356',
            'email'   => 'humas.lmj@jti.polinema.ac.id',
        ],
        3 => [
            'title'   => 'JTI Kampus Kediri',
            'address' => 'Jl. Veteran No. 45, Mojoroto, Kec. Mojoroto, Kota Kediri, Jawa Timur 64112',
            'email'   => 'humas.kdr@jti.polinema.ac.id',
        ],
        4 => [
            'title'   => 'JTI Kampus Pamekasan',
            'address' => 'Jl. Panglegur No. 8, Panglegur, Kec. Tlanakan, Kabupaten Pamekasan, Jawa Timur 69371',
            'email'   => 'humas.pmk@jti.polinema.ac.id',
        ],
    ];

    for ($i = 1; $i <= 4; $i++) {
        $default = $campus_defaults[$i];
        
        // Title
        $wp_customize->add_setting("jti_campus_{$i}_title", [
            'default'           => $default['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("jti_campus_{$i}_title", [
            'label'   => sprintf(__('Nama Cabang %d', 'webjti-theme'), $i),
            'section' => 'webjti_campus_section',
            'type'    => 'text',
        ]);

        // Address
        $wp_customize->add_setting("jti_campus_{$i}_address", [
            'default'           => $default['address'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control("jti_campus_{$i}_address", [
            'label'   => sprintf(__('Alamat Cabang %d', 'webjti-theme'), $i),
            'section' => 'webjti_campus_section',
            'type'    => 'textarea',
        ]);

        // Email
        $wp_customize->add_setting("jti_campus_{$i}_email", [
            'default'           => $default['email'],
            'sanitize_callback' => 'sanitize_email',
        ]);
        $wp_customize->add_control("jti_campus_{$i}_email", [
            'label'   => sprintf(__('Email Cabang %d', 'webjti-theme'), $i),
            'section' => 'webjti_campus_section',
            'type'    => 'text',
        ]);
    }

    // Sejarah: Sambutan Kajur Section
    $wp_customize->add_section('webjti_history_welcome_section', [
        'title'       => __('Sejarah: Sambutan Kajur', 'webjti-theme'),
        'priority'    => 148,
        'description' => __('Atur judul sambutan, link video YouTube, foto, nama Kajur, dan latar belakang di bagian Sambutan Halaman Sejarah.', 'webjti-theme'),
    ]);

    // 1. Title
    $wp_customize->add_setting('jti_history_welcome_title', [
        'default'           => 'Sambutan Ketua Jurusan Teknologi Informasi Polinema',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('jti_history_welcome_title', [
        'label'   => __('Judul Sambutan', 'webjti-theme'),
        'section' => 'webjti_history_welcome_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('jti_history_welcome_video_url', [
        'default'           => 'https://www.youtube.com/watch?v=aJYMCM1aEcA',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('jti_history_welcome_video_url', [
        'label'   => __('Link Video YouTube', 'webjti-theme'),
        'section' => 'webjti_history_welcome_section',
        'type'    => 'url',
    ]);

    // 3. Name
    $wp_customize->add_setting('jti_history_welcome_name', [
        'default'           => 'Mungki Astiningrum, ST., M.Kom.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_history_welcome_name', [
        'label'   => __('Nama Lengkap Kajur', 'webjti-theme'),
        'section' => 'webjti_history_welcome_section',
        'type'    => 'text',
    ]);

    // 4. Image
    $wp_customize->add_setting('jti_history_welcome_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jti_history_welcome_image_control',
        [
            'label'       => __('Foto Kajur', 'webjti-theme'),
            'description' => __('Unggah foto Kajur. Kosongkan jika ingin memakai foto bawaan.', 'webjti-theme'),
            'section'     => 'webjti_history_welcome_section',
            'settings'    => 'jti_history_welcome_image',
        ]
    ));

    // 5. Background Image
    $wp_customize->add_setting('jti_history_welcome_bg', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jti_history_welcome_bg_control',
        [
            'label'       => __('Background Banner', 'webjti-theme'),
            'description' => __('Unggah gambar background banner custom. Kosongkan jika ingin memakai warna gradien bawaan.', 'webjti-theme'),
            'section'     => 'webjti_history_welcome_section',
            'settings'    => 'jti_history_welcome_bg',
        ]
    ));

    // Footer Section
    $wp_customize->add_section('webjti_footer_section', [
        'title'       => __('Footer Section', 'webjti-theme'),
        'priority'    => 150,
        'description' => __('Atur logo, nama instansi, kontak, serta media sosial di area footer.', 'webjti-theme'),
    ]);

    // Footer Logo
    $wp_customize->add_setting('jti_footer_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jti_footer_logo_control',
        [
            'label'    => __('Logo Footer', 'webjti-theme'),
            'description' => __('Unggah logo custom untuk footer. Kosongkan jika ingin memakai logo gabungan standar JTI.', 'webjti-theme'),
            'section'  => 'webjti_footer_section',
            'settings' => 'jti_footer_logo',
        ]
    ));

    // Footer Name
    $wp_customize->add_setting('jti_footer_name', [
        'default'           => 'Jurusan Teknologi Informasi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_name', [
        'label'   => __('Nama Unit/Jurusan', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Footer Institution
    $wp_customize->add_setting('jti_footer_institution', [
        'default'           => 'Politeknik Negeri Malang',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_institution', [
        'label'   => __('Nama Instansi', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Footer Phone
    $wp_customize->add_setting('jti_footer_phone', [
        'default'           => '(0341) 404424',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_phone', [
        'label'   => __('Telepon', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Footer Email
    $wp_customize->add_setting('jti_footer_email', [
        'default'           => 'jti@polinema.ac.id',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('jti_footer_email', [
        'label'   => __('Email', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Social Media Title
    $wp_customize->add_setting('jti_footer_social_title', [
        'default'           => 'Ikuti Media Sosial Kami',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_social_title', [
        'label'   => __('Judul Box Media Sosial', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Instagram Handle
    $wp_customize->add_setting('jti_footer_instagram_handle', [
        'default'           => '@jtipolinema',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_instagram_handle', [
        'label'   => __('Instagram Handle', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Instagram URL
    $wp_customize->add_setting('jti_footer_instagram_url', [
        'default'           => 'https://www.instagram.com/jtipolinema/',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('jti_footer_instagram_url', [
        'label'   => __('Instagram URL', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'url',
    ]);

    // Facebook Handle
    $wp_customize->add_setting('jti_footer_facebook_handle', [
        'default'           => '@jti.polinema',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_facebook_handle', [
        'label'   => __('Facebook Handle', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // Facebook URL
    $wp_customize->add_setting('jti_footer_facebook_url', [
        'default'           => 'https://www.facebook.com/jtipolinema',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('jti_footer_facebook_url', [
        'label'   => __('Facebook URL', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'url',
    ]);

    // X (Twitter) Handle
    $wp_customize->add_setting('jti_footer_x_handle', [
        'default'           => '@jtipolinema',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_x_handle', [
        'label'   => __('X (Twitter) Handle', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'text',
    ]);

    // X (Twitter) URL
    $wp_customize->add_setting('jti_footer_x_url', [
        'default'           => 'https://x.com/jtipolinema',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('jti_footer_x_url', [
        'label'   => __('X (Twitter) URL', 'webjti-theme'),
        'section' => 'webjti_footer_section',
        'type'    => 'url',
    ]);

    // Copyright Text
    $wp_customize->add_setting('jti_footer_copyright', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('jti_footer_copyright', [
        'label'       => __('Teks Hak Cipta (Copyright)', 'webjti-theme'),
        'description' => __('Masukkan teks hak cipta kustom. Kosongkan untuk memakai teks standar dinamis.', 'webjti-theme'),
        'section'     => 'webjti_footer_section',
        'type'        => 'text',
    ]);

}


function webjti_sanitize_checkbox($value) {
    return (bool) $value;
}


function webjti_sanitize_lang($value) {
    $allowed = ['en', 'id'];
    return in_array($value, $allowed, true) ? $value : 'id';
}
add_action('customize_register', 'webjti_customize_register');
