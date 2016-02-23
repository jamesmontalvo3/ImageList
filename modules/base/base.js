// fixes image overlap in Chrome
// for some reason images from #image_list overlap in Chrome
// these images are resized by the browser because we have to pull in larger
// Imagery Online images and shrink them to size. The code below makes an
// initial assumption that the image will have a landscape orientation, and
// since the height is set by the #image_list template, it is possible
// to make a guess at the width. Once images are loaded this guess is removed
// and the images can take their correct shape.
$(document).ready(function(){
    $("img.image-list").each(function(i,e){
		var height = $(e).height();
		// console.log(height);
		var widthGuess = height * 1.5; // guess most images will be landscape
		$(e).css("width", widthGuess+'px');
	});

	$('#bodyContent').imagesLoaded(function(){
		$("img.image-list").each(function(i,e){
			$(e).css("width","auto");
		});
	});
});
