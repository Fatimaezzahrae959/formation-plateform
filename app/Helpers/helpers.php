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