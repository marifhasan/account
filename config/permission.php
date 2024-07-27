<?php

/**
 * PRODUCTION
 */
$job = [
    'store' => 'job.store',
    'update' => 'job.update',
    'destroy' => 'job.destroy',
];

/**
 * ACCOUNT
 */
$payment = [
    'store' => 'payment.store',
    'update' => 'payment.update',
    'destroy' => 'payment.destroy',
];

$payment = [
    'store' => 'payment.store',
    'update' => 'payment.update',
    'destroy' => 'payment.destroy',
];

$purchase = [
    'store' => 'purchase.store',
    'update' => 'purchase.update',
    'destroy' => 'purchase.destroy',
];

$transaction = [
    'store' => 'transaction.store',
];

/**
 * OPERATION
 */
$delivery = [
    'store' => 'delivery.store',
    'update' => 'delivery.update',
    'destroy' => 'delivery.destroy',
];

$stock = [
    'store' => 'stock.store',
    'update' => 'stock.update',
    'destroy' => 'stock.destroy',
];

/**
 * MANAGE
 */
$account = [
    'store' => 'account.store',
    'update' => 'account.update',
    'destroy' => 'account.destroy',
];

$client = [
    'store' => 'client.store',
    'update' => 'client.update',
    'destroy' => 'client.destroy',
];

$product = [
    'store' => 'product.store',
    'details' => 'product.details',
    'update' => 'product.update',
    'destroy' => 'product.destroy',
];

$material = [
    'store' => 'material.store',
    'details' => 'material.details',
    'update' => 'material.update',
    'destroy' => 'material.destroy',
];

$supplier = [
    'store' => 'supplier.store',
    'update' => 'supplier.update',
    'destroy' => 'supplier.destroy',
];

$user = [
    'store' => 'user.store',
    'update' => 'user.update',
    'destroy' => 'user.destroy',
];

/**
 * SYSTEM
 */
$material_category = [
    'store' => 'category.store',
    'update' => 'category.update',
    'destroy' => 'category.destroy',
];

$designation = [
    'store' => 'designation.store',
    'update' => 'designation.update',
    'destroy' => 'designation.destroy',
];

$role = [
    'permission_update' => 'role.permission.update',
];

$sector = [
    'store' => 'sector.store',
    'update' => 'sector.update',
    'destroy' => 'sector.destroy',
];

$setting = [
    'update' => 'setting.update',
];

$type = [
    'store' => 'type.store',
    'update' => 'type.update',
    'destroy' => 'type.destroy',
];

$unit = [
    'store' => 'unit.store',
    'update' => 'unit.update',
    'destroy' => 'unit.destroy',
];

return [

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    |
    | permission menu, key as permission key and value as route name
    |
    */

    'account' => [
        'balance_Transfer' => $transaction,
        'payment_/_Petty_Cash' => $payment,
        'purchase' => $purchase,
        'purchase_Status_Change' => ['purchase.status'],
        'payment' => $payment,
        'payment_Status_Change' => ['payment.status'],
    ],

    'operation' => [
        'job' => $job,
        'job_Status_Change' => ['job.status'],
        'stock_(Material)' => $stock,
    ],

    'manage' => [
        'account' => $account,
        'client' => $client,
        'product' => $product,
        'material' => $material,
        'supplier' => $supplier,
        'user' => $user,
        'user_Status_Change' => ['user.status'],
    ],

    'system' => [
        'category_(Material)' => $material_category,
        'designation' => $designation,
        'role_(User)' => $role,
        'sector_(Payment)' => $sector,
        'setting' => $setting,
        'type_(Product)' => $type,
        'unit' => $unit,
    ],

];
