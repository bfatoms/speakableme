<?php


return [
    'permissions' => [
        'superadmin' => [
            'browse-all',
            'create-all',
            'store-all',
            'edit-all',
            'update-all',
            'delete-all',
            'read-all',
            'do-all'
        ],
        'student' => [
            'browse-schedule',
            'edit-schedule',
            'update-schedule',
            'read-schedule',
            'browse-order',
            'create-order',
            'store-order',
            'edit-order',
            'update-order',
            'read-order',
            'browse-profile',
            'create-profile',
            'store-profile',
            'edit-profile',
            'update-profile',
            'read-profile',
            'login',
            'book-schedule',
            'view-teacher-profile'
        ],
        'teacher' => [
            'browse-schedule',
            'create-schedule',
            'store-schedule',
            'edit-schedule',
            'update-schedule',
            'delete-schedule',
            'read-schedule',
            'browse-profile',
            'create-profile',
            'store-profile',
            'edit-profile',
            'update-profile',
            'read-profile',
            'login',
            'open-schedule',
            'view-student-profile',
        ]
    ]
];