<?php

namespace Rave\Core;

/**
 * Super classe abstraite Controller, doit être héritée par
 * tous les controleurs
 */
abstract class Controller
{

    /**
     * Nom de la vue chargée en tant que layout
     * @var string/boolean
     *  Nom de la vue, false si l'on ne souhaite pas de layout
     */
    protected $_layout = false;

    /**
     * Méthode permettant de charger une vue
     * et/ou de lui transmettre des données
     * @param string $view
     *  Nom de la vue
     * @param array $data
     *  Données à transmettre à la vue
     */
    protected function loadView($view, array $data = [])
    {
        if (empty($data) === false) {
            extract($data);
        }

        $file = ROOT . '/Application/View/' . get_class($this) . '/' . $view . '.php';

        ob_start();
        
        if (file_exists($file)) {
            include_once $file;
        } else {
            Error::create('Erreur chargement vue', '404');
        }

        $content = ob_get_clean();

        if ($this->_layout === false) {
            echo $content;
        } else {
            include_once ROOT. '/Application/View/Layout/' . $this->_layout . '.php';
        }
    }

    /**
     * Méthode permettant de charger un model
     * ou un ensemble de models
     * @param string /array $modelClass
     *  Model(s) à charger
     */
    protected function loadModel($modelClass)
    {
        $this->loadFile(ROOT . '/Application/Model/', $modelClass, 'Erreur chargement model');
    }

    /**
     * Méthode permettant de charger un ou plusieurs fichiers
     * si il s'agit d'un tableau ou d'un array ou d'un string
     * @param string $basePath
     *  Chemin de base du/des fichier(s)
     * @param string /array $file
     *  Fichier(s) à charger
     * @param string $error
     *  Erreur à afficher
     */
    private function loadFile($basePath, $file, $error)
    {
        if (is_array($file)) {
            foreach ($file as $class)
            {
                $this->requireFile($basePath, $class, $error);
            }
        } else {
            $this->requireFile($basePath, $file, $error);
        }
    }

    /**
     * Méthode permettant d'inclure un fichier
     * @param string $basePath
     *  Répertoire dans lequel est le fichier
     * @param string /array $file
     *  Nom du/des fichiers
     * @param string $error
     *  Message d'erreur
     */
    private function requireFile($basePath, $file, $error)
    {
        $path = $basePath . $file . '.php';

        if (file_exists($path)) {
            require_once $path;
        } else {
            Error::create($error, '404');
        }
    }

    /**
     * Méthode permettant de charger une librairie
     * ou un ensemble de librairies
     * @param string /array $libraryClass
     *  Librairie(s) à charger
     */
    protected function loadLibrary($libraryClass)
    {
        $this->loadFile(ROOT . '/Library/', $libraryClass, 'Erreur chargement library');
    }

    /**
     * Méthode permettant de modifier le layout
     * @param string $layout
     *  Nom du layout, false si l'on ne souhaite
     *  pas en charger
     */
    protected function setLayout($layout)
    {
        $file = ROOT . '/Application/View/Layout/' . $layout . '.php';

        $this->_layout = file_exists($file) ? $layout : false;
    }

}
