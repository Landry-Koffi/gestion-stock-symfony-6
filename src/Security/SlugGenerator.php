<?php

namespace App\Security;

class SlugGenerator
{
    public static function generateSlug(string $title): string
    {
        $slug = mb_strtolower(trim($title)); // Convertit le titre en minuscules et supprime les espaces inutiles
        $slug = preg_replace('/[^a-z0-9]+/', '_', $slug); // Remplace les caractères spéciaux et les espaces par des tirets
        $slug = trim($slug, '_'); // Supprime les tirets en début et fin de chaîne
        $slug = preg_replace('/_+/', '_', $slug); // Supprime les tirets consécutifs

        return $slug;
    }
}