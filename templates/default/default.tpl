<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->dirName ?> | MovieShow</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="<?= $this->tplFoldPath ?>css/main.css">
    </head>
    <body>
        <header>
            <a class="goUp" href="<?= $this->rootLvl ?>">Перейти на главную</a>
            <div class="navigation">
            <?php
                if (!empty($this->menu['main'])) {
                    echo '<ul>';
                    $count = count($this->menu['main']);
                    for ($i = 0; $i < $count; $i++) {
                        echo '<li><a href="' . $this->menu['main'][$i]['link'] . '">' . $this->menu['main'][$i]['name'] . '</a></li>';
                    }
                    echo '</ul>';
                }
				
            ?>
            </div>
            <h1>MovieShow. Найди своё кино</h1>
        </header>   
        <nav>
            <?php
                if (!empty($this->menu['up'])) {
                    $count = count($this->menu['up']);
                    for ($i = 0; $i < $count; $i++) {
                        echo '<a href="' . $this->menu['up'][$i]['link'] . '">' . $this->menu['up'][$i]['name'] . '</a>';
                        if ($count > 1 && $i + 1 !== $count) {
                            echo '<span class="separator">/</span>';
                        }
                    }
                }
            ?>
        </nav>
        <div id="content">
            <aside>
                <p><b>Перейти в категорию:</b></p>
                <?php
                    echo '<ul>';
                    if (!empty($this->menu['down'])) {
                        foreach ($this->menu['down'] as $element) {
                            echo '<li>– <a href="' . $element['link'] . '">' . $element['name'] . '</a></li>';
                        }
                    } else {
                        echo '<li>– <a href="../">Перейти назад</a></li>';
                    }
                    echo '</ul>';
                ?>
            </aside>   
            <article>
                <h3><?= $this->dirName ?></h3>
                <?= !empty($this->image) ? '<div class="logo"><img src="' . $this->image . '"></div>' : ''; ?>
                <?= $this->content ?>
            </article>
        </div>
        <footer>
            © <?= date('Y'); ?> «MovieShow»
        </footer>   
    </body>   
</html>