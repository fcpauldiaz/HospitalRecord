!function(i){i.fn.initialize=function(t,e){var n=this,a=n.selector;if("function"!=typeof t||!a)return i(n);var s=i("body")[0];if(n.firstInitsCalled=n.firstInitsCalled||[],"function"==typeof e&&-1==n.firstInitsCalled.indexOf(e)&&(n.firstInitsCalled.push(e),e()),n.initData=n.initData||{},n.initData[a]=n.initData[a]||[],n.initData[a].push(t),i(this).each(function(){this.initsCalled=this.initsCalled||[],-1==this.initsCalled.indexOf(t)&&(this.initsCalled.push(t),i(this).each(t))}),!this.initializedObserver){this.initializedObserver=!0,window.MutationObserver=window.MutationObserver||window.WebKitMutationObserver;var d=new MutationObserver(function(t){i.each(t,function(t,e){var s=i();"attributes"==e.type&&(s=i(e.target)),"childList"==e.type&&e.addedNodes.length&&i.each(e.addedNodes,function(i,t){s=s.add(t)});for(a in n.initData){var d=n.initData[a],r=s.find(a);s.is(a)&&(r=r.add(s)),r.each(function(){var t=this;t.initsCalled=t.initsCalled||[],i.each(d,function(e,n){-1==t.initsCalled.indexOf(n)&&(t.initsCalled.push(n),i(t).each(n))})})}})}),r={attributes:!0,childList:!0,characterData:!1,subtree:!0};d.observe(s,r)}return i(this)}}(jQuery);