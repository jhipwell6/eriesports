/*! rgbHex - v1.1.2 - 2013-09-27 */window.rgbHex=function(){function a(a){return!isNaN(parseFloat(a))&&isFinite(a)}function b(a){return a.replace(/^\s+|\s+$/g,"")}function c(c){return c=b(c),a(c)&&c>=0&&255>=c}function d(a){return/^[0-9a-f]{3}$|^[0-9a-f]{6}$/i.test(b(a))}function e(a){return a=parseInt(a,10).toString(16),1===a.length?"0"+a:a}function f(a){return parseInt(a,16).toString()}function g(b){return b=b.split(","),(3===b.length||4===b.length)&&c(b[0])&&c(b[1])&&c(b[2])?4!==b.length||a(b[3])?"#"+e(b[0]).toUpperCase()+e(b[1]).toUpperCase()+e(b[2]).toUpperCase():null:null}function h(a){return d(a)?(3===a.length&&(a=a.charAt(0)+a.charAt(0)+a.charAt(1)+a.charAt(1)+a.charAt(2)+a.charAt(2)),"rgb("+f(a.substr(0,2))+","+f(a.substr(2,2))+","+f(a.substr(4,2))+")"):void 0}function i(a){return a.replace(/\s/g,"")}return function(a){if(!a)return null;var c=null,d=/^rgba?\((.*)\);?$/,e=/^#/;return a=b(a.toString()),"transparent"===a||"rgba(0,0,0,0)"===i(a)?"transparent":d.test(a)?g(a.match(d)[1]):e.test(a)?h(a.split("#").reverse()[0]):(c=a.split(","),1===c.length?h(a):3===c.length||4===c.length?g(a):void 0)}}(),jQuery&&jQuery.extend({rgbHex:function(a){return window.rgbHex(a)}});
/* colourBrightness.js by @jamiebrittain */!function(r){r.fn.colourBrightness=function(){function r(r){for(var t="";"html"!=r[0].tagName.toLowerCase()&&(t=r.css("background-color"),"rgba(0, 0, 0, 0)"==t||"transparent"==t);)r=r.parent();return t}var t,a,s,e,n=r(this);return n.match(/^rgb/)?(n=n.match(/rgba?\(([^)]+)\)/)[1],n=n.split(/ *, */).map(Number),t=n[0],a=n[1],s=n[2]):"#"==n[0]&&7==n.length?(t=parseInt(n.slice(1,3),16),a=parseInt(n.slice(3,5),16),s=parseInt(n.slice(5,7),16)):"#"==n[0]&&4==n.length&&(t=parseInt(n[1]+n[1],16),a=parseInt(n[2]+n[2],16),s=parseInt(n[3]+n[3],16)),e=(299*t+587*a+114*s)/1e3,125>e?this.removeClass("light").addClass("dark"):this.removeClass("dark").addClass("light"),this}}(jQuery);
(function(c){'function'==typeof define&&define.amd?define([],c):'object'==typeof exports?module.exports=c():window.wNumb=c()})(function(){'use strict';function c(p){return p.split('').reverse().join('')}function d(p,q){return p.substring(0,q.length)===q}function e(p,q){return p.slice(-1*q.length)===q}function f(p,q,r){if((p[q]||p[r])&&p[q]===p[r])throw new Error(q)}function g(p){return'number'==typeof p&&isFinite(p)}function h(p,q){return p=p.toString().split('e'),p=Math.round(+(p[0]+'e'+(p[1]?+p[1]+q:q))),p=p.toString().split('e'),(+(p[0]+'e'+(p[1]?+p[1]-q:-q))).toFixed(q)}function j(p,q,r,s,t,u,v,w,x,y,z,A){var C,D,E,B=A,G='',H='';return(u&&(A=u(A)),!!g(A))&&(!1!==p&&0===parseFloat(A.toFixed(p))&&(A=0),0>A&&(C=!0,A=Math.abs(A)),!1!==p&&(A=h(A,p)),A=A.toString(),-1===A.indexOf('.')?E=A:(D=A.split('.'),E=D[0],r&&(G=r+D[1])),q&&(E=c(E).match(/.{1,3}/g),E=c(E.join(c(q)))),C&&w&&(H+=w),s&&(H+=s),C&&x&&(H+=x),H+=E,H+=G,t&&(H+=t),y&&(H=y(H,B)),H)}function k(p,q,r,s,t,u,v,w,x,y,z,A){var C,D='';return(z&&(A=z(A)),A&&'string'==typeof A)&&(w&&d(A,w)&&(A=A.replace(w,''),C=!0),s&&d(A,s)&&(A=A.replace(s,'')),x&&d(A,x)&&(A=A.replace(x,''),C=!0),t&&e(A,t)&&(A=A.slice(0,-1*t.length)),q&&(A=A.split(q).join('')),r&&(A=A.replace(r,'.')),C&&(D+='-'),D+=A,D=D.replace(/[^0-9\.\-.]/g,''),''!=D)&&(D=+D,v&&(D=v(D)),!!g(D)&&D)}function l(p){var q,r,s,t={};for(void 0===p.suffix&&(p.suffix=p.postfix),q=0;q<o.length;q+=1)if(r=o[q],s=p[r],void 0==s)t[r]='negative'!==r||t.negativeBefore?'mark'===r&&'.'!==t.thousand&&'.':'-';else if('decimals'===r){if(0<=s&&8>s)t[r]=s;else throw new Error(r);}else if('encoder'===r||'decoder'===r||'edit'===r||'undo'===r){if('function'==typeof s)t[r]=s;else throw new Error(r);}else if('string'==typeof s)t[r]=s;else throw new Error(r);return f(t,'mark','thousand'),f(t,'prefix','negative'),f(t,'prefix','negativeBefore'),t}function m(p,q,r){var s,t=[];for(s=0;s<o.length;s+=1)t.push(p[o[s]]);return t.push(r),q.apply('',t)}function n(p){return this instanceof n?void('object'!=typeof p||(p=l(p),this.to=function(q){return m(p,j,q)},this.from=function(q){return m(p,k,q)})):new n(p)}var o=['decimals','thousand','mark','prefix','suffix','encoder','decoder','negativeBefore','negative','edit','undo'];return n});


(function($){
	$('.fl-page-content .fl-builder-content>.fl-row>.fl-row-content-wrap').each( function() {
		$(this).colourBrightness();
	});
	if ( isTouchDevice() === false ) {
		$('[data-toggle="tooltip"]').tooltip();
	}
	logoInit();
	scrollInit();
	donationInit();
	$(window).scroll(function(){
		logoInit();
	});
	labelInit();
	$('.checkbox-inline input, .radio-inline input').on('change', function(){labelInit();});
	if ( $('.gform_fields select').length > 0 ) {
		$('.gform_fields select').select2({
			minimumResultsForSearch: Infinity
		}).on('select2:open', function () {
			$('.select2-results__options').niceScroll({
				cursorwidth: "3px",
				cursorborder: "0",
				cursorcolor: "#ffffff",
				cursorborderradius: "0px",
				autohidemode: false
			});
		});
	}
	
	if ( $('#yrRange').length > 0 ) {
		var yrRange = document.getElementById('yrRange'),
			yrInput = document.getElementById('yrInput'),
			currentYear = (new Date()).getFullYear(),
			url_string = window.location.href,
			url = new URL(url_string),
			yr = url.searchParams.get('_yr') ? url.searchParams.get('_yr') : '1986,' + currentYear,
			yrs = yr.split(',');
			
		noUiSlider.create( yrRange, {
			start: yrs,
			step: 1,
			connect: true,
			tooltips: true,
			format: wNumb({
				decimals: 0
			}),
			range: {
				'min': 1986,
				'max': currentYear
			}
		});
		yrRange.noUiSlider.on('update', function( values, handle ){
			yrInput.value = values;
		});
		
		$('#inductee-search form').submit(function(e) {
			$(':input', this).each(function() {
				this.disabled = !($(this).val());
			});
		});
		
		$('#inductee-search form input').change(function() {
			$('.inductee-search-wrap .form-actions button[type="submit"]').addClass('ready');
		});
		
		$('#inductee-search form button[type="reset"]').click(function(e){
			e.preventDefault();
			$(this).closest('form').find(':input').each(function() {
				switch(this.type) {
					case 'password':
					case 'select-multiple':
					case 'select-one':
					case 'text':
					case 'textarea':
						$(this).val('');
						break;
					case 'checkbox':
					case 'radio':
						this.checked = false;
				}
			});
			yrRange.noUiSlider.set( [ 1986, currentYear ] );
			$('.inductee-search-wrap .form-actions button[type="submit"]').removeClass('ready');
		});
	}
	
	if ( typeof $.fancybox == 'object' && site.frontend ) {
		$.fancybox.defaults.toolbar = false;
		$.fancybox.defaults.smallBtn = true;
		$.fancybox.defaults.mobile = {
			clickContent : "close",
			clickSlide : "close"
		}
		$.fancybox.defaults.baseTpl	=
        '<div class="fancybox-container fl-builder-content" role="dialog" tabindex="-1">' +
            '<div class="fancybox-bg"></div>' +
            '<div class="fancybox-inner">' +
                '<div class="fancybox-infobar">' +
                    '<span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span>' +
                '</div>' +
                '<div class="fancybox-toolbar">{{buttons}}</div>' +
                '<div class="fancybox-navigation">{{arrows}}</div>' +
                '<div class="fancybox-stage"></div>' +
                '<div class="fancybox-caption-wrap"><div class="fancybox-caption"></div></div>' +
            '</div>' +
        '</div>';
		
		$.fancybox.defaults.afterLoad = function() {
			console.log('init');
			scrollInit();
		}
	}
	
	function donationInit() {
		var $choices = $('.donation_amount_selection input'),
			$amount = $('.donation_amount input');
			
		$choices.change(function(){
			if ( $(this).is(':checked') ) {
				var value = $(this).val().replace(/\$/g, '');
				$amount.val( value );
				$amount.trigger('change');
			}
		});
		$amount.change(function(){
			$choices.each(function(){
				$(this).prop('checked', false);
			});
		});
	}
	
	function scrollInit() {
		if ( $('#inductee-bio').length > 0 && site.frontend ) {
			$('#inductee-bio .fl-rich-text').niceScroll({
				cursorwidth: "3px",
				cursorborder: "0",
				cursorcolor: "#ffffff",
				cursorborderradius: "0px",
				autohidemode: false
			});
		}
	}
	
	function logoInit() {
		var scTOp = $(window).scrollTop();
		if(scTOp<100 && $('body').hasClass('scroll')){
			$('body').removeClass('scroll')
		} else if(scTOp>=100 && !$('body').hasClass('scroll')){
			$('body').addClass('scroll')
		}
	}
	
	function labelInit() {
		if ( $('.checkbox-inline input').length ) {
			$('.checkbox-inline').each(function(){ 
				$(this).removeClass('c_on');
			});
			$('.checkbox-inline input:checked').each(function(){ 
				$(this).closest('.checkbox-inline').addClass('c_on');
			});                
		}
		if ( $('.radio-inline input').length ) {
			$('.radio-inline').each(function(){ 
				$(this).removeClass('r_on');
			});
			$('.radio-inline input:checked').each(function(){ 
				$(this).closest('.radio-inline').addClass('r_on');
			});
		}
	}
	function isTouchDevice() {
		return true == ( "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch );
	}
})(jQuery);