/*  
	-------------------------------------------------------------
	Cascade Style Sheet - jQuery Timeline slider
	Description: jQuery Plugin for building web timelines
	Author: pezflash - http: //www.codecanyon.net/user/pezflash
	Version: 1.0
	-------------------------------------------------------------
*/ 


// JQUERY DOCUMENT READY
// using "jQuery" here to protect against conflicts
// with other libraries like MooTools
jQuery(document).ready(function() {
	jQuery.myTimeline();
});


(function($) {
	
	// GLOBAL VARS
	var preload, container, tl, vidRoll, imgRoll, readBt, viewport, images, milestones, content, bar, track, dragger, marksAmount, fadeInDelay;
	
	
	// CLASS CONSTRUCTOR / INIT FUNCTION
	$.myTimeline = function() {
		
		
		//SETUP VARS
		preload = $('.preload');
		container = $('#timeline_container');
		tl = $('#timeline');
		vidRoll = $('.video_rollover');
		imgRoll = $('.image_rollover');
		readBt = $('.readmore');
		viewport = $('#timeline .viewport');
		images = $('#timeline .viewport .images');
		milestones = $('#timeline .milestones');
		content = $('#timeline .milestones .content');
		bar = $('#timeline .scrollbar');
		track = $('#timeline .scrollbar .track');
		dragger = $('#timeline .scrollbar .track .dragger');
		marksAmount = $('.marks > div').length;
		fadeInDelay = parseInt(tl.attr("data-fadeInDelay"));
		
		
		//CONFIG ALL ELEMENTS SIZES AND POSITIONS BASED ON HTML ATTRIBS
		container.css("width", tl.attr("data-width"));
		container.css("height", tl.attr("data-height"));
		images.css("width", tl.attr("data-imagesWidth"));
		viewport.css("height", tl.attr("data-imagesHeight"));
		content.css("width", tl.attr("data-contentWidth"));
		milestones.css("height", tl.attr("data-contentHeight"));
		bar.css("top", tl.attr("data-imagesHeight") - tl.attr("data-draggerHeight"));
		track.css("height", tl.attr("data-draggerHeight"));
		dragger.css("height", tl.attr("data-draggerHeight"));

		
		//PRELOAD & GLOBAL FADE IN
		preload.delay(fadeInDelay - 500).animate({ opacity:0 }, 500, 'easeOutQuad');
		container.delay(fadeInDelay).animate({ opacity:1 }, 1000, 'easeOutQuad');

		/*
		//HTML5 AUDIO PLAYER 
		audiojs.events.ready(function() {
			var as = audiojs.createAll({
				autoplay: true,
				loop: true,
			});
			audio.prettyPaused = 0;
		});
		*/
		
		//PRETTYPHOTO LIGHTBOX GALLERY
		$('a[data-rel]').each(function() {
			$(this).attr('rel', $(this).data('rel'));
		});
		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
		
		
		//TIPSY - TOOLTIP
		readBt.tipsy({ gravity: 'w', fade: true, offset: 5 });
		
		
		//IMAGE ROLLOVER ICON
		imgRoll.append("<span></span>");
		imgRoll.hover(function(){
			$(this).children("span").stop(true, true).fadeIn(600);
		},function(){
			$(this).children("span").stop(true, true).fadeOut(200);
		});
		
		
		//VIDEO ROLLOVER ICON
		vidRoll.append("<span></span>");
		vidRoll.hover(function(){
			$(this).children("span").stop(true, true).fadeIn(600);
		},function(){
			$(this).children("span").stop(true, true).fadeOut(200);
		});
		
		
		//VIDEO THUMB STOPS MUSIC ON CLICK (IF PLAYING)
		vidRoll.click(function() {
			if (audio.playing) {
				audio.prettyPaused = 1;
				audio.pause();
			} else {
				audio.prettyPaused = 0;
			}
		});
		
		
		//START DRAG IMAGES FUNCTION
		startDrag(images);
		
		
		//SCROLLBAR MILESTONES MARKS
		for ( var i = 0; i < marksAmount; i++ ) {
			current = $('#m'+i);
			current.stop(true, true)
				.delay(fadeInDelay + 500)
				.animate({ left:current.attr("data-xpos"), opacity:1 }, 700 + 100*i, 'easeOutQuad')
				.show()
				.tipsy({ gravity: 's', fade: true, offset: 3, fallback: current.attr("data-label") });
		};
		
		
		//INIT SCROLLBAR
		tl.tinyscrollbar({
			wheel: 20,
			mouseWheel: tl.attr("data-mouseWheel"),
			size: tl.attr("data-width"),
			draggerWidth: tl.attr("data-draggerWidth")
		});
		
		
	} // END OF CLASS CONSTRUCTOR
	
	

	//DRAG FUNCTION
	function startDrag(i) {
		var leftLimit = 0;

		i.draggable({
			axis: "x",
				
			start: function(event, ui) {
				if (ui.position != undefined) {
					leftLimit = ui.position.left;
				}
			},
			
			drag: function(event, ui) {
				leftLimit = ui.position.left;
				var rightLimit = i.width() - container.width();							
				if (ui.position.left < 0 && ui.position.left * -1 > rightLimit) leftLimit = rightLimit * -1;
				if (ui.position.left > 0) leftLimit = 0;
				ui.position.left = leftLimit;
					
				content.css("left", leftLimit * ratio);				//MOVE CONTENT
				dragger.css("left", leftLimit * -ratioDragger);		//MOVE DRAGGER
				
				iScroll = -leftLimit;								//VALUE FOR MOUSE WHEEL -tinyscroll.js
				iScroll2 = -(content.position().left);				//VALUE FOR MOUSE WHEEL -tinyscroll.js
			}
		});

		i.addClass("drag_icon");
	};

	//STOP DRAG FUNCTION
	function stopDrag(i) {
		i.draggable("destroy");
		i.css("cursor", "default");
	};

	
})(jQuery);


