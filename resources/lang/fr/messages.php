<?php

return [
    "group" => "Abonnement",
    "plans" => [
        "title" => "Plans",
        "columns" => [
            "name" => "Nom",
            "description" => "Description",
            "price" => "Prix",
            "signup_fee" => "Frais d'inscription",
            "invoice_interval" => "Intervalle de facturation",
            "invoice_period" => "Période de facturation",
            "trial_interval" => "Intervalle d'essai",
            "trial_period" => "Période d'essai",
            "currency" => "Devise",
            "is_active" => "Est actif?",
            "day" => "Jour",
            "month" => "Mois",
            "year" => "Année",
        ]
    ],
    "features" => [
        "title" => "Caractéristiques",
        "single" => "Caractéristique",
        "columns" => [
            "name" => "Nom",
            "description" => "Description",
            "value" => "Valeur",
            "resettable_interval" => "Intervalle réinitialisable",
            "resettable_period" => "Période réinitialisable",
            "day" => "Jour",
            "month" => "Mois",
            "year" => "Année",
        ]
    ],
    "subscriptions" => [
        "title" => "Abonnements",
        "sections" => [
            "subscriber" => [
                "title" => "Abonné",
                "description" => "Paramètres de l'abonné",
                "columns" => [
                    "subscriber_type" => "Type d'abonné",
                    "subscriber" => "Abonné",
                ]
            ],
            "plan" => [
                "title" => "Plan",
                "description" => "Paramètres du plan",
                "columns" => [
                    "plan" => "Plan",
                    "use_custom_dates" => "Utiliser des dates personnalisées",
                ]
            ],
            "custom_dates" => [
                "title" => "Utiliser des dates personnalisées",
                "description" => "Paramètres des dates personnalisées",
                "columns" => [
                    "trial_ends_at" => "Fin de l'essai",
                    "starts_at" => "Commence le",
                    "ends_at" => "Se termine le",
                    "canceled_at" => "Annulé le",
                ]
            ],
        ],
        "columns" => [
            "active" => "Actif",
            "subscriber" => "Abonné",
            "plan" => "Plan",
            "trial_ends_at" => "Fin de l'essai",
            "starts_at" => "Commence le",
            "ends_at" => "Se termine le",
            "canceled_at" => "Annulé le",
        ],
        "filters" => [
            "date_range" => "Plage de dates",
            "start_date" => "Date de début",
            "end_date" => "Date de fin",
            "canceled" => "Annulé",
            "all" => "Tous",
            "yes" => "Oui",
            "no" => "Non",
        ],
        "actions" => [
            "cancel" => "Annuler",
            "renew" => "Renouveler",
        ],
    ],
    "notifications" => [
        "invalid" => [
            "title" => "Invalide",
            "message" => "Plan sélectionné invalide."
        ],
        "info" => [
            "title" => "Info",
            "message" => "Vous êtes déjà abonné à ce plan."
        ],
        "renew" => [
            "title" => "Succès",
            "message" => "Abonnement renouvelé avec succès."
        ],
        "change" => [
            "title" => "Succès",
            "message" => "Plan d'abonnement changé avec succès."
        ],
        "subscription" => [
            "title" => "Succès",
            "message" => "Abonnement réussi."
        ],
        "no_active" => [
            "title" => "Erreur",
            "message" => "Aucun abonnement actif."
        ],
        "cancel" => [
            "title" => "Succès",
            "message" => "Votre(vos) abonnement(s) ont été annulés avec succès."
        ],
        "cancel_invalid" => [
            "title" => "Invalide",
            "message" => "Une erreur s'est produite lors de l'annulation de votre(vos) abonnement(s)."
        ],
    ],
    "view" => [
        'billing_management' => 'Gestion de la facturation',
        'signed_in_as' => 'Connecté en tant que',
        'managing_billing_for' => 'Gérer la facturation pour',
        'our_billing_management' => 'Notre portail de gestion de la facturation vous permet de gérer facilement votre plan d\'abonnement, votre méthode de paiement, et de télécharger vos factures récentes.',
        'subscribe' => 'S\'abonner',
        'trial' => 'essai',
        'free' => 'Gratuit',
        'current_subscription' => 'Abonnement actuel',
        'renew_subscription' => 'Renouveler l\'abonnement',
        'change_subscription' => 'Changer d\'abonnement',
        'cancel_subscription' => 'Annuler l\'abonnement',
        'resubscribe' => 'Se réabonner',
        'cancel_subscription_info' => 'Vous pouvez annuler votre abonnement à tout moment. Une fois votre abonnement annulé, vous aurez la possibilité de l\'utiliser jusqu\'à la fin du cycle de facturation actuel.',
        'no_plans_available' => 'Aucun plan disponible',
        'return_to' => 'Retourner au tableau de bord',
        'it_looks_like_no_active_subscription' => 'Il semble que vous n\'ayez pas d\'abonnement actif. Vous pouvez choisir un des plans d\'abonnement ci-dessous pour commencer. Les plans d\'abonnement peuvent être modifiés ou annulés à votre convenance.',
    ],
    "menu" => "Gérer les abonnements"
];
