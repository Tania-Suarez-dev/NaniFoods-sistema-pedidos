<?php
require_once("./header.php");
require_once("./footer.php");
function template($content)
{
?>
    <header>
        <?php showheader(); ?>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <?php showfooter(); ?>
    </footer>
<?php
}
?>