<?php

return [
    'sourceLanguage' => 'en_US',
    'language' => 'en_US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => \common\components\Formatter::class,
            'defaultTimeZone' => 'Europe/Moscow',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyDecimalSeparator' => ',',
            'numberFormatterOptions' => [
                \NumberFormatter::MIN_FRACTION_DIGITS => 0,
                \NumberFormatter::MAX_FRACTION_DIGITS => 2
            ],
            'numberFormatterSymbols' => [
                \NumberFormatter::CURRENCY_SYMBOL => '<b>₽</b>',
            ]
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en_US',
                ],
            ],
        ],
    ],
];
