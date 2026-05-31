<?php
/**
 * Sidebar Fallback Navigation
 *
 * @package WebJTI_Theme
 */

$menu_location =
    $args['menu_location'] ?? '';

$current_url =
    trim(
        parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        ),
        '/'
    );

/*
========================================
FALLBACK GROUPED DATA
========================================
*/

$grouped_menus = [
    'sidebar-about-us' => [
        [
            'title' => 'Tentang Kami',
            'items' => [
                [
                    'label' => 'Sejarah Kami',
                    'slug'  => 'about-us/history',
                    'icon'  => 'buildings',
                ],
                [
                    'label' => 'Visi Misi dan Tujuan',
                    'slug'  => 'about-us/vision-mission',
                    'icon'  => 'target',
                ],
            ]
        ],
        [
            'title' => 'Organisasi',
            'items' => [
                [
                    'label' => 'Struktur Organisasi',
                    'slug'  => 'about-us/organization-structure',
                    'icon'  => 'tree-structure',
                ],
                [
                    'label' => 'Tenaga Pengajar',
                    'slug'  => 'about-us/lecturer',
                    'icon'  => 'chalkboard-teacher',
                ],
                [
                    'label' => 'Tenaga Kependidikan',
                    'slug'  => 'about-us/staff',
                    'icon'  => 'user',
                ],
            ]
        ],
        [
            'title' => 'Fasilitas & Kerjasama',
            'items' => [
                [
                    'label' => 'Sarana dan Prasarana',
                    'slug'  => 'about-us/sarana-prasarana',
                    'icon'  => 'chair',
                ],
                [
                    'label' => 'Kerjasama',
                    'slug'  => 'about-us/kerjasama',
                    'icon'  => 'handshake',
                ],
            ]
        ]
    ],

    'sidebar-akademik' => [
        [
            'title' => 'Program Pendidikan',
            'items' => [
                [
                    'label' => 'D2 Pengembangan Piranti Lunak Situs',
                    'slug'  => 'd2-piranti-lunak',
                    'icon'  => 'code',
                ],
                [
                    'label' => 'D3 Manajemen Informatika (Kediri)',
                    'slug'  => 'd3-mi-kediri',
                    'icon'  => 'buildings',
                ],
                [
                    'label' => 'D3 Manajemen Informatika (Lumajang)',
                    'slug'  => 'd3-mi-lumajang',
                    'icon'  => 'buildings',
                ],
                [
                    'label' => 'D4 Teknik Informatika',
                    'slug'  => 'd4-teknik-informatika',
                    'icon'  => 'laptop',
                ],
                [
                    'label' => 'D4 Sistem Informasi Bisnis',
                    'slug'  => 'd4-sistem-informasi-bisnis',
                    'icon'  => 'database',
                ],
                [
                    'label' => 'S2 Rekayasa Teknologi Informasi',
                    'slug'  => 's2-rekayasa-teknologi-informasi',
                    'icon'  => 'graduation-cap',
                ],
            ]
        ],
        [
            'title' => 'Program Khusus',
            'items' => [
                [
                    'label' => 'Kelas Internasional',
                    'slug'  => 'kelas-internasional',
                    'icon'  => 'globe',
                ],
                [
                    'label' => 'Double Degree',
                    'slug'  => 'double-degree',
                    'icon'  => 'identification-card',
                ],
                [
                    'label' => 'Alih Jenjang',
                    'slug'  => 'alih-jenjang',
                    'icon'  => 'arrows-clockwise',
                ],
                [
                    'label' => 'Rekognisi Pembelajaran Lampau (RPL)',
                    'slug'  => 'rpl',
                    'icon'  => 'certificate',
                ],
            ]
        ],
        [
            'title' => 'Layanan Akademik',
            'items' => [
                [
                    'label' => 'Aturan Akademik',
                    'slug'  => 'aturan-akademik',
                    'icon'  => 'file-text',
                ],
                [
                    'label' => 'Kalender Akademik',
                    'slug'  => 'kalender-akademik',
                    'icon'  => 'calendar',
                ],
            ]
        ]
    ],

    'sidebar-student-affairs' => [
        [
            'title' => 'Informasi Umum',
            'items' => [
                [
                    'label' => 'Tata Tertib',
                    'slug'  => 'tata-tertib',
                    'icon'  => 'shield-warning',
                ],
                [
                    'label' => 'Praktik Kerja Lapangan / Magang',
                    'slug'  => 'pkl',
                    'icon'  => 'briefcase',
                ],
            ]
        ],
        [
            'title' => 'Pengembangan Mahasiswa',
            'items' => [
                [
                    'label' => 'Organisasi Kemahasiswaan',
                    'slug'  => 'organisasi-kemahasiswaan',
                    'icon'  => 'users',
                ],
                [
                    'label' => 'Prestasi',
                    'slug'  => 'student-affairs/achievement',
                    'icon'  => 'trophy',
                ],
                [
                    'label' => 'Pengembangan Karir',
                    'slug'  => 'pengembangan-karir',
                    'icon'  => 'trend-up',
                ],
            ]
        ],
        [
            'title' => 'Dukungan Mahasiswa',
            'items' => [
                [
                    'label' => 'Beasiswa',
                    'slug'  => 'beasiswa',
                    'icon'  => 'hand-coins',
                ],
                [
                    'label' => 'Galeri Kemahasiswaan',
                    'slug'  => 'galeri-kemahasiswaan',
                    'icon'  => 'image',
                ],
            ]
        ]
    ],

    'sidebar-penelitian' => [
        [
            'title' => 'Kegiatan Utama',
            'items' => [
                [
                    'label' => 'Penelitian',
                    'slug'  => 'penelitian',
                    'icon'  => 'microscope',
                ],
                [
                    'label' => 'Pengabdian',
                    'slug'  => 'pengabdian',
                    'icon'  => 'globe-hemisphere-east',
                ],
            ]
        ],
        [
            'title' => 'Laboratorium Riset',
            'items' => [
                [
                    'label' => 'Laboratorium Jaringan dan Keamanan Siber (NSC)',
                    'slug'  => 'lab-nsc',
                    'icon'  => 'shield-check',
                ],
                [
                    'label' => 'Laboratorium Rekayasa Perangkat Lunak (RPL)',
                    'slug'  => 'lab-rpl',
                    'icon'  => 'brackets-curly',
                ],
                [
                    'label' => 'Laboratorium Visi Cerdas dan Sistem Cerdas (IVSS)',
                    'slug'  => 'lab-ivss',
                    'icon'  => 'eye',
                ],
                [
                    'label' => 'Information and Learning Engineering Technology Laboratory (InLET)',
                    'slug'  => 'lab-inlet',
                    'icon'  => 'student',
                ],
                [
                    'label' => 'Laboratorium Analisa Bisnis (BA)',
                    'slug'  => 'lab-ba',
                    'icon'  => 'chart-bar',
                ],
                [
                    'label' => 'Laboratorium Teknologi Data (DT)',
                    'slug'  => 'lab-dt',
                    'icon'  => 'database',
                ],
                [
                    'label' => 'Laboratorium Multimedia dan Perangkat Bergerak (MMT)',
                    'slug'  => 'lab-mmt',
                    'icon'  => 'device-mobile',
                ],
                [
                    'label' => 'Laboratorium Informatika Terapan (IS)',
                    'slug'  => 'lab-is',
                    'icon'  => 'gear',
                ],
            ]
        ],
        [
            'title' => 'Dukungan',
            'items' => [
                [
                    'label' => 'Jurnal',
                    'slug'  => 'jurnal',
                    'icon'  => 'book-open',
                ],
            ]
        ]
    ]
];

$groups = $grouped_menus[$menu_location] ?? [];

if (empty($groups)) {
    return;
}
?>

<div class="sidebar-groups-wrapper">
    <?php foreach ($groups as $group) : ?>
        <?php
        get_template_part(
            'template-parts/components/sidebar/sidebar-group',
            null,
            [
                'title' => $group['title'],
                'items' => $group['items'],
            ]
        );
        ?>
    <?php endforeach; ?>
</div>