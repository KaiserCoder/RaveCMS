<?php

namespace Rave\Library\Core\Security;

use Rave\Config\Config;

use Rave\Core\Exception\IOException;
use Rave\Core\Exception\MIMEException;
use Rave\Core\Exception\UploadException;
use Rave\Core\Exception\ExtensionException;

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
        return hash('whirlpool', $data . Config::getDatabaseSeed(), false);
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
     * @param string $path
     *  Chemin relatif vers lequel le fichier doit être déplacé
     * @param array $extensions
     *  Liste des extensions acceptées
     * @param array $mimeTypes
     *  Liste des types MIME acceptés
     * @return string
     *  Nom du fichier
     * @throws IOException,
     * 		   MIMEException
     * 		   UploadException,
     * 		   ExtensionException
     * Lève une exception en fonction de l'erreur rencontrée
     */
    public static function moveUploadedFile($fileName, $path, array $extensions = [], array $mimeTypes = [])
    {
        if (isset($_FILES[$fileName])) {
            $extension = strrchr($_FILES[$fileName]['name'], '.');
            if (empty($extensions) || in_array($extension, $extensions)) {
                $file = uniqid() . $extension;
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
		if (empty($mimeTypes) || in_array(finfo_file($fileInfo, $_FILES[$fileName]['tmp_name']), $mimeTypes)) {
		    finfo_close($fileInfo);
	            if (move_uploaded_file($_FILES[$fileName]['tmp_name'], ROOT . $path . '/' . $file) === false) {
	                throw new IOException('Failed to move the uploaded file');
	            } else {
	                return $file;
	            }
		} else {
		    finfo_close($fileInfo);
		    throw new MIMEException('Wrong MIME type');
		}
            } else {
                throw new ExtensionException('Wrong file extension');
            }
        } else {
            throw new UploadException('Can not find uploaded file in superglobale FILES');
        }
    }

}
