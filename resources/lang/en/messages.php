<?php

return [
    "group" => "Subscription",
    "plans" => [
        "title" => "Plans",
        "columns" => [
            "name" => "Name",
            "description" => "Description",
            "price" => "Price",
            "signup_fee" => "Signup fee",
            "invoice_interval" => "Invoice interval",
            "invoice_period" => "Invoice period",
            "trial_interval" => "Trial interval",
            "trial_period" => "Trial period",
            "currency" => "Currency",
            "is_active" => "Is Active?",
            "day" => "Day",
            "month" => "Month",
            "year" => "Year",
        ]
    ],
    "features" => [
        "title" => "Features",
        "single" => "Feature",
        "columns" => [
            "name" => "Name",
            "description" => "Description",
            "value" => "Value",
            "resettable_interval" => "Resettable interval",
            "resettable_period" => "Resettable period",
            "day" => "Day",
            "month" => "Month",
            "year" => "Year",
        ]
    ],
    "subscriptions" => [
        "title" => "Subscriptions",
        "sections" => [
            "subscriber" => [
                "title" => "Subscriber",
                "description" => "Subscriber settings",
                "columns" => [
                    "subscriber_type" => "Subscriber type",
                    "subscriber" => "Subscriber",
                ]
            ],
            "plan" => [
                "title" => "Plan",
                "description" => "Plan settings",
                "columns" => [
                    "plan" => "Plan",
                    "use_custom_dates" => "Use Custom Dates",
                ]
            ],
            "custom_dates" => [
                "title" => "Use Custom Dates",
                "description" => "Custom dates settings",
                "columns" => [
                    "trial_ends_at" => "Trial Ends At",
                    "starts_at" => "Starts At",
                    "ends_at" => "Ends At",
                    "canceled_at" => "Canceled At",
                ]
            ],
        ],
        "columns" => [
            "active" => "Active",
            "subscriber" => "Subscriber",
            "plan" => "Plan",
            "trial_ends_at" => "Trial Ends At",
            "starts_at" => "Starts At",
            "ends_at" => "Ends At",
            "canceled_at" => "Canceled At",
        ],
        "filters" => [
            "date_range" => "Date Range",
            "start_date" => "Start Date",
            "end_date" => "End Date",
            "canceled" => "Canceled",
            "all" => "All",
            "yes" => "Yes",
            "no" => "No",
        ],
        "actions" => [
            "cancel" => "Cancel",
            "renew" => "Renew",
        ],
    ],
    "notifications" => [
        "invalid" => [
            "title" => "Invalid",
            "message" => "Invalid plan selected."
        ],
        "info" => [
            "title" => "Info",
            "message" => "You are already subscribed to this plan."
        ],
        "renew" => [
            "title" => "Success",
            "message" => "Subscription renewed successfully."
        ],
        "change" => [
            "title" => "Success",
            "message" => "Subscription plan changed successfully."
        ],
        "subscription" => [
            "title" => "Success",
            "message" => "Subscription successful."
        ],
        "no_active" => [
            "title" => "Error",
            "message" => "Subscription successful."
        ],
        "cancel" => [
            "title" => "Success",
            "message" => "Your subscription(s) have been successfully canceled you will be."
        ],
        "cancel_invalid" => [
            "title" => "Invalid",
            "message" => "An error occurred while canceling your subscription(s)."
        ],
    ],
    "view" => [
        'billing_management' => 'Billing Management',
        'signed_in_as' => 'Signed in as',
        'managing_billing_for' => 'Managing billing for',
        'our_billing_management' => 'Our billing management portal allows you to conveniently manage your subscription plan, payment method, and download your recent invoices.',
        'subscribe' => 'Subscribe',
        'trial' => 'trial',
        'free' => 'Free',
        'current_subscription' => 'Current Subscription',
        'renew_subscription' => 'Renew Subscription',
        'change_subscription' => 'Change Subscription',
        'cancel_subscription' => 'Cancel Subscription',
        'resubscribe' => 'Resubscribe',
        'cancel_subscription_info' => 'You may cancel your subscription at any time. Once your subscription has been cancelled, you will have the option to use the subscription until the end of the current billing cycle.',
        'no_plans_available' => 'No plans available',
        'return_to' => 'Return to Dashboard',
        'it_looks_like_no_active_subscription' => 'It looks like you do not have an active subscription. You may choose one of the subscription plans below to get started. Subscription plans may be changed or cancelled at your convenience.',
    ],
    "menu" => "Manage Subscriptions"
];
