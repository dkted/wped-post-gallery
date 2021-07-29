
window.addEventListener("load", function() {
	'use strict';
	
	// images modal
	
	function addGalleryImage(imagesJson) {
		let frag = document.createDocumentFragment(), inputID, div, img, span,
			container = document.querySelector('.metabox-images'),
			childCount = document.querySelectorAll('.metabox-images .image').length;
		let metaboxID = container.getAttribute('data-metabox-id');

		imagesJson.forEach(function(ob) {
			let index = childCount++;

			inputID = document.createElement('input');
			inputID.type = 'hidden';
			inputID.name = metaboxID +'[]';
			inputID.value = ob.id;
	
			div = document.createElement('div');
			div.classList.add('image');

			img = document.createElement('img');
			['thumbnail','medium','full','large'].forEach(function(size) {
				if (ob.sizes.hasOwnProperty(size)) {
					img.src = ob.sizes[size].url;
				}
			});
			

			span = document.createElement('span');
			span.classList.add('close', 'dashicons-before', 'dashicons-no-alt');

			div.appendChild(inputID);
			div.appendChild(img);
			div.appendChild(span);
			frag.appendChild(div);
		});
		container.appendChild(frag);
	}
	
	function btnImagesModalClickListener(e) {
		e.preventDefault();

		let file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select images',
			button: {
				text: 'Select images'
			},
			multiple: true
		});

		file_frame.on('select', function() {
			let images = file_frame.state().get('selection').toJSON();
			addGalleryImage(images);
		});

		file_frame.open();
	};

	let btnImagesModal = document.querySelector('#btn-images-modal');
	if (!!btnImagesModal) btnImagesModal.addEventListener('click', btnImagesModalClickListener);

	let metaboxImages = document.querySelector('.metabox-images');
	
	if (!!metaboxImages) metaboxImages.addEventListener('click', function(e) {
		if (e.target.classList.contains('close')) {
			e.preventDefault();
			e.target.parentNode.parentNode.removeChild(e.target.parentNode);
		}
	}, true);
	

	let btnCopyPostTitle = document.querySelector('.btn-copy-post-title');
	if (!!btnCopyPostTitle) {
		btnCopyPostTitle.addEventListener('click', function() {
			let val = document.querySelector('.editor-post-title__input').value;
			let inputMetaTitle = document.querySelector('#wpedpg_metabox_id_title');
			if (inputMetaTitle) {
				inputMetaTitle.value = val;
			}
		});
	}

	let btnRemoveAllImages = document.querySelector('.remove-all-metabox-images');
	if (!!btnRemoveAllImages) {
		btnRemoveAllImages.addEventListener('click', function() {
			let child = metaboxImages.lastElementChild;
			while (child) {
				metaboxImages.removeChild(child);
				child = metaboxImages.lastElementChild;
			}
		});
	}

	let btnImportIdsShow = document.querySelector('.import-ids-show');
	if (!!btnImportIdsShow) {
		btnImportIdsShow.addEventListener('click', function(e) {
			e.preventDefault();
			document.querySelector('.import-ids-modal').classList.add('show');
		});
	}


	// Import Modal
	let btnImportIdsCancel = document.querySelector('.import-ids-cancel'),
		btnImportIdsSubmit = document.querySelector('.import-ids-submit');

	if (!!btnImportIdsCancel) {
		btnImportIdsCancel.addEventListener('click', function(e) {
			e.preventDefault();
			document.querySelector('.import-ids-modal').classList.remove('show');
		});
	}
	if (!!btnImportIdsSubmit) {
		btnImportIdsSubmit.addEventListener('click', function(e) {
			e.preventDefault();
			let textarea = document.querySelector('#import-ids-value'),
				postID = btnImportIdsSubmit.getAttribute('data-post-id');

			let ids = JSON.parse(textarea.value),
				data = {
					postID: postID,
					ids: ids 
				};

			let ajax = {
				type: "POST",
				url: "/wp-admin/admin-ajax.php",
				data: 'action=wpedpg_gallery&data='+ JSON.stringify(data),
				success: function(msg) {
					console.log(msg)
					window.location.reload();
				}
			};
			
			jQuery.ajax(ajax);			
		});
	}

});