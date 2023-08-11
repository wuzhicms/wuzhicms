<ul>
    <?php
    foreach($layout_result as $layouts) {
    ?>
    <li>
        <div class="wztools-row">
            <?php
            foreach($layouts as $layout_r) {
                ?>
                <div class="wztools-col-xs-2">
                    <div class="wztools-li grid-stack-item" id="<?php echo $layout_r['custom_id'];?>">
                        <div class="grid-stack-item-content wztools-mk-imght " title="<?php echo $layout_r['custom_id'];?>">
                            <div class="wztools-mk-imght-l" style="background: url(<?php echo $layout_r['thumb'];?>) no-repeat center; background-size: contain"></div>
                        </div>
                        <div class="wztools-mk-name manhangyichu"><?php echo $layout_r['title'];?></div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </li>
    <?php }?>
</ul>