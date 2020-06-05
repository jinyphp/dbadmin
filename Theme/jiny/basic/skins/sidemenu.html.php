<h1 class="my-4">DBAdmin</h1>
<div class="list-group">
    <?php
        foreach($menu as $value) {
            echo "<a href='/tables' class='list-group-item'>".$value."</a>";
        }        
    ?>
</div>