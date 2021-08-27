<?php

//configurations file
$GLOBALS['config'] = [
    'info' => [
        'owner_mail' => 'uestudio@unidadeditorial.es',
        'owner_name' => 'UeCluster Admin',
        'web_name' => 'uecluster',
        'session_name' => 'ueclustersession',
        'secret_word' => 'simbiosis',
    ],
    'security' => [
        'min_level' => 3,
        'cookie_minutes' => 121,
    ],
    'uploads_dir' => __DIR__ . '/../public/uploads/',
    //'cdn_url' => '/uploads/images',
    'cdn_url' => 'https://uecluster.blob.core.windows.net',
    'images' => [
        'uneteawah' => [
            '300' => 300,
            'th' => 50,
        ],

        'laporteriavertical' => [
            'th' => 50,
        ],
        'origenes' => [
            'th' => 50,
        ],
        'compartiendoconocimiento' => [
            'th' => 50,
        ],
        'haranhistoria' => [
            'th' => 50,
        ],
        'feliziudad' => [
            '1330' => 1330,
            '506' => 506,
            'th' => 50,
        ],
        'ods2030' => [
            '870' => 870,
            'th' => 50,
        ],
        'noesfutboleslaliga' => [
            '1056' => 1056,
            '640' => 640,
            'th' => 50,
        ],
        'planetainteligente' => [
            '1143' => 1143,
            '514' => 514,
            '380' => 380,
            'th' => 50,
        ],
        'porunusolove' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'ahoramascerca' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'nacidosparaserautonomos' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'hablemosdefuturo' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'derechodeempresa' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'gastro' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'transformaciondigital' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'efectopositivo' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'electrificate' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'espiritufilantropico' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'estardondeestes' => [
            '784' => 784,
            '650' => 650,
            '329' => 329,
            '310' => 310,
            'th' => 50,
        ],
        'impulsodigital' => [
            '800' => 800,
            '300' => 300,
            'th' => 50,
        ],
        'saludesvida' => [
            '1920' => 1920,
            '690' => 690,
            '270' => 270,
            'th' => 50,
        ],
        'revivetupelo' => [
            '547' => 547,
            'th' => 50,
        ],
        'futurosostenible' => [
            'th' => 50,
        ],
        'caminosalternativos' => [
            '370' => 370,
            '140' => 140,
            'th' => 50,
        ],
        'correresdevalientes' => [
            '490' => 490,
            'th' => 50,
        ],
        'ventanaalfuturo' => [
            '593' => 593,
            'th' => 50,
        ],
        'loquehayquever' => [
            '498' => 498,
            '300' => 300,
            'th' => 50,
        ],
        'laprevia' => [
            '1024' => 1024,
            '728' => 728,
            '420' => 420,
            'th' => 50,
        ],
        'bodegasybebidas' => [
            '1900' => 1900,
            '670' => 670,
            '350' => 350,
            'th' => 50,
        ],
        'estrategiadigital' => [
            '1920' => 1920,
            '844' => 844,
            'th' => 50,
        ],
        'pequenosjugadores' => [
            '544' => 544,
            '282' => 282,
            'th' => 50,
        ],
        'innovacionensalud' => [
            '549' => 549,
            '225' => 225,
            'th' => 50,
        ],
        'alimentatusalud' => [
            '345' => 345,
            'th' => 50,
        ],
        'extraordinarios' => [
            '397' => 397,
            'th' => 50,
        ],
        'nosvemosencasa' => [
            '610' => 610,
            '550' => 550,
            'th' => 50
        ],
        'potenciatupyme' => [
            '700' => 700,
            '320' => 320,
            '304' => 304,
            'th' => 50
        ],
        'theventurespain' => [
            '824' => 824,
            '504' => 504,
            '359' => 359,
            '278' => 278,
            'th' => 50,
        ],
        'unpaseoporelprado' => [
            '940' => 940,
            'th' => 50,
        ],
        'vivirmasymejor' => [
            '400' => 400,
            '305' => 305,
            'th' => 50,
        ],
        'yodonabeautybrandsplace' => [
            '1920' => 1920,
            '1284' => 1284,
            '700' => 700,
            'th' => 50,
        ]
    ],
    'locales' => [
        'es' => 'es_ES.UTF-8',
    ],
    'enum' => [
        'webs_name' => [
            'ahoramascerca' => 'Ahora más Cerca',
            // 'alimentatusalud' => 'Alimenta tu Salud',
            // 'bodegasybebidas' => 'Bodegas y Bebidas',
            // 'caminosalternativos' => 'Caminos Alternativos',
            // 'copasamsung' => 'Copa Samsung',
            'compartiendoconocimiento' => 'Compartiendo Conocimiento',
            'correresdevalientes' => '¡Correr es de valientes!',
            'derechodeempresa' => 'Derecho de Empresa',
            // 'efectopositivo' => 'Efecto Positivo',
            // 'electrificate' => 'Electrificate',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            // 'espiritufilantropico' => 'Espíritu Filantrópico',
            // 'estardondeestes' => 'Estar donde Estés',
            // 'feliziudad' => 'FeliZiudad',
            // 'estrategiadigital' => 'Estrategia Digital',
            // 'extraordinarios' => 'Extraordinarios',
            // 'futurosostenible' => 'Futuro Sostenible',
            // 'gastro' => 'Gastro',
            'transformaciondigital' => 'Camino Digital',
            // 'hablemosdefuturo' => 'Hablemos del Futuro',
            // 'haranhistoria' => 'Harán Historia',
            // 'impulsodigital' => 'Impulso Digital',
            // 'innovacionensalud' => 'Innovación en Salud',
            // 'laprevia' => 'La Previa',
            'laporteriavertical' => 'La Portería Vertical',
            // 'loquehayquever' => 'Lo que hay que ver',
            // 'mastercard' => 'Mastercard',
            // 'nacidosparaserautonomos' => 'Nacidos para ser Autónomos',
            'noesfutboleslaliga' => 'No es Fútbol es LaLiga',
            // 'nosmovemos' => 'Nos Movemos',
            // 'nosvemosencasa' => 'Nos Vemos en Casa',
            // 'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            // 'pequenosjugadores' => 'Pequeños Jugadores',
            'ods2030' => 'ODS2030',
            'origenes' => 'Orígenes',
            'planetainteligente' => 'Planeta Inteligente',
            'porunusolove' => 'Por un uso Love',
            // 'potenciatupyme' => 'Potencia tu Pyme',
            // 'revivetupelo' => 'Revive tu Pelo',
            'saludesvida' => 'Salud es Vida',
            // 'therightway' => 'The Right Way',
            // 'theventurespain' => 'The Venture Spain',
            'unpaseoporelprado' => 'Un Paseo por el Prado',
            'uneteawah' => 'Únete a la red WAH',
            // 'ventanaalfuturo' => 'Ventana al futuro',
            // 'vivirmasymejor' => 'Vivir Más y Mejor',
            // 'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
        ],
        'webs_url' => [
            'haranhistoria' => 'https://haranhistoria.elmundo.es/',
            'feliziudad' => 'https://feliziudad.marca.com',
            'bodegasybebidas' => 'https://www.bodegasybebidas.fueradeserie.com/',
            'ahoramascerca' => 'https://ahoramascerca.elmundo.es/',
            'porunusolove' => 'https://porunusolove.elmundo.es/',
            'derechodeempresa' => 'https://derechodeempresa.expansion.com/',
            'hablemosdefuturo' => 'https://hablemosdefuturo.expansion.com/',
            'nacidosparaserautonomos' => 'https://nacidosparaserautonomos.elmundo.es/',
            'efectopositivo' => 'https://efectopositivo.elmundo.es/',
            'gastro' => 'https://gastro.elmundo.es/metropoli/',
            'transformaciondigital' => 'https://transformaciondigital.elmundo.es/',
            'electrificate' => 'https://electrificate.elmundo.es/',
            'noesfutboleslaliga' => 'https://noesfutboleslaliga.elmundo.es/',
            'planetainteligente' => 'https://planetainteligente.elmundo.es/',
            'saludesvida' => 'https://saludesvida.marca.com/',
            'estardondeestes' => 'https://estardondeestes.elmundo.es/',
            'espiritufilantropico' => 'https://espiritufilantropico.elmundo.es/',
            'revivetupelo' => 'https://www.revivetupelo.telva.com/',
            'futurosostenible' => 'https://www.futurosostenible.elmundo.es/',
            'caminosalternativos' => 'https://www.caminosalternativos.elmundo.es/',
            'correresdevalientes' => 'https://www.correresdevalientes.elmundo.es/',
            'ventanaalfuturo' => 'https://www.ventanaalfuturo.elmundo.es/',
            'loquehayquever' => 'https://www.loquehayquever.elmundo.es/',
            'ods2030' => 'https://ods2030.expansion.com/',
            'laprevia' => 'https://www.laprevia.marca.com/',
            // 'alimentatusalud' => 'Alimenta tu Salud',
            // 'copasamsung' => 'Copa Samsung',
            'estrategiadigital' => 'https://www.estrategiadigital.expansion.com/',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            // 'extraordinarios' => 'Extraordinarios',
            'impulsodigital' => 'https://www.impulsodigital.elmundo.es/',
            'innovacionensalud' => 'https://www.innovacionensalud.elmundo.es/',
            // 'mastercard' => 'Mastercard',
            // 'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'https://www.nosvemosencasa.elmundo.es/',
            'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            'pequenosjugadores' => 'https://www.pequenosjugadores.marca.com/',
            'potenciatupyme' => 'https://potenciatupyme.elmundo.es/',
            // 'therightway' => 'The Right Way',
            'theventurespain' => 'https://www.theventurespain.expansion.com/',
            'unpaseoporelprado' => 'https://unpaseoporelprado.elmundo.es/',
            'vivirmasymejor' => 'https://www.vivirmasymejor.elmundo.es/',
            // 'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place',
            'compartiendoconocimiento' => 'https://compartiendoconocimiento.elmundo.es/',
            'laporteriavertical' => 'https://laporteriavertical.marca.com/',
            'uneteawah' => 'https://uneteawah.marca.com/',
            'origenes' => 'https://origenes.marca.com/'
        ],
        'options_name' => [
            'Tipo de Contenido' => 'type',
            // 'Formato' => 'format',
            // 'Partido' => 'match',
            // 'Fecha' => 'date',
            // 'Autor' => 'author',
            'Antetítulo' => 'kicker',
            'Caption' => 'caption',
            'Estilos' => 'styles',
            'Patrocinador' => 'partner',
            'Pixel' => 'pixel',
            'Podcast' => 'podcast',
            'Resumen' => 'summary',
            'Scripts' => 'scripts',
            'Título Alt.' => 'headline',
            'URL' => 'url',
            'Quedada' => 'meeting',
            'Trackit' => 'trackit_id',
            'Footer' => 'footer',
            'Video' => 'video',
            'Info' => 'info',
            'Instagram' => 'instagram',
            'Menú' => 'menu',
            'TikTok' => 'tiktok',
        ],
        'options' => [
            'adrian-salso',
            'ana-martinez',
            'anna-amez',
            'annalisa-castaldi',
            'aurora-yanez',
            'belen-gomez',
            'dayana-gomes',
            'elena-tevar',
            'ignacio-gutierrez',
            'itziar-digon',
            'javier-subiza',
            'laura-lopez',
            'loly-hernandez',
            'macarena-cutillas',
            'marcos-florez',
            'nadia-sarmini',
            'natalia-ageitos',
            'nieves-salinas',
            'nuria-vallcorba',
            'olalla-uriarte',
            'pablo-garnelo',
            'sanchez-carpintero',
            'silvia-gonzalez',
            'uestudio',
            'vanessa-buitrago',
            'valentina-tanese',
            'video',
            'content',
            'special',
            'gallery',
            'album',
            'noticia',
            'galeria',
            'infografia',
            'texto',
            'video',
            'encuesta',
            'list',
        ]
    ],
];
