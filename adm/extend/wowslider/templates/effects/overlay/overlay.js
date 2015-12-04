(function($){
	window.ws_overlay = function(options){
		options.duration = options.duration || 250;
		
		var Elements = [];
		var curIdx = 0;
		
		this.init = function($ps_container){
			$ps_container = $($ps_container);
			
			// init Elements
			$('A', $ps_container).each(function(){
				Elements[Elements.length] = this;
			});
			
			/*
			* when we click on an album,
			* we load with AJAX the list of pictures for that album.
			* we randomly rotate them except the last one, which is
			* the one the User sees first. We also resize and center each image.
			*/

			
			var images = $("img", $ps_container);
			var cnt = 0;
			images.each(function(index){
			
				var $image = $(this);
				++cnt;
				resizeCenterImage($image);
				$ps_container.append($image.parent());
				var r		= Math.floor(Math.random()*41)-20;
				if(cnt < images.length){
					$image.css({
						'-moz-transform'	:'rotate('+r+'deg)',
						'-webkit-transform'	:'rotate('+r+'deg)',
						'transform'			:'rotate('+r+'deg)'
					});
				}
				$image.css({
					//position:'absolute',
					top:'50%',
					left:'50%',
					'margin-top': -$image.outerHeight()/2 + 'px',
					'margin-left': -$image.outerWidth()/2 + 'px'
				})
				
			});
		};
		
		
		
		/**
		* navigate through the images: 
		* the last one (the visible one) becomes the first one.
		* we also rotate 0 degrees the new visible picture 
		*/
		this.go = function(index){
			// calc relative index
			var delta = index - curIdx; // = 1-C...C-1
			curIdx = index;
			// if -2 then get second = 1
			// if -1 then get first = 0
			// if +1 then get prev Last (Count-2)
			// if +2 -- get Count-3
//			if (delta < 0) index = 1-delta
//			else index = Elements.length - 1 - delta;
			index = Elements.length - 1 - delta // = 0..2C-2
			if (index >= Elements.length)
				index -= Elements.length;		// = 0..C-2

			$new_current = $(Elements[index]).find('img');
			if (!$new_current.length) return;
			
			// reorder Elements
			var tmp = null;
			if (index == Elements.length-2){
				tmp = Elements[Elements.length-1];
				for (var i=Elements.length-1; i>0; i--)
					Elements[i] = Elements[i-1];
				Elements[0] = tmp;
			}
			else if (index < Elements.length-2){
				for (var i=0; i<Elements.length; i++)
					if(i==index)
						tmp = Elements[i];
					else if(i>index)
						Elements[i-1] = Elements[i];
				Elements[Elements.length-1]=tmp;
			};
			
			
			// div#ps_container -> a -> img.$new_current
			var $ps_container = $new_current.parent().parent();
			var $current_img = $ps_container.find('img:last');
			if ($current_img.attr('src') == $new_current.attr('src')) return;

			// if after current then move current to back else move new_current to first
			var current2Back = $current_img.parent().prev().find('img').attr('src') == $new_current.attr('src'); 
			var $moved = (current2Back? $current_img: $new_current);

			var r		= Math.floor(Math.random()*41)-20;
			var currentPositions = {
				marginLeft	: $moved.css('margin-left'),
				marginTop	: $moved.css('margin-top')
			}
			
			
			if(current2Back)
				$new_current.css({
					'-moz-transform'	:'rotate(0deg)',
					'-webkit-transform'	:'rotate(0deg)',
					'transform'			:'rotate(0deg)'
				});
			
			
			$moved.animate({
				'marginLeft': $moved.width()/1.8  + 'px', //'250px',  	460
				'marginTop': -$moved.height()*1.3 + 'px' //'-385px'		305
				
			},options.duration/2,function(){
				if(current2Back){
					$moved.parent().insertBefore($ps_container.find('img:first').parent());
					
					$moved.css({
							'-moz-transform'	:'rotate('+r+'deg)',
							'-webkit-transform'	:'rotate('+r+'deg)',
							'transform'			:'rotate('+r+'deg)'
						})
					$moved.animate({
						'marginLeft':currentPositions.marginLeft,
						'marginTop'	:currentPositions.marginTop
						},options.duration/2
					);
						
				}else{
					$moved.parent().insertAfter($ps_container.find('img:last').parent());
						
					$new_current.css({
						'-moz-transform'	:'rotate(0deg)',
						'-webkit-transform'	:'rotate(0deg)',
						'transform'			:'rotate(0deg)'
					});			
					
					$moved.animate({
						'marginLeft':currentPositions.marginLeft,
						'marginTop'	:currentPositions.marginTop
						},250,function(){
							$current_img.css({
								'-moz-transform'	:'rotate('+r+'deg)',
								'-webkit-transform'	:'rotate('+r+'deg)',
								'transform'			:'rotate('+r+'deg)'
							});
						});
				}
			});
			
			return $new_current.parent();
		};
	
	
		/**
		* resize and center the images
		*/
		function resizeCenterImage($image){
			var theImage 	= new Image();
			theImage.src 	= $image.attr("src");
			var imgwidth 	= theImage.width;
			var imgheight 	= theImage.height;
			
			var containerwidth  = imgwidth;
			var containerheight = imgheight;
			
			if(imgwidth	> containerwidth){
				var newwidth = containerwidth;
				var ratio = imgwidth / containerwidth;
				var newheight = imgheight / ratio;
				if(newheight > containerheight){
					var newnewheight = containerheight;
					var newratio = newheight/containerheight;
					var newnewwidth =newwidth/newratio;
					theImage.width = newnewwidth;
					theImage.height= newnewheight;
				}
				else{
					theImage.width = newwidth;
					theImage.height= newheight;
				}
			}
			else if(imgheight > containerheight){
				var newheight = containerheight;
				var ratio = imgheight / containerheight;
				var newwidth = imgwidth / ratio;
				if(newwidth > containerwidth){
					var newnewwidth = containerwidth;
					var newratio = newwidth/containerwidth;
					var newnewheight =newheight/newratio;
					theImage.height = newnewheight;
					theImage.width= newnewwidth;
				}
				else{
					theImage.width = newwidth;
					theImage.height= newheight;
				}
			}
			$image.css({
				'width'			:theImage.width,
				'height'		:theImage.height,
				'margin-top'	:-(theImage.height/2)-10+'px',
				'margin-left'	:-(theImage.width/2)-10+'px'	
			});
		};
	}
})(jQuery);