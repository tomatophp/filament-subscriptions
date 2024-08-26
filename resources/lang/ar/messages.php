<?php

return [
    "group" => "الاشتراك",
    "plans" => [
        "title" => "الخطط",
        "columns" => [
            "name" => "الاسم",
            "description" => "الوصف",
            "price" => "السعر",
            "signup_fee" => "رسوم التسجيل",
            "invoice_interval" => "فترة الفاتورة",
            "invoice_period" => "مدة الفاتورة",
            "trial_interval" => "فترة التجربة",
            "trial_period" => "مدة التجربة",
            "currency" => "العملة",
            "is_active" => "هل هو نشط؟",
            "day" => "يوم",
            "month" => "شهر",
            "year" => "سنة",
        ]
    ],
    "features" => [
        "title" => "المميزات",
        "single" => "ميزة",
        "columns" => [
            "name" => "الاسم",
            "description" => "الوصف",
            "value" => "القيمة",
            "resettable_interval" => "فترة إعادة الضبط",
            "resettable_period" => "مدة إعادة الضبط",
            "day" => "يوم",
            "month" => "شهر",
            "year" => "سنة",
        ]
    ],
    "subscriptions" => [
        "title" => "الاشتراكات",
        "sections" => [
            "subscriber" => [
                "title" => "المشترك",
                "description" => "إعدادات المشترك",
                "columns" => [
                    "subscriber_type" => "نوع المشترك",
                    "subscriber" => "المشترك",
                ]
            ],
            "plan" => [
                "title" => "الخطة",
                "description" => "إعدادات الخطة",
                "columns" => [
                    "plan" => "الخطة",
                    "use_custom_dates" => "استخدام تواريخ مخصصة",
                ]
            ],
            "custom_dates" => [
                "title" => "استخدام تواريخ مخصصة",
                "description" => "إعدادات التواريخ المخصصة",
                "columns" => [
                    "trial_ends_at" => "تنتهي فترة التجربة في",
                    "starts_at" => "يبدأ في",
                    "ends_at" => "ينتهي في",
                    "canceled_at" => "ألغيت في",
                ]
            ],
        ],
        "columns" => [
            "active" => "نشط",
            "subscriber" => "المشترك",
            "plan" => "الخطة",
            "trial_ends_at" => "تنتهي فترة التجربة في",
            "starts_at" => "يبدأ في",
            "ends_at" => "ينتهي في",
            "canceled_at" => "ألغيت في",
        ],
        "filters" => [
            "date_range" => "نطاق التاريخ",
            "start_date" => "تاريخ البدء",
            "end_date" => "تاريخ الانتهاء",
            "canceled" => "ملغى",
            "all" => "الكل",
            "yes" => "نعم",
            "no" => "لا",
        ],
        "actions" => [
            "cancel" => "إلغاء",
            "renew" => "تجديد",
        ]
    ],
    "notifications" => [
        "invalid" => [
            "title" => "غير صالح",
            "message" => "الخطة المختارة غير صالحة."
        ],
        "info" => [
            "title" => "معلومات",
            "message" => "أنت بالفعل مشترك في هذه الخطة."
        ],
        "renew" => [
            "title" => "نجاح",
            "message" => "تم تجديد الاشتراك بنجاح."
        ],
        "change" => [
            "title" => "نجاح",
            "message" => "تم تغيير خطة الاشتراك بنجاح."
        ],
        "subscription" => [
            "title" => "نجاح",
            "message" => "الاشتراك ناجح."
        ],
        "no_active" => [
            "title" => "خطأ",
            "message" => "لا يوجد اشتراك نشط."
        ],
        "cancel" => [
            "title" => "نجاح",
            "message" => "تم إلغاء اشتراكك(ات) بنجاح."
        ],
        "cancel_invalid" => [
            "title" => "غير صالح",
            "message" => "حدث خطأ أثناء إلغاء اشتراكك(ات)."
        ],
    ],
    "view" => [
        'billing_management' => 'إدارة الفواتير',
        'signed_in_as' => 'مسجل الدخول كـ',
        'managing_billing_for' => 'إدارة الفواتير لـ',
        'our_billing_management' => 'يتيح لك بوابة إدارة الفواتير لدينا إدارة خطة الاشتراك الخاصة بك، وطريقة الدفع، وتنزيل الفواتير الأخيرة بسهولة.',
        'subscribe' => 'اشترك',
        'trial' => 'تجريبي',
        'free' => 'مجاني',
        'current_subscription' => 'الاشتراك الحالي',
        'renew_subscription' => 'تجديد الاشتراك',
        'change_subscription' => 'تغيير الاشتراك',
        'cancel_subscription' => 'إلغاء الاشتراك',
        'resubscribe' => 'إعادة الاشتراك',
        'cancel_subscription_info' => 'يمكنك إلغاء اشتراكك في أي وقت. بعد إلغاء الاشتراك، سيكون لديك خيار استخدام الاشتراك حتى نهاية دورة الفوترة الحالية.',
        'no_plans_available' => 'لا توجد خطط متاحة',
        'return_to' => 'العودة إلي لوحة التحكم',
        'it_looks_like_no_active_subscription' => 'يبدو أنك لا تملك اشتراكاً نشطاً. يمكنك اختيار إحدى خطط الاشتراك أدناه للبدء. يمكن تغيير أو إلغاء خطط الاشتراك حسب راحتك.',
    ],
    "menu" => "إدارة الاشتراكات"
];
