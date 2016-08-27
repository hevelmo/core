/*! loadJS: load a JS file asynchronously. [c]2014 @scottjehl, Filament Group, Inc. (Based on http://goo.gl/REQGQ by Paul Irish). Licensed MIT */
	function loadJS(src,cb){"use strict";var ref=window.document.getElementsByTagName("script")[0];var script=window.document.createElement("script");script.src=src;script.async=true;script.defer=true;ref.parentNode.insertBefore(script,ref);if(cb&&typeof(cb)==="function"){if(typeof script.onload==='undefined'){script.onreadystatechange=function(){if(this.readyState==='loaded'||this.readyState==='complete'){cb();}};}else{script.onload=cb;}} return script;};

	loadJS( "../lib/site/herocarousel/herocarousel.app.js", function(){
  		site.init();
	});