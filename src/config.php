<?php
#configurations file
$GLOBALS['config'] = [
    'info' => [
        'owner_mail' => 'uestudio@unidadeditorial.es',
        'owner_name' => 'Innovación en Salud',
        'web_name' => 'innovacionensalud',
        'session_name' => 'innovacionensaludsession',
        'secret_word' => 'simbiosis',
    ],
    'security' => [
        'min_level' => 3,
        'cookie_minutes' => 120,
    ],
    'uploads_dir' => __DIR__.'/../public/uploads/',
    'images' => [
        'pequenosjugadores' => [
            '544' => 544,
            '282' => 282,
            'th' => 50,
        ]
    ],
    'locales' => [
        'es' => 'es_ES.UTF-8',
    ],
    'enum' => [
        'webs_name' => [
            'alimentatusalud' => 'Alimenta tu Salud',
            'copasamsung' => 'Copa Samsung',
            'pequenosjugadores' => 'Pequeños Jugadores',
            // 'elclubdelabarba' => 'El Club de la Barba',
            // 'entregados' => 'Entregados',
            'extraordinarios' => 'Extraordinarios',
            'innovacionensalud' => 'Innovación en Salud',
            // 'mastercard' => 'Mastercard',
            // 'nosmovemos' => 'Nos Movemos',
            'nosvemosencasa' => 'Nos Vemos en Casa',
            'otrasmanerasdevivir' => 'Otras Maneras de Vivir',
            // 'paddockclub' => 'Paddock Club',
            'potenciatupyme' => 'Potencia tu Pyme',
            // 'therightway' => 'The Right Way',
            'theventurespain' => 'The Venture Spain',
            'unpaseoporelprado' => 'Un Paseo por el Prado',
            'vivirmasymejor' => 'Vivir Más y Mejor',
            'yodonabeautybrandsplace' => 'YoDona Beauty Brands Place'
        ],
        'options_name' => [
            'Autor' => 'author',
            'Tipo de Contenido' => 'type',
            'Estilos' => 'styles',
            'Scripts' => 'scripts',
        ],
        'options' => [
            'adrian-salso',
            'ana-martinez',
            'ana-nimo',
            'aurora-yanez',
            'dayana-gomes',
            'doctor-vicente',
            'itziar-digon',
            'javier-subiza',
            'javier-calatrava',
            'laura-calles',
            'laura-lopez',
            'lucia-serrano',
            'melania-moya',
            'michelangelo-marra',
            'natalia-ageitos',
            'olalla-uriarte',
            'patricia-jorda',
            'silvia-gonzalez',
            'video',
            'content',
            'special',
            'gallery',
            'list',
        ]
    ],
];
