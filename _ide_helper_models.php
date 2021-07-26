<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dish[] $dishes
 * @property-read int|null $dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property int|null $order_no
 * @property int|null $receipt_no
 * @property string|null $tin_no
 * @property float|null $discount
 * @property float|null $tip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTinNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 */
	class Configuration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomDish
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $pcs
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newQuery()
 * @method static \Illuminate\Database\Query\Builder|CustomDish onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CustomDish withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CustomDish withoutTrashed()
 */
	class CustomDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dish
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $add_on
 * @property int $sides
 * @property float $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $price_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish sideDish()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereAddOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereSides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereUpdatedAt($value)
 */
	class Dish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $waiter_id
 * @property string $order_number
 * @property int $pax
 * @property string $action
 * @property string $billing_type
 * @property string|null $address
 * @property string|null $contact
 * @property int $checked_out
 * @property float|null $total
 * @property float|null $cash
 * @property float|null $change
 * @property int $enable_discount
 * @property string|null $discount_type
 * @property float $discount
 * @property float|null $tip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomDish[] $customOrderDetails
 * @property-read int|null $custom_order_details_count
 * @property-read mixed $discount_option
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderDetails[] $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderReceipt[] $orderReceipts
 * @property-read int|null $order_receipts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Table[] $tables
 * @property-read int|null $tables_count
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCheckedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEnableDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWaiterId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetails
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $dish_id
 * @property array|null $side_dishes
 * @property int $pcs
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Dish|null $dish
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails drinks()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderDetails onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereSideDishes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderDetails withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderDetails withoutTrashed()
 */
	class OrderDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderReceipt
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $receipt_no
 * @property string $name
 * @property string $address
 * @property string $contact
 * @property float|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt whereUpdatedAt($value)
 */
	class OrderReceipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Table
 *
 * @property int $id
 * @property string $name
 * @property int $pax
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereUpdatedAt($value)
 */
	class Table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $employee_no
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $passcode
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Table[] $assignTables
 * @property-read int|null $assign_tables_count
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Role $role
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasscode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}
