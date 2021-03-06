<?php

namespace Rave\Library\Core\Security;

use Rave\Core\Exception\FileTypeException;
use Rave\Core\Exception\IOException;
use Rave\Core\Exception\UploadException;

/**
 * Classe contenant différentes méthodes
 * liées à la sécurité des fichiers
 */
class File
{

    /**
     * Méthode retournant le checksum d'un fichier
     *
     * @param $filePath
     * @return string
     */
    public static function checkSum($filePath)
    {
        return file_exists(ROOT . '/' . $filePath) ? hash('sha1', file_get_contents(ROOT . '/' . $filePath)) : null;
    }

    /**
     * Méthode permettant de déplacer un fichier uploadé
     *
     * @param string $fileName
     *  Nom du champ d'upload
     * @param string $uploadPath
     *  Chemin relatif vers lequel le fichier doit être déplacé
     * @param array  $extensions
     *  Liste des extensions acceptées
     * @param array  $mimeTypes
     *  Liste des types MIME acceptés
     * @return string
     *  Nom du fichier
     * @throws IOException,
     * @throws UploadException,
     * @throws FileTypeException;
     *  Lève une exception en fonction de l'erreur rencontrée
     */
    public static function moveUploadedFile($fileName, $uploadPath, array $extensions = [], array $mimeTypes = [])
    {
        if (isset($_FILES[$fileName]) === false) {
            throw new UploadException('Can not find uploaded file in superglobale FILES');
        }

        $fileExtension = strrchr($_FILES[$fileName]['name'], '.');

        if (empty($extensions) === false && in_array($fileExtension, $extensions) === false) {
            throw new FileTypeException('Wrong file extension');
        }

        $uploadedFileName = uniqid() . $fileExtension;
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

        if (empty($mimeTypes) === false && in_array(finfo_file($fileInfo, $_FILES[$fileName]['tmp_name']),
                $mimeTypes) === false
        ) {
            throw new FileTypeException('Wrong MIME type');
        }

        finfo_close($fileInfo);

        if (move_uploaded_file($_FILES[$fileName]['tmp_name'],
                ROOT . '/' . $uploadPath . '/' . $uploadedFileName) === false
        ) {
            throw new IOException('Failed to move the uploaded file');
        }

        return $uploadedFileName;
    }

}