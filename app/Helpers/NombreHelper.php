<?php

namespace App\Helpers;
class NombreHelper{
   public static function convertirEnLettres($montant) {
    // Liste des unités et des dizaines
    $unit = array(
        0 => 'zéro', 1 => 'un', 2 => 'deux', 3 => 'trois', 4 => 'quatre', 5 => 'cinq', 6 => 'six', 7 => 'sept', 8 => 'huit', 9 => 'neuf',
        10 => 'dix', 11 => 'onze', 12 => 'douze', 13 => 'treize', 14 => 'quatorze', 15 => 'quinze', 16 => 'seize',
        17 => 'dix-sept', 18 => 'dix-huit', 19 => 'dix-neuf', 20 => 'vingt', 30 => 'trente', 40 => 'quarante',
        50 => 'cinquante', 60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingts', 90 => 'quatre-vingt-dix'
    );

    $tens = array(
        2 => 'vingt', 3 => 'trente', 4 => 'quarante', 5 => 'cinquante', 6 => 'soixante', 7 => 'soixante-dix',
        8 => 'quatre-vingts', 9 => 'quatre-vingt-dix'
    );

    // Liste des puissances de mille
    $powers = array('', 'mille', 'million', 'milliard', 'billion', 'trillion');

    // Formater le montant en deux décimales
    $montant = number_format($montant, 2, ',', '');
    list($entier, $decimal) = explode(',', $montant);



    // Convertir la partie entière (avant la virgule)
    $resultat = '';
    $groupCount = 0;

    while ($entier > 0) {
        $partie = $entier % 1000; // Prendre les 3 derniers chiffres
        if ($partie > 0) {
            $partieTexte = self::convertirMoinsDeMille($partie, $unit, $tens);
            if ($powers[$groupCount] != '') {
                $resultat = $partieTexte . ' ' . $powers[$groupCount] . ' ' . $resultat;
            } else {
                $resultat = $partieTexte . ' ' . $resultat;
            }
        }
        $entier = floor($entier / 1000); // Réduire le montant pour le prochain groupe
        $groupCount++;
    }

    // Partie décimale (centimes)
    if ($decimal > 0) {
        $resultat .= ' et ' . $decimal . ' centime';
        if ($decimal > 1) {
            $resultat .= 's';
        }
    }

    return ucfirst(trim($resultat)); // Première lettre en majuscule
}
    // Fonction pour convertir les parties entières (moins de 1000)
    static function convertirMoinsDeMille($number, $unit, $tens) {
        $resultat = '';

        if ($number >= 100) {
            $centaines = floor($number / 100);
            $resultat .= $unit[$centaines] . ' cent';
            $number %= 100;
        }

        if ($number >= 20) {
            $dizaines = floor($number / 10);
            $unites = $number % 10;
            $resultat .= ' ' . $tens[$dizaines];
            if ($unites) {
                $resultat .= '-' . $unit[$unites];
            }
        } elseif ($number > 0) {
            $resultat .= ' ' . $unit[$number];
        }

        return trim($resultat);
    }
}
