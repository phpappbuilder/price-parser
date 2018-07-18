<ul>
    <?php foreach ($items as $key => $value) { ?>
        <li><a href="<?=$value['href']?>"><?=$value['title']?></a></li>
    <?php } ?>
</ul>
