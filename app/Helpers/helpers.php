<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('format_price')) {
    /**
     * Formater un prix
     */
    function format_price($price, $currency = 'DH')
    {
        return number_format($price, 2, ',', ' ') . ' ' . $currency;
    }
}

if (!function_exists('get_active_locale')) {
    /**
     * Récupérer la langue active
     */
    function get_active_locale()
    {
        return app()->getLocale();
    }
}

if (!function_exists('is_active_locale')) {
    /**
     * Vérifier si la langue active est celle passée
     */
    function is_active_locale($locale)
    {
        return app()->getLocale() === $locale;
    }
}

if (!function_exists('generate_seo_title')) {
    /**
     * Générer un titre SEO à partir d'un titre normal
     */
    function generate_seo_title($title, $suffix = null)
    {
        $seoTitle = $title;

        if ($suffix) {
            $seoTitle .= ' | ' . $suffix;
        }

        return $seoTitle;
    }
}

if (!function_exists('status_badge')) {
    /**
     * Générer un badge HTML pour un statut
     */
    if (!function_exists('status_badge')) {
        function status_badge($status, $type = 'formation')
        {
            // Si c'est un objet (Enum), prendre sa valeur
            if (is_object($status)) {
                if (method_exists($status, 'value')) {
                    $status = $status->value;
                } elseif (method_exists($status, 'label')) {
                    // Si c'est déjà un Enum avec label
                    return "<span class='badge badge-" . $status->color() . "'>" . $status->label() . "</span>";
                }
            }

            // S'assurer que $status est une string
            $status = (string) $status;

            $colors = [
                'formation' => [
                    'brouillon' => 'warning',
                    'publie' => 'success',
                    'archive' => 'danger',
                ],
                'inscription' => [
                    'pending' => 'warning',
                    'confirmed' => 'success',
                    'cancelled' => 'danger',
                ],
                'session' => [
                    'scheduled' => 'info',
                    'ongoing' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                ],
                'blog' => [
                    'brouillon' => 'warning',
                    'publie' => 'success',
                ],
            ];

            $color = $colors[$type][$status] ?? 'secondary';

            $labels = [
                'brouillon' => 'Brouillon',
                'publie' => 'Publié',
                'archive' => 'Archivé',
                'pending' => 'En attente',
                'confirmed' => 'Confirmé',
                'cancelled' => 'Annulé',
                'scheduled' => 'Planifiée',
                'ongoing' => 'En cours',
                'completed' => 'Terminée',
            ];

            $label = $labels[$status] ?? ucfirst($status);

            return "<span class='badge badge-{$color}'>{$label}</span>";
        }
    }
}

if (!function_exists('get_setting')) {
    /**
     * Récupérer un paramètre global
     */
    function get_setting($key, $default = null)
    {
        // Si vous avez une table settings
        // return \App\Models\Setting::where('key', $key)->value('value') ?? $default;

        // Version simple avec config
        return config("settings.{$key}", $default);
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Tronquer un texte
     */
    function truncate_text($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return Str::limit($text, $length, $suffix);
    }
}

if (!function_exists('format_date')) {
    /**
     * Formater une date selon la langue
     */
    function format_date($date, $format = null)
    {
        if (!$date)
            return '';

        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        $formats = [
            'fr' => 'd/m/Y',
            'en' => 'm/d/Y',
        ];

        $format = $format ?? $formats[app()->getLocale()] ?? 'd/m/Y';

        return $date->format($format);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Formater une date et heure selon la langue
     */
    function format_datetime($date, $format = null)
    {
        if (!$date)
            return '';

        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        $formats = [
            'fr' => 'd/m/Y H:i',
            'en' => 'm/d/Y H:i',
        ];

        $format = $format ?? $formats[app()->getLocale()] ?? 'd/m/Y H:i';

        return $date->format($format);
    }
}

if (!function_exists('locale_url')) {
    /**
     * Générer une URL avec la langue
     */
    function locale_url($route, $parameters = [], $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $parameters = array_merge(['locale' => $locale], $parameters);
        return route($route, $parameters);
    }
}

if (!function_exists('alternate_urls')) {
    /**
     * Générer les URLs alternatives pour hreflang
     */
    function alternate_urls($route, $parameters = [])
    {
        $urls = [];
        foreach (['fr', 'en'] as $locale) {
            $urls[$locale] = route($route, array_merge($parameters, ['locale' => $locale]));
        }
        return $urls;
    }
}

if (!function_exists('get_days_left')) {
    /**
     * Nombre de jours restants
     */
    function get_days_left($date)
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);
        $days = Carbon::now()->diffInDays($date, false);

        if ($days < 0) {
            return 'Terminé';
        } elseif ($days == 0) {
            return 'Aujourd\'hui';
        } elseif ($days == 1) {
            return 'Demain';
        }

        return $days . ' jours restants';
    }
}
if (!function_exists('__t')) {
    /**
     * Traduction rapide sans fichiers de langue
     */
    function __t($key, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $translations = [
            'fr' => [
                'Contact' => 'Contact',
                'Send us a message, we will reply quickly.' => 'Envoyez-nous un message, nous vous répondrons rapidement.',
                'An error occurred.' => 'Une erreur est survenue.',
                'Full name' => 'Nom complet',
                'Your name' => 'Votre nom',
                'Message subject' => 'Sujet du message',
                'Your message...' => 'Votre message...',
                'Send message' => 'Envoyer le message',
                'Sending...' => 'Envoi en cours...',
                // Navigation
                'Dashboard' => 'Tableau de bord',
                'Formations' => 'Formations',
                'Trainings' => 'Formations',
                'Categories' => 'Catégories',
                'Sessions' => 'Sessions',
                'Registrations' => 'Inscriptions',
                'Users' => 'Utilisateurs',
                'Blog' => 'Blog',
                'Contacts' => 'Contacts',
                'Main Menu' => 'Menu Principal',
                'Management' => 'Gestion',
                'Content' => 'Contenu',
                'Administration' => 'Administration',

                // Actions
                'View all' => 'Voir tout',
                'Add' => 'Ajouter',
                'Edit' => 'Modifier',
                'Delete' => 'Supprimer',
                'Save' => 'Enregistrer',
                'Cancel' => 'Annuler',
                'Back' => 'Retour',
                'Search' => 'Rechercher',
                'Logout' => 'Déconnexion',
                'Login' => 'Connexion',
                'Register' => 'Inscription',

                // Dashboard
                'Latest Trainings' => 'Dernières Formations',
                'Latest Registrations' => 'Dernières Inscriptions',
                'Title' => 'Titre',
                'Category' => 'Catégorie',
                'Status' => 'Statut',
                'Participant' => 'Participant',
                'Session' => 'Session',
                'Total' => 'Total',

                // Status
                'published' => 'Publié',
                'draft' => 'Brouillon',
                'archived' => 'Archivé',
                'pending' => 'En attente',
                'confirmed' => 'Confirmé',
                'cancelled' => 'Annulé',
                'active' => 'Actif',
                'inactive' => 'Inactif',

                // Messages
                'Delete this item?' => 'Supprimer cet élément ?',
                'Deleted successfully!' => 'Supprimé avec succès !',
                'Status updated' => 'Statut mis à jour',
                'No results found' => 'Aucun résultat trouvé',

                // Roles
                'Administrator' => 'Administrateur',
                'Super Administrator' => 'Super Administrateur',
                'Trainer' => 'Formateur',
                'Participant' => 'Participant',

                'Name' => 'Nom',
                'Email' => 'Email',
                'Phone' => 'Téléphone',
                'Subject' => 'Sujet',
                'Message' => 'Message',
                'Date' => 'Date',
                'Read' => 'Lu',
                'Unread' => 'Non lu',
                'Add Category' => 'Ajouter Catégorie',
                'Search category...' => 'Rechercher catégorie...',
                'Name FR' => 'Nom FR',
                'Name EN' => 'Nom EN',
                'No categories found' => 'Aucune catégorie trouvée',
                'Add Training' => 'Ajouter Formation',
                'Search training...' => 'Rechercher formation...',
                'Image' => 'Image',
                'Title FR' => 'Titre FR',
                'Title EN' => 'Titre EN',
                'Duration' => 'Durée',
                'Price' => 'Prix',
                'Level' => 'Niveau',
                'No trainings found' => 'Aucune formation trouvée',
                'Add Session' => 'Ajouter Session',
                'Search session...' => 'Rechercher session...',
                'Training' => 'Formation',
                'Trainer' => 'Formateur',
                'Start' => 'Début',
                'End' => 'Fin',
                'Capacity' => 'Capacité',
                'Mode' => 'Mode',
                'City' => 'Ville',
                'No sessions found' => 'Aucune session trouvée',
                'Add Registration' => 'Ajouter Inscription',
                'Search registration...' => 'Rechercher inscription...',
                'Reference' => 'Référence',
                'Note' => 'Note',
                'Confirmed at' => 'Confirmé le',
                'Cancelled at' => 'Annulé le',
                'No registrations found' => 'Aucune inscription trouvée',
                'Add Article' => 'Ajouter Article',
                'Search article...' => 'Rechercher article...',
                'Author' => 'Auteur',
                'Published at' => 'Publié le',
                'No articles found' => 'Aucun article trouvé',
                'Add User' => 'Ajouter Utilisateur',
                'Search user...' => 'Rechercher utilisateur...',
                'Role' => 'Rôle',
                'Language' => 'Langue',
                'Active' => 'Actif',
                'Inactive' => 'Inactif',
                'No users found' => 'Aucun utilisateur trouvé',
            ],
            'en' => [
                'Contact' => 'Contact',
                'Send us a message, we will reply quickly.' => 'Send us a message, we will reply quickly.',
                'An error occurred.' => 'An error occurred.',
                'Full name' => 'Full name',
                'Your name' => 'Your name',
                'Message subject' => 'Message subject',
                'Your message...' => 'Your message...',
                'Send message' => 'Send message',
                'Sending...' => 'Sending...',
                'Name' => 'Name',
                'Email' => 'Email',
                'Phone' => 'Phone',
                'Subject' => 'Subject',
                'Message' => 'Message',
                'Date' => 'Date',
                'Read' => 'Read',
                'Unread' => 'Unread',
                'Add Category' => 'Add Category',
                'Search category...' => 'Search category...',
                'Name FR' => 'Name FR',
                'Name EN' => 'Name EN',
                'No categories found' => 'No categories found',
                'Add Training' => 'Add Training',
                'Search training...' => 'Search training...',
                'Image' => 'Image',
                'Title FR' => 'Title FR',
                'Title EN' => 'Title EN',
                'Duration' => 'Duration',
                'Price' => 'Price',
                'Level' => 'Level',
                'No trainings found' => 'No trainings found',
                'Add Session' => 'Add Session',
                'Search session...' => 'Search session...',
                'Training' => 'Training',
                'Trainer' => 'Trainer',
                'Start' => 'Start',
                'End' => 'End',
                'Capacity' => 'Capacity',
                'Mode' => 'Mode',
                'City' => 'City',
                'No sessions found' => 'No sessions found',
                'Add Registration' => 'Add Registration',
                'Search registration...' => 'Search registration...',
                'Reference' => 'Reference',
                'Note' => 'Note',
                'Confirmed at' => 'Confirmed at',
                'Cancelled at' => 'Cancelled at',
                'No registrations found' => 'No registrations found',
                'Add Article' => 'Add Article',
                'Search article...' => 'Search article...',
                'Author' => 'Author',
                'Published at' => 'Published at',
                'No articles found' => 'No articles found',
                'Add User' => 'Add User',
                'Search user...' => 'Search user...',
                'Role' => 'Role',
                'Language' => 'Language',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
                'No users found' => 'No users found',
                // Navigation
                'Dashboard' => 'Dashboard',
                'Formations' => 'Trainings',
                'Trainings' => 'Trainings',
                'Categories' => 'Categories',
                'Sessions' => 'Sessions',
                'Registrations' => 'Registrations',
                'Users' => 'Users',
                'Blog' => 'Blog',
                'Contacts' => 'Contacts',
                'Main Menu' => 'Main Menu',
                'Management' => 'Management',
                'Content' => 'Content',
                'Administration' => 'Administration',

                // Actions
                'View all' => 'View all',
                'Add' => 'Add',
                'Edit' => 'Edit',
                'Delete' => 'Delete',
                'Save' => 'Save',
                'Cancel' => 'Cancel',
                'Back' => 'Back',
                'Search' => 'Search',
                'Logout' => 'Logout',
                'Login' => 'Login',
                'Register' => 'Register',

                // Dashboard
                'Latest Trainings' => 'Latest Trainings',
                'Latest Registrations' => 'Latest Registrations',
                'Title' => 'Title',
                'Category' => 'Category',
                'Status' => 'Status',
                'Participant' => 'Participant',
                'Session' => 'Session',
                'Total' => 'Total',

                // Status
                'published' => 'Published',
                'draft' => 'Draft',
                'archived' => 'Archived',
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'cancelled' => 'Cancelled',
                'active' => 'Active',
                'inactive' => 'Inactive',

                // Messages
                'Delete this item?' => 'Delete this item?',
                'Deleted successfully!' => 'Deleted successfully!',
                'Status updated' => 'Status updated',
                'No results found' => 'No results found',

                // Roles
                'Administrator' => 'Administrator',
                'Super Administrator' => 'Super Administrator',
                'Trainer' => 'Trainer',
                'Participant' => 'Participant',
            ],
        ];

        return $translations[$locale][$key] ?? $key;
    }
}

if (!function_exists('get_level_label')) {
    /**
     * Label pour le niveau de formation
     */
    function get_level_label($level)
    {
        $labels = [
            'débutant' => 'Débutant',
            'intermédiaire' => 'Intermédiaire',
            'avancé' => 'Avancé',
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
        ];

        return $labels[$level] ?? ucfirst($level);
    }
}

if (!function_exists('get_mode_label')) {
    /**
     * Label pour le mode de session
     */
    function get_mode_label($mode)
    {
        $labels = [
            'presentiel' => 'Présentiel',
            'online' => 'En ligne',
            'hybride' => 'Hybride',
        ];

        return $labels[$mode] ?? ucfirst($mode);
    }
}