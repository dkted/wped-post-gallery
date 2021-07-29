

<div class="event-metabox">

    <table style="width: 100%;" border="1">
        <colgroup>
            <col style="width: 20%;">
            <col style="width: 80%;">
        </colgroup>
        <tbody>
            <tr>
                <td><label for='<?php echo $metaboxID?>_title'>Title</label></td>
                <td>
                    <div style="display: flex;">
                            <input style="flex-grow: 2; margin: auto;" type='text' 
                                    name='<?php echo $metaboxID?>_title' 
                                    id='<?php echo $metaboxID?>_title' 
                                    value='<?php echo array_key_exists('title', $metaboxValue)? esc_attr($metaboxValue['title']):'';?>'>
                        <button class="btn-copy-post-title" style="max-width: 160px;">Copy Post Title</button>
                        <button class="btn-meta-title-clear" style="max-width: 100px;">Clear</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for='<?php echo $metaboxID?>_video_url'>Video URL</label></td>
                <td>
                    <input type='text' name='<?php echo $metaboxID?>_video_url' 
                            id='<?php echo $metaboxID?>_video_url' 
                            value='<?php echo array_key_exists('video_url', $metaboxValue)? esc_attr($metaboxValue['video_url']):'';?>'>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top;"><span>Images<span></td>
                <td>
                    <div class="metabox-images" data-metabox-id="<?php echo $metaboxID?>_images">
                        <?php foreach ($metaboxValue['images'] as $index => $image) { 
                            $thumbnail_url = wp_get_attachment_image_url($image, 'thumbnail', false);
                            ?>
                        <div class="image">
                            <input type="hidden" name="<?php echo $metaboxID?>_images[]" value="<?php echo $image?>" />
                            <img src="<?php echo $thumbnail_url?>" width="150" height="150" />
                            <span class="close dashicons-before dashicons-no-alt"></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div style="display:flex; flex-direction:end;">
                        <button id='btn-images-modal'>Add Images</button>
                        <button class="remove-all-metabox-images">Clear</button>
                        <button class="import-ids-show">Import IDs</button>
                    </div>

                    <div class="import-ids-modal">
                        <div>
                            <label for="import-ids-value">Import attachment IDs</label>
                            <pre>ex: ["1243","3211", "4332" ...]</pre>
                        </div>
                        <div>
                            <textarea name="import-ids" id="import-ids-value" cols="30" rows="10"></textarea>
                        </div>
                        <button class="import-ids-cancel">Cancel</button>
                        <button class="import-ids-submit" data-post-id="<?php echo $postID?>">Import</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>  
    
</div>



