<?php

namespace AppBundle\Twig;

/**
 * Filtre Twig pour n'utiliser en href que les URL dont le schéma est http ou https.
 * Évite les XSS via javascript:, data:, vbscript:, etc.
 */
class SafeUrlExtension extends \Twig_Extension
{
    /**
     * Schémas autorisés pour les liens (en minuscules).
     */
    private static $allowedSchemes = ['http', 'https'];

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('safe_href', [$this, 'safeHref']),
        ];
    }

    /**
     * Retourne l'URL si son schéma est http ou https, sinon une chaîne vide.
     *
     * @param string|null $url
     * @return string
     */
    public function safeHref($url)
    {
        if ($url === null || $url === '') {
            return '';
        }
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        $pos = strpos($url, ':');
        if ($pos === false) {
            return '';
        }
        $scheme = strtolower(substr($url, 0, $pos));

        return in_array($scheme, self::$allowedSchemes, true) ? $url : '';
    }

    public function getName()
    {
        return 'app_safe_url';
    }
}
