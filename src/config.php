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
        'nacidosparaserautonomos' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'efectopositivo' => [
            '720' => 720,
            '310' => 310,
            'th' => 50,
        ],
        'espiritufilantropico' => [
            '784' => 784,
            '650' => 650,
            '329' => 329,
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
            // 'alimentatusalud' => 'Alimenta tu Salud',
            // 'bodegasybebidas' => 'Bodegas y Bebidas',
            // 'caminosalternativos' => 'Caminos Alternativos',
            // 'copasamsung' => 'Copa Samsung',
            'correresdevalientes' => '¡Correr es de valientes!',
            'efectopositivo' => 'Efecto Positivo',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            'espiritufilantropico' => 'Espíritu Filantrópico',
            'estardondeestes' => 'Estar donde Estés',
            // 'estrategiadigital' => 'Estrategia Digital',
            // 'extraordinarios' => 'Extraordinarios',
            // 'futurosostenible' => 'Futuro Sostenible',
            'impulsodigital' => 'Impulso Digital',
            // 'innovacionensalud' => 'Innovación en Salud',
            // 'laprevia' => 'La Previa',
            'loquehayquever' => 'Lo que hay que ver',
            // 'mastercard' => 'Mastercard',
            'nacidosparaserautonomos' => 'Nacidos para ser Autónomos',
            'noesfutboleslaliga' => 'No es Fútbol es LaLiga',
            // 'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'Nos Vemos en Casa',
            // 'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            // 'pequenosjugadores' => 'Pequeños Jugadores',
            'planetainteligente' => 'Planeta Inteligente',
            'porunusolove' => 'Por un uso Love',
            // 'potenciatupyme' => 'Potencia tu Pyme',
            'revivetupelo' => 'Revive tu Pelo',
            'saludesvida' => 'Salud es Vida',
            // 'therightway' => 'The Right Way',
            // 'theventurespain' => 'The Venture Spain',
            'unpaseoporelprado' => 'Un Paseo por el Prado',
            // 'ventanaalfuturo' => 'Ventana al futuro',
            'vivirmasymejor' => 'Vivir Más y Mejor',
            // 'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
        ],
        'webs_url' => [
            'bodegasybebidas' => 'http://www.bodegasybebidas.fueradeserie.com/',
            'porunusolove' => 'http://porunusolove.elmundo.es/',
            'nacidosparaserautonomos' => 'http://nacidosparaserautonomos.elmundo.es/',
            'efectopositivo' => 'http://efectopositivo.elmundo.es/',
            'noesfutboleslaliga' => 'http://noesfutboleslaliga.elmundo.es/',
            'planetainteligente' => 'http://www.planetainteligente.elmundo.es/',
            'saludesvida' => 'http://www.saludesvida.marca.com/',
            'estardondeestes' => 'http://www.estardondeestes.elmundo.es/',
            'espiritufilantropico' => 'http://espiritufilantropico.elmundo.es/',
            'revivetupelo' => 'http://www.revivetupelo.telva.com/',
            'futurosostenible' => 'http://www.futurosostenible.elmundo.es/',
            'caminosalternativos' => 'http://www.caminosalternativos.elmundo.es/',
            'correresdevalientes' => 'http://www.correresdevalientes.elmundo.es/',
            'ventanaalfuturo' => 'http://www.ventanaalfuturo.elmundo.es/',
            'loquehayquever' => 'http://www.loquehayquever.elmundo.es/',
            'laprevia' => 'http://www.laprevia.marca.com/',
            'alimentatusalud' => 'Alimenta tu Salud',
            'copasamsung' => 'Copa Samsung',
            'estrategiadigital' => 'http://www.estrategiadigital.expansion.com/',
            'elclubdelabarba' => 'El Club de la Barba',
            'entregados' => 'Entregados',
            'extraordinarios' => 'Extraordinarios',
            'impulsodigital' => 'http://www.impulsodigital.elmundo.es/',
            'innovacionensalud' => 'http://www.innovacionensalud.elmundo.es/',
            'mastercard' => 'Mastercard',
            'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'http://www.nosvemosencasa.elmundo.es/',
            'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            'paddockclub' => 'Paddock Club',
            'pequenosjugadores' => 'http://www.pequenosjugadores.marca.com/',
            'potenciatupyme' => 'http://potenciatupyme.elmundo.es/',
            'therightway' => 'The Right Way',
            'theventurespain' => 'http://www.theventurespain.expansion.com/',
            'unpaseoporelprado' => 'http://www.unpaseoporelprado.elmundo.es/',
            'vivirmasymejor' => 'http://www.vivirmasymejor.elmundo.es/',
            'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
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
            'Patrocinador' => 'partner',
            'Podcast' => 'podcast',
            'Pixel' => 'pixel',
            'URL' => 'url',
            'Caption' => 'caption',
            'Antetítulo' => 'kicker',
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
