<?php

return [
    'printer' => [
        'connection_type' => env('ESCPOS_CONNECTION_TYPE', 'file'), // Default to file
        'file_path' => storage_path('escpos-printer-file'),
        'network' => [
            'ip' => env('ESCPOS_NETWORK_IP', '192.168.1.100'), // Default IP address
            'port' => env('ESCPOS_NETWORK_PORT', 9100), // Default port
        ],
        'usb' => [
            'com_port' => env('ESCPOS_USB_COM_PORT', 'COM1'), // Default COM port for USB connection
        ],
    ],
];
