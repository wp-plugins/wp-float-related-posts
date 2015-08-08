var relatedposts = (function(){
	var rp = document.querySelectorAll('.rp');
	var hidePopup = function() {
		for( var i=0; i<rp.length; i++)
		{
			rp[i].classList.add('hide');
		}		
	};
	var showPopup = function() {
		for( var i=0; i<rp.length; i++)
		{
			rp[i].classList.remove('hide');
		}
	};
	var timeout = function(ms) {
		setTimeout(function(){
			showPopup();
		},ms);		
	};
	var scrolldown = function( scrollpercent ) {
		var docheight = document.body.clientHeight-window.innerHeight;
		var isShowedPopup = false;
		window.onscroll = function(e) {
			var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
			if( isShowedPopup === false && scrollTop >= (docheight*(scrollpercent/100) ) )
			{
				showPopup();
				isShowedPopup = true;
			}
		};
	};
	var module = {};
	module.run = function( config ) {
		config = config || {};
		mode = config.mode || 'timeout';
		timeoutms = config.timeoutms || 7000;
		scrollpercent = config.scrollpercent>=10&&config.scrollpercent<=100 ? config.scrollpercent : 80;
		var closebtn = document.querySelector('.rp-close');
		if( closebtn !== null )
		{
			closebtn.addEventListener('click',function(){
				hidePopup();
			},false);
		}
		switch( mode )
		{
			case 'scrolldown':
				scrolldown( scrollpercent );
			break;
			default:
				timeout( timeoutms );
			break;
		}
	};
	return module;
})();
relatedposts.run( rpconfig );