

<div class="event-metabox">
    <label for='<?php echo $metaboxID?>_title'>Title</label>

    <?php if (array_key_exists('title', $metaboxValue)):?>
        <input type='text' name='<?php echo $metaboxID?>_title' id='<?php echo $metaboxID?>_title' value='<?php echo esc_attr($metaboxValue['title'])?>'>
    <?php else:?>
        <input type='text' name='<?php echo $metaboxID?>_title' id='<?php echo $metaboxID?>_title' value=''>
    <?php ;endif;?>

    <button id='btn-images-modal'>Add Images</button>

    <div class="metabox-images" data-metabox-id="<?php echo $metaboxID?>_images">

        <?php foreach ($metaboxValue['images'] as $index => $image) { 
            $thumbnail_url = wp_get_attachment_image_url($image['id'], 'thumbnail', false);
            $full_url = wp_get_attachment_image_url($image['id'], 'full', false);
            ?>
        <div class="image">
            <input type="hidden" name="<?php echo $metaboxID?>_images[<?php echo $index?>][id]" value="<?php echo $image['id']?>" />
            <input type="hidden" name="<?php echo $metaboxID?>_images[<?php echo $index?>][url]" value="<?php echo $full_url?>" />
            <img src="<?php echo $thumbnail_url?>" width="150" height="150" />
            <span class="close dashicons-before dashicons-no-alt"></span>
        </div>
        <?php } ?>        

    </div>
</div>



