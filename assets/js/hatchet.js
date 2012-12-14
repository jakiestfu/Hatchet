$(document).ready(function(){
	
	function loadData(feedName, doFlashTitle){
		
		var doPushState=false;
		if(typeof feedName != 'undefined'){
			feed = feedName;
			doPushState=true;
		}
		var hacker_data = localStorage.getItem('hacker_news_'+feed);
		
		if(!hacker_data){
			$.ajax({
				url: home_url+'/includes/hacker.php?feed='+feed,
				type: 'GET',
				dataType: 'html',
				success: function(data){
					localStorage.setItem('hacker_news_'+feed, data);
					if(doPushState){
						history.pushState({}, '', '?feed='+feed);
					}
					if(doFlashTitle){
						flashTitle(feed, 100);
					}
					parseData(data);
				}
			});
		} else {
			if(doPushState){
				history.pushState({}, '', '?feed='+feed);
			}
			if(doFlashTitle){
				flashTitle(feed, 100);
			}
			parseData(hacker_data);
		}
	}
	
	// Parse Data
	function parseData(hacker_data){
		var _hackerData = $(hacker_data).find('.subtext').closest('table').find('tr'),
			_list = $('.content .list'),
			i, 
			length = _hackerData.length;

		for(i=0; i<length; i+=3){
			var fRow = $(_hackerData[i]),
				sRow = $(_hackerData[i+1]),
				data = {
					rank: fRow.find('.title:first-child').text(),
					title: fRow.find('.title:last-child a').text(),
					href: fRow.find('.title:last-child a').attr('href'),
					comhead: $.trim(fRow.find('.comhead').text())
				},
				subText = sRow.find('.subtext'),
				comments = subText.find('a:last-child');
				
				if(comments.attr('href')){
					comments.attr('href',  (comments.attr('href')).replace('item', 'comments.php') );
				}
				
			data.subTextHTML = (subText.html() ? $.trim((subText.html()).replace(' | '," <br /><br /> ")) : false);
			data.commentCount = parseInt((comments.text()).replace(' comments', ''), 10);
			
			data.commentCount = (""+data.commentCount=="NaN") ? '0' : data.commentCount;
			
			if(data.subTextHTML){
				_list.append('<li><a href="'+home_url+'single.php?url='+btoa(data.href)+'" data-transition="fade" class="anchor"><span class="rank">'+data.rank+'</span> '+data.title+' <span class="comhead">'+data.comhead+'</span> <span class="chevron"></span></a><div class="meta">'+data.subTextHTML+'</div></li>');
			}
		}
	}
	
	// Flash new Titles
	function flashTitle(newText, timeoutDelay){
		if(typeof newText != 'undefined'){
			$('.title-feed').html(newText);
		}
		if(typeof timeoutDelay == 'undefined'){
			timeoutDelay = 1000;
		}
		var _barTitle = $('.bar-title');
		setTimeout(function(){
			_barTitle.addClass('toggle-sub');
			setTimeout(function(){
				_barTitle.removeClass('toggle-sub');
			}, 3000);
		}, timeoutDelay);
	}
	
	// Reload Button
	$(document).on('click', '#reload', function(e){
		e.preventDefault();
		localStorage.removeItem('hacker_news_'+feed);
		this.style.opacity='0.5';
		this.innerHTML = 'Loading';
		window.location.reload();
	});
	
	// New List Highlight
	$(document).on('click', 'a.anchor', function(e){
		$('.list li.active').removeClass('active');
		$(this).parent().addClass('active');
	});
	
	// Change Feed
	$(document).on('click', '.popover .anchor', function(e){
		e.preventDefault();
		var feed = this.dataset.feed,
			_popover = $('.popover'),
			_bd = $('.backdrop');
			
		$('.content .list').html('');
		loadData(feed, true);
		
		_popover.on('webkitTransitionEnd', function(){
			this.style.display="none";
		});
		_popover.removeClass('visible');
		
		_bd.on('webkitTransitionEnd', function(){
			$(this).remove();
			_popover.off('webkitTransitionEnd');
		});
		_bd.css('opacity', 0);
	});
	
	// Home Page
	if(document.body.dataset && document.body.dataset.home){
		
		// Flash Feed
		flashTitle(undefined, 1000);
		
		// Load Data
		loadData(undefined, false);
	}
	
	
	
});
