<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.01.2017
 * Time: 18:44
 */
return [
    'model'              => 'models',
    'view'               => 'core/views/template',
    'layout'             => 'core/views/layout',
    'layoutExtension'    => 'php',
    'jsonExtension'      => 'json',
    'json'               => 'json',
    'modelFileLatest'    => '_d',
    'viewFileLatest'     => '_v',
    'viewBlank'          => 'blank',
    'modelExtension'     => 'php',
    'viewExtension'      => 'php',
    'headFile'           => 'head.tpl',
    'menuFileReg'        => 'menu_registration',
    'menuFileUnReg'      => 'menu',
    'menuPath'           => 'json',
    'menuRegExtension'   => 'json',
    'LANG'               => 1,
    'menuUnRegExtension' => 'json',
    'controllers'        => [
        'default'        => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'index'          => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'help'           => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionHelp'
            ]
        ],
        'view_count'     => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionView_count',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'add_number_sap' => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionAddNumberSap',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'load_forms'     => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionLoad_forms',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'calc_count'     => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionCalc_count',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'add_value'      => [
            'controllerName' => 'controllers\ControllerAdd',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionBlank'
            ]
        ],

        'calcgroup'  => [
            'controllerName' => 'controllers\ControllerView',
            'actions'        => [
                'default' => 'actionCalcGroup',
            ]
        ],
        'chartgroup' => [
            'controllerName' => 'controllers\ControllerView',
            'actions'        => [
                'default' => 'actionChartGroup',
            ]
        ],
        'ajax'       => [
            'controllerName' => 'controllers\ControllerAjax',
            'actions'        => [
                'default'              => 'ajaxBlank',                      // запрос по умолчанию или при любом не правильно сформированом запросе
                'subst_filter'         => 'ajaxSubstationFilter',           // Возвращает массив значений подстанций для фильтра
                'subst'                => 'ajaxSubstation',                 // Возвращает массив значений подстанций для формы
                'counter_filter'       => 'ajaxCounterFilter',              // Возвращает массив значений счётчиков для фильтра
                'counter'              => 'ajaxCounter',                    // Возвращает массив значений счётчиков для формы
                'getuser_all'          => 'ajaxGetUserAll',                 // Возвращает всех пользоватлей проекта
                'loadform_user'        => 'ajaxLoadFormUser',               // Загрузка данных в форму user
                'loadform_privelege'   => 'ajaxLoadFormPrivelege',          // Загрузка данных в форму привелегии
                'loadform_value'       => 'ajaxLoadFormValueCounter',       // Загрузка данных в форму редактирование счётчика
                'actionform_user'      => 'ajaxActionFormUser',             // Запись данных в таблицу пользователя. редактирование
                'actionform_privelege' => 'ajaxActionFormPrivelege',        // Запись данных в таблицу привелегии
                'actionform_value'     => 'ajaxActionFormValueCounter',     // Запись данных в главную таблицу счётчика
                'actionform_user_add'  => 'ajaxActionFormUserAdd',          // Запись данных в таблицу  пользоваталея. Добавление
                'menuleft'             => 'ajaxMenuLeft',                   // Возвращает массив данных для построения левого меню проекта
                'registration'         => 'ajaxRegistration',               // Регистрация пользователя  данные POST
                'unregistration'       => 'ajaxUnregistration',             // Выход пользователя с системы
                'lastvalue_counter'    => 'ajaxLastValueCounter',           // последнее значение введенное для данного счётчика
                'filterValue'          => 'ajaxFilterValue',                // Результаты по работе фильтров
                'calculation_counter'  => 'ajaxCalculationCounter',         // Расчёт расхода электроэнергии для заданного счётчика
                'calculation_group'    => 'ajaxCalculationGroup',           // Расчёт расхода электроэнергии для заданной группы
                'calculation_chart'    => 'ajaxCalculationChart',           // Расчёт расхода электроэнергии для заданной группы для графиков
                'nzakaz'               => 'ajaxNumberOrder',                 // Автозаполнение номера заказа
                'loadform_sap'         => 'ajaxSLoadFormSap',                // Загрузка данных в форму добавление нормера САП
                'actionform_sap'       => 'ajaxActionFormSap'                // Запись номера САПа в таблицу n_zakaz

            ]
        ],
    ]
];