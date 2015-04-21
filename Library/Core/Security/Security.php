<?php

namespace Rave\Library\Core\Security;

use Rave\Config\Config;

/**
 * Classe contenant différentes méthodes liées à la sécurité
 */
class Security
{

    /**
     * Méthode de hash à utiliser avant une insertion
     * de mot de passe dans la base de données
     * @param string $data
     *  Chaine de caractères à crypter
     * @return string
     *  Résultat du hash
     */
    public static function hash($data)
    {
        return hash('whirlpool', $data . Config::getSeed(), false);
    }

    /**
     * Méthode permettant de nettoyer une chaine de caractères
     * afin d'éviter les failles XSS et autres
     * @param string $data
     *  Chaine de caractères à nettoyer
     * @return string
     *  Chaine de caractères nettoyée
     */
    public static function clean($data)
    {
        $trimmedData = trim($data);
        $escapedData = stripslashes($trimmedData);
        $cleanedData = htmlspecialchars($escapedData);
        return $cleanedData;
    }

    /**
     * Méthode vérifiant si la chaine de caractères passée
     * en paramètre est un email
     * @param string $email
     *  Chaine de caractère à vérifier
     * @return boolean
     *  Vrai si la chaine est un email
     */
    public static function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Méthode permettant de déplacer un fichier uploadé
     * @param string $fileName
     *  Nom du champ d'upload
     * @param array $extensions
     *  Liste des extensions acceptées
     * @return boolean/string
     *  Nom du fichier ou FALSE en cas d'erreur
     */
    public static function moveUploadedFile($fileName, $path, $extensions)
    {
        if (isset($_FILES[$fileName])) {
            $extension = strrchr($_FILES[$fileName]['name'], '.');

            if (in_array($extension, $extensions)) {
                $file = uniqid() . $extension;
                
                if (move_uploaded_file($_FILES[$fileName]['tmp_name'], ROOT . $path . '/' . $file) === false) {
                    return false;
                } else {
                    return $file;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
