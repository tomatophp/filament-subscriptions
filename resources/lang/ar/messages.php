<?php

return [
    "title" => "الاشتراك",
    "plans" => [
        "title" => "الخطط",
        "columns" => [
            "name" => "الاسم",
            "description" => "الوصف",
            "price" => "السعر",
            "signup_fee" => "رسوم التسجيل",
            "invoice_interval" => "فترة الفاتورة",
            "invoice_period" => "مدة الفاتورة",
            "trial_period" => "فترة التجربة",
            "is_active" => "هل هو نشط؟",
            "day" => "يوم",
            "month" => "شهر",
            "year" => "سنة",
        ]
    ],
    "features" => [
        "title" => "الميزات",
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
        'subscribe' => 'اشترك',
        'current_subscription' => 'الاشتراك الحالي',
        'renew_subscription' => 'تجديد الاشتراك',
        'change_subscription' => 'تغيير الاشتراك',
        'no_plans_available' => 'لا توجد خطط متاحة',
        'cancel_subscription' => 'إلغاء الاشتراك',
        'cancel_subscription_info' => 'يمكنك إلغاء اشتراكك في أي وقت. بمجرد إلغاء اشتراكك، سيكون لديك خيار استخدام الاشتراك حتى نهاية دورة الفوترة الحالية.',
        'return_to' => 'العودة إلى',
        'it_looks_like_no_active_subscription' => 'يبدو أنك لا تمتلك اشتراكًا نشطًا. يمكنك اختيار أحد خطط الاشتراك أدناه للبدء. يمكن تغيير أو إلغاء خطط الاشتراك حسب راحتك.',
    ]
];
