<?php

/**
 * Отвечает за управление файловой системы
 * 
 * 02.11.2017
 * Сироткин Ф.А.
 */
class Controller {

    const INDEX_PHP    = 'index.php';
    const ROOT_TXT     = 'root.txt';
    const NAME_TXT     = 'name.txt';
    const CATEGORIES   = 'categories';
    const CONTENT_HTML = 'content.html';
    const IMAGE_JPG    = 'logo.jpg';
    
    private $rootLvl;     // Путь к корню CMS
    private $tplPath;     // Путь к шаблону
    private $tplFold;     // Каталог шаблона
    private $tplName;     // Имя шаблона
    private $dirName;     // Имя текущей директории
    private $image;       // Изображение для текущей категории
    private $content;     // Содержимое текущей директории
    private $tplFoldPath; // Путь к каталогу с шаблоном
    private $menu;        // Навигационные меню в виде массива
    
    function __construct($levels) {
        $this->rootLvl = $levels;
        $this->tplPath = 'templates';
        $this->tplFold = 'default';
        $this->tplName = $this->tplFold . '.tpl';
        if (is_file(self::NAME_TXT)) {
            $this->dirName = file_get_contents(self::NAME_TXT);
        }
        if (is_file(self::IMAGE_JPG)) {
            $this->image   = self::IMAGE_JPG;
        }
        if (is_file(self::CONTENT_HTML)) {
            $this->content = file_get_contents(self::CONTENT_HTML);
        }
        $this->menu = array();
    }

    // Формирование навигационных меню
    private function create_menu() {

        // Вниз каталогов на один уровень
        $catalogs = scandir('.');
        foreach ($catalogs as $catalog) {
            if ($catalog !== '.' && $catalog !== '..' && is_dir('./' . $catalog) && is_file('./' . $catalog . '/' . self::INDEX_PHP) && is_file('./' . $catalog . '/' . self::NAME_TXT)) {
                $this->menu['down'][] = array(
                    'name' => file_get_contents('./' . $catalog . '/' . self::NAME_TXT),
                    'link' => $catalog
                );
            }
        }

        // Формирование главного горизонтального меню
        $mainMenu = array();
        $levels = '';
        while (!is_file($levels . self::ROOT_TXT)) {
            $levels .= '../';
        }
        $mainMenu = scandir($levels . self::CATEGORIES);
        if ($levels === '' || $levels === '../') {
            $levels .= self::CATEGORIES . '/';
        }
        $levels = preg_replace('~\.\./$~', '', $levels);
        foreach ($mainMenu as $item) {
            if ($item !== '.' && $item !== '..' && $item !== self::INDEX_PHP && $item !== self::NAME_TXT && is_dir($levels) && is_file($levels . $item . '/' . self::INDEX_PHP) && is_file($levels . $item . '/' . self::NAME_TXT)) {
                $this->menu['main'][] = array(
                    'name' => file_get_contents($levels . $item . '/' . self::NAME_TXT),
                    'link' => $levels . $item
                );
            }
        }

        // Вверх по каталогам до главной
        $breadcrumbs = array();
        $levels = '';
        while (!is_file($levels . self::ROOT_TXT)) {
            $levels .= '../';
            if (is_dir($levels) && is_file($levels . self::INDEX_PHP) && is_file($levels . self::NAME_TXT)) {
                $breadcrumbs[] = array(
                    'name' => file_get_contents($levels . self::NAME_TXT),
                    'link' => $levels
                );
            }
        }
        $this->menu['up'] = array_reverse($breadcrumbs);
        $this->menu['up'][] = array(
            'name' => file_get_contents(self::NAME_TXT),
            'link' => ''
        );
    }

    // Вставка шаблона
    private function inc_tpl() {
        $this->tplFoldPath = $this->rootLvl . $this->tplPath . '/' . $this->tplFold . '/';
        include_once $this->tplFoldPath . $this->tplName;
    }

    // Построение содержимого страницы
    public function build() {
        $this->create_menu();
        $this->inc_tpl();
    }

}
