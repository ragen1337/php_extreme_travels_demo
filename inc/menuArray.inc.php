<?php

$menuArray = [
    0 => [
        name => "Главная",
        href => "",
        submenu => null,
    ],
    1 => [
        name => "Туры",
        href => "?page=tours",
        submenu => null,
    ],
    2 => [
        name => "Агенствам",
        href => "?page=commonInfo",
        submenu => [
            0 => [
                name => "Общая информация",
                href => "?page=commonInfo",
            ],
            1 => [
                name => "Начало сотрудничества",
                href => "?page=cooperation",
            ],
        ],
    ],
    3 => [
        name => "О компании",
        href => "?page=contacts",
        submenu => [
            0 => [
                name => "Контакты",
                href => "?page=contacts",
            ],
            1 => [
                name => "Вопросы и ответы",
                href => "?page=faq",
            ],
        ],
    ],
    4 => [
        name => "Фотогалерея",
        href => "?page=photos",
        submenu => null,
    ],
];
