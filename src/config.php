<?php
#configurations file
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
        'cookie_minutes' => 120,
    ],
    'uploads_dir' => __DIR__.'/../public/uploads/',
    'images' => [
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
            '495' => 495,
            '310' => 310,
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
            'futurosostenible' => 'Futuro Sostenible',
            'caminosalternativos' => 'Caminos Alternativos',
            'correresdevalientes' => '¡Correr es de valientes!',
            'ventanaalfuturo' => 'Ventana al futuro',
            'loquehayquever' => 'Lo que hay que ver',
            'laprevia' => 'La Previa',
            'bodegasybebidas' => 'Bodegas y Bebidas',
            // 'alimentatusalud' => 'Alimenta tu Salud',
            // 'copasamsung' => 'Copa Samsung',
            'estrategiadigital' => 'Estrategia Digital',
            'pequenosjugadores' => 'Pequeños Jugadores',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            // 'extraordinarios' => 'Extraordinarios',
            'innovacionensalud' => 'Innovación en Salud',
            // 'mastercard' => 'Mastercard',
            // 'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'Nos Vemos en Casa',
            // 'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            'potenciatupyme' => 'Potencia tu Pyme',
            // 'therightway' => 'The Right Way',
            'theventurespain' => 'The Venture Spain',
            'unpaseoporelprado' => 'Un Paseo por el Prado',
            'vivirmasymejor' => 'Vivir Más y Mejor',
            // 'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
        ],
        'webs_url' => [
            'futurosostenible' => 'http://www.futurosostenible.elmundo.es/',
            'caminosalternativos' => 'http://www.caminosalternativos.elmundo.es/',
            'correresdevalientes' => 'http://www.correresdevalientes.elmundo.es/',
            'ventanaalfuturo' => 'http://www.ventanaalfuturo.elmundo.es/',
            'loquehayquever' => 'http://www.loquehayquever.elmundo.es/',
            'laprevia' => 'http://www.laprevia.marca.com/',
            'bodegasybebidas' => 'http://www.bodegasybebidas.fueradeserie.com/',
            // 'alimentatusalud' => 'Alimenta tu Salud',
            // 'copasamsung' => 'Copa Samsung',
            'estrategiadigital' => 'http://www.estrategiadigital.expansion.com/',
            'pequenosjugadores' => 'http://www.pequenosjugadores.marca.com/',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            // 'extraordinarios' => 'Extraordinarios',
            'innovacionensalud' => 'http://www.innovacionensalud.elmundo.es/',
            // 'mastercard' => 'Mastercard',
            // 'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'http://www.nosvemosencasa.elmundo.es/',
            // 'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            'potenciatupyme' => 'http://potenciatupyme.elmundo.es/',
            // 'therightway' => 'The Right Way',
            'theventurespain' => 'http://www.theventurespain.expansion.com/',
            'unpaseoporelprado' => 'http://www.unpaseoporelprado.elmundo.es/',
            'vivirmasymejor' => 'http://www.vivirmasymejor.elmundo.es/',
            // 'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
        ],
        'options_name' => [
            'Tipo de Contenido' => 'type',
            'Formato' => 'format',
            'Estilos' => 'styles',
            'Scripts' => 'scripts',
            'Resumen' => 'summary',
            'Partido' => 'match',
            'Fecha' => 'date',
            'Autor' => 'author',
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
