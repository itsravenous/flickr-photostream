/* 
Flickr Photostream
Version: 1.3
Author: Miro Mannino
Author URI: http://miromannino.it

Copyright 2012 Miro Mannino (miro.mannino@gmail.com)
thanks to Dan Coulter for phpFlickr Class (dan@dancoulter.com)

This file is part of Flickr Photostream.

Flickr Photostream is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

Flickr Photostream is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Flickr 
Photostream Wordpress Plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

function getErrorHtml(a){return'<div style="font-size: 12px; border: 1px solid red; background-color: #faa; margin: 10px 0px 10px 0px; padding: 5px 0px 5px 5px;">'+a+"</div>"}
jQuery(document).ready(function(a){a(".flickrps-container").each(function(e,d){var f=0,b=Array(6),h=a(d).find(".flickrps-images"),c=Array(a(h).find(".flickrps-image-un").length);b.justifyLastRow="true"==a(d).find(".flickrps-meta-justify-last-row").html()?!0:!1;b.rowHeight=parseInt(a(d).find(".flickrps-meta-row-height").html());b.fixedHeight="true"==a(d).find(".flickrps-meta-fixed-height").html()?!0:!1;b.lightbox="true"==a(d).find(".flickrps-meta-lightbox").html()?!0:!1;b.captions="true"==a(d).find(".flickrps-meta-captions").html()?
!0:!1;b.margins=parseInt(a(d).find(".flickrps-meta-margins").html());a(h).find(".flickrps-image-un").each(function(g,e){c[g]=Array(5);c[g].src=a(e).find("img").attr("src");c[g].alt=a(e).find("img").attr("alt");c[g].href=a(e).find("a").attr("href");c[g].title=a(e).find("a").attr("title");c[g].rel=a(e).find("a").attr("rel");a("<img/>").attr("src",c[g].src).load(function(){c[g].width=c[g].height!=b.rowHeight?Math.ceil(this.width/(this.height/b.rowHeight)):this.width;c[g].height=b.rowHeight;c[g].src=
c[g].src.slice(0,c[g].src.length-6);f++;f==c.length&&processesImages(a,h,d,c,0,b)})})})});function buildImage(a,e,d,f,b,h,c){b='<div class="flickrps-image" style="left:'+b+'px">'+(' <a href="'+a.href+'" ');b+='target="_blank" rel="'+a.rel+'"';b+='title="'+a.title+'">';b+='  <img alt="'+a.alt+'" src="'+a.src+e+'.jpg"';b+='style="width: '+d+"px; height: "+f+'px;">';c.captions&&(b+='  <div style="bottom:'+(f-h)+'px;" class="flickrps-image-label">'+a.alt+"</div>");return b+" </a></div>"}
function buildContRow(a,e,d,f){var b,h=0,c;for(b=0;b<a.length;b++)a[b].nh=Math.ceil(e[a[b].indx].height*((e[a[b].indx].width+d)/e[a[b].indx].width)),a[b].nw=e[a[b].indx].width+d,a[b].suffix=getSuffix(a[b].nw),a[b].l=h,f.fixedHeight||(0==b?c=a[b].nh:c>a[b].nh&&(c=a[b].nh)),h+=a[b].nw+f.margins;f.fixedHeight&&(c=f.rowHeight);d="";for(b=0;b<a.length;b++)d+=buildImage(e[a[b].indx],a[b].suffix,a[b].nw,a[b].nh,a[b].l,c,f);return'<div class="flickrps-row" style="height: '+c+"px; margin-bottom:"+f.margins+
'px;">'+d+"</div>"}function getSuffix(a){return 100>=a?"_t":240>=a?"_m":320>=a?"_n":500>=a?"_n":"_z"}
function processesImages(a,e,d,f,b,h){var b=[],c,g,i=0,j="",k=a(d).width();for(c=g=0;g<f.length;g++)i+f[g].width+h.margins<=k?(i+=f[g].width+h.margins,b[c]=Array(5),b[c].indx=g,c++):(c=Math.ceil((k-i+1)/b.length),j+=buildContRow(b,f,c,h),b=[],b[0]=Array(5),b[0].indx=g,c=1,i=f[g].width+h.margins);c=h.justifyLastRow?Math.ceil((k-i+1)/b.length):0;j+=buildContRow(b,f,c,h);a(e).html(j);if(h.lightbox)try{a(e).find(".flickrps-image a").colorbox({maxWidth:"80%",maxHeight:"80%",opacity:0.8,transition:"elastic",
current:""})}catch(l){a(d).html(getErrorHtml("You have set this photostream to work with a lightbox, but there isn't any colorbox installed"))}h.captions&&(a(e).find(".flickrps-image").mouseenter(function(b){a(b.currentTarget).find(".flickrps-image-label").stop();a(b.currentTarget).find(".flickrps-image-label").fadeTo(500,0.7)}),a(e).find(".flickrps-image").mouseleave(function(b){a(b.currentTarget).find(".flickrps-image-label").stop();a(b.currentTarget).find(".flickrps-image-label").fadeTo(500,0)}));
a(d).find(".flickrps-loading").fadeOut(500,function(){a(e).fadeIn(500,function(){a(e).find(".flickrps-image img").one("load",function(){a(this).fadeTo(500,1)}).each(function(){this.complete&&a(this).load()});checkWidth(a,e,d,f,k,h)})})}function checkWidth(a,e,d,f,b,h){var c=setInterval(function(){b!=a(d).width()&&(clearInterval(c),processesImages(a,e,d,f,b,h))},500)};
