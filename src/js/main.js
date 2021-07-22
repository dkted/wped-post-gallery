
window.addEventListener("load", function() {
	
	// images modal
	
	function addGalleryImage(imagesJson) {
		let frag = document.createDocumentFragment(), inputID, inputURL, div, img, span,
			container = document.querySelector('.metabox-images'),
			childCount = document.querySelectorAll('.metabox-images .image').length;
		let metaboxID = container.getAttribute('data-metabox-id');

		imagesJson.forEach(function(ob) {
			let index = childCount++;

			inputID = document.createElement('input');
			inputID.type = 'hidden';
			inputID.name = metaboxID +'['+ index +'][id]';
			inputID.value = ob.id;

			inputURL = document.createElement('input');
			inputURL.type = 'hidden';
			inputURL.name = metaboxID +'['+ index +'][url]';

			['large','medium','full','thumbnail'].forEach(function(size) {
				if (ob.sizes.hasOwnProperty(size)) {
					inputURL.value = ob.sizes[size].url;
				}
			});

			div = document.createElement('div');
			div.classList.add('image');

			img = document.createElement('img');
			img.src = ob.sizes.thumbnail.url;
			img.width = ob.sizes.thumbnail.width;
			img.height = ob.sizes.thumbnail.height;

			span = document.createElement('span');
			span.classList.add('close', 'dashicons-before', 'dashicons-no-alt');

			div.appendChild(inputID);
			div.appendChild(inputURL);
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
	if (btnImagesModal) btnImagesModal.addEventListener('click', btnImagesModalClickListener);

	document.querySelectorAll('.metabox-images .image').forEach(function(elm) {
		elm.addEventListener('click', function(e) {
			e.preventDefault();
			if (e.target.classList.contains('close')) {
				e.currentTarget.parentNode.removeChild(e.currentTarget);
			}
		});
	});

});