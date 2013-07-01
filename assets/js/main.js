jQuery(function($){
	$('#header-widget .menu, .nav .menu').superfish({
		autoArrows: true,
		speed: 'fast', 
		delay: 0
	});	

	$('.mobile-menu').change(function () {
		var selected = $(this).find("option:selected");

		$('.mobile-menu-text').html(selected.text());
		window.location = selected.val();
	});

	/* Resizing video players on small screens
	================================================== */
	$(function() {
		var iframes = document.getElementsByTagName('iframe');
		
		for (var i = 0; i < iframes.length; i++) {
			var iframe = iframes[i];
			var players = /www.youtube.com|player.vimeo.com|youtube-nocookie.com|kickstarter.com/;
			if(iframe.src.search(players) !== -1) {
				var videoRatio = (iframe.height / iframe.width) * 100;
			
				iframe.style.position = 'absolute';
				iframe.style.top = '0';
				iframe.style.left = '0';
				iframe.width = '100%';
				iframe.height = '100%';
				
				var div = document.createElement('div');
				div.className = 'video-wrap';
				div.style.width = '100%';
				div.style.height = '80%';
				div.style.position = 'relative';
				div.style.paddingTop = videoRatio + '%';

				var div2 = document.createElement('div');
				div2.className = 'first-video';
				
				var parentNode = iframe.parentNode;
				parentNode.insertBefore(div, iframe);
				div.appendChild(iframe);

				if(i === 0) {
					var parentNode2 = div.parentNode;
					parentNode2.insertBefore(div2, div);
					div2.appendChild(div);
				}
				
			}
		}
	});
});