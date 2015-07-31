<?php

namespace Rave\Core;

use Rave\Core\Exception\IOException;

/**
 * Super classe abstraite Controller, doit être héritée par
 * tous les controleurs
 */
abstract class Controller
{
    /**
     * Constantes représentants le niveau
     * d'importance d'un log
     *
     * @var int
     *    Code de niveau d'importance du log
     */
    const LOG_NOTICE = 0;
    const LOG_WARNING = 1;
    const LOG_FATAL_ERROR = 2;
    /**
     * Attribut statique contenant le nom
     * du fichier de log courrant
     *
     * @var string
     *    Nom du fichier de log
     */
    private static $currentLogFile;
    /**
     * Données à passer à la vue
     * par défaut
     *
     * @var array
     *  Tableau des données
     */
    protected $data = [];
    /**
     * Nom de la vue chargée en tant que layout
     *
     * @var string/boolean
     *  Nom de la vue, false si l'on ne souhaite pas de layout
     */
    protected $layout = false;

    /**
     * Méthode permettant de charger une vue
     * et/ou de lui transmettre des données
     *
     * @param string $view
     *  Nom de la vue
     * @param array  $data
     *  Données à transmettre à la vue
     */
    protected function loadView($view, array $data = [])
    {
        if (empty($data) === false || empty($this->data) === false) {
            extract(array_merge($this->data, $data));
        }

        $file = ROOT . '/Application/View/' . get_class($this) . '/' . $view . '.php';

        ob_start();

        if (file_exists($file)) {
            include_once $file;
        } else {
            Error::create('Erreur chargement vue', '404');
        }

        $content = ob_get_clean();

        if ($this->layout === false) {
            echo $content;
        } else {
            include_once ROOT . '/Application/View/Layout/' . $this->layout . '.php';
        }
    }

    /**
     * Méthode de redirection
     *
     * @param string $page
     *    Page vers laquelle l'utilisateur doit être redirigé
     */
    protected function redirect($page)
    {
        header('Location: ' . WEB_ROOT . $page);
    }

    /**
     * Méthode permettant d'écrire des logs
     *
     * @param string $message
     *    Message de log
     * @param int    $priority
     *    Priorité du log
     */
    protected function log($message, $priority = self::LOG_NOTICE)
    {
        $log = date('H:i:s');

        switch ($priority) {
            case self::LOG_NOTICE:
                $log .= ' : ' . $message;
                break;
            case self::LOG_WARNING:
                $log .= ' WARNING : ' . $message;
                break;
            case self::LOG_FATAL_ERROR:
                $log .= ' FATAL ERROR : ' . $message;
                break;
        }

        try {
            $this->writeLog($log);
        } catch (IOException $ioException) {
            Error::create($ioException->getMessage(), '500');
        }
    }

    /**
     * Méthode privée d'écriture du log
     *
     * @param string $message
     *    Message de log
     * @throws IOException
     *    Lance un exception d'entrée/sortie en cas d'erreur d'écriture
     */
    private function writeLog($message)
    {
        if (isset(self::$currentLogFile)) {
            file_put_contents(self::$currentLogFile, $message . PHP_EOL, FILE_APPEND);
        } else {
            if (file_exists(ROOT . '/Log') === false) {
                mkdir(ROOT . '/Log');
            }

            self::$currentLogFile = ROOT . '/Log/' . date('d-m-Y') . '.log';

            if (file_exists(self::$currentLogFile) === false && fopen(self::$currentLogFile, 'a') === false) {
                throw new IOException('Unable to create log file');
            }

            $this->writeLog($message);
        }
    }

    /**
     * Méthode permettant de modifier le layout
     *
     * @param string $layout
     *  Nom du layout, false si l'on ne souhaite
     *  pas en charger
     * @param array  $data
     *  Données à passer à la vue par défaut
     */
    protected function setLayout($layout, array $data = [])
    {
        $this->data = $data;
        $this->layout = file_exists(ROOT . '/Application/View/Layout/' . $layout . '.php') ? $layout : false;
    }

}