/* 
Flickr Photostream
Version: 1.1
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

var ieAdv='<div style="font-size: 12px; border: 1px solid red; background-color: #faa; margin: 10px 0px 10px 0px; padding: 5px 0px 5px 5px;">Your Internet Explorer version is not compatible with Flickr Photostream, upgrade to a newer version or download a different browser</div>';function isIEVersionCompatible(){for(var a=3,k=document.createElement("div"),b=k.getElementsByTagName("i");k.innerHTML="<\!--[if gt IE "+ ++a+"]><i></i><![endif]--\>",b[0];);return 4<a&&9>a?!1:!0}
jQuery(document).ready(function(a){isIEVersionCompatible()?a(".content-flickrps").each(function(k,b){var c=0,f=Array(a(b).find(".flickrps-image-un").length),n="true"==a(b).find(".flickrps-meta-justify-last-row").html()?!0:!1,l=a(b).find(".flickrps-meta-row-height").html(),p="true"==a(b).find(".flickrps-meta-fixed-height").html()?!0:!1,i="true"==a(b).find(".flickrps-meta-lightbox").html()?!0:!1;a(b).find(".flickrps-image-un").each(function(e,g){f[e]=Array(5);f[e].src=a(g).find("img").attr("src");f[e].alt=
a(g).find("img").attr("alt");f[e].href=a(g).find("a").attr("href");f[e].title=a(g).find("a").attr("title");f[e].rel=a(g).find("a").attr("rel");a("<img/>").attr("src",f[e].src).load(function(){f[e].width=f[e].height!=l?Math.ceil(this.width/(this.height/l)):this.width;f[e].height=l;f[e].src=f[e].src.slice(0,f[e].src.length-6);c++;c==f.length&&processesImages(a,b,f,0,n,l,p,i)})})}):a(".content-flickrps").prepend(ieAdv)});
function buildImage(a,k,b,c){ris='<div class="flickrps-image">';ris+=' <a href="'+a.href+'" ';ris+='target="_blank" rel="'+a.rel+'"';ris+='title="'+a.title+'">';ris+='  <img alt="'+a.alt+'" src="'+a.src+k+'.jpg"';ris+='style="width: '+b+"px; height: "+c+'px;">';return ris+=" </a></div>"}
function processesImages(a,k,b,c,f,n,l,p){for(var c={},i=0,e=0,g=0,m,r="",j,h,q,s=a(k).width(),o=0;o<b.length;o++)if(g+b[o].width+4<=s)g+=b[o].width+4,c[e]=o,e++;else{g=Math.ceil((s-g)/e);m="";for(var d=0;d<e;d++)j=Math.ceil(b[c[d]].height*((b[c[d]].width+g)/b[c[d]].width)),h=b[c[d]].width+g,q=100>=h?"_t":240>=h?"_m":320>=h?"_n":500>=h?"_n":"_z",l||(0==d?i=j:i>j&&(i=j)),m+=buildImage(b[c[d]],q,h,j);r=l?r+('<div class="flickrps-row" style="height:'+n+'px;">'+m+"</div>"):r+('<div class="flickrps-row" style="height: '+
i+'px;">'+m+"</div>");c={};c[0]=o;e=1;g=b[o].width+4;i=0}m="";if(f){g=Math.ceil((s-g)/e);for(d=0;d<e;d++)j=Math.ceil(b[c[d]].height*((b[c[d]].width+g)/b[c[d]].width)),h=b[c[d]].width+g,q=100>=h?"_t":240>=h?"_m":320>=h?"_n":500>=h?"_n":"_z",l||(0==d?i=j:i>j&&(i=j)),m+=buildImage(b[c[d]],q,h,j)}else for(d=0;d<e;d++)j=b[c[d]].height,h=b[c[d]].width,q=100>=h?"_t":240>=h?"_m":320>=h?"_n":500>=h?"_n":"_z",l||(0==d?i=j:i>j&&(i=j)),m+=buildImage(b[c[d]],q,h,j);a(k).html(l?r+('<div class="flickrps-row" style="height:'+
n+'px;">'+m+"</div>"):r+('<div class="flickrps-row" style="height: '+i+'px;">'+m+"</div>"));p&&a(k).find(".flickrps-image a").colorbox({maxWidth:"80%",maxHeight:"80%",opacity:0.8,transition:"elastic",current:""});checkWidth(a,k,b,s,f,n,l,p)}function checkWidth(a,k,b,c,f,n,l,p){var i=setInterval(function(){2<Math.abs(c-a(k).width())&&(clearInterval(i),processesImages(a,k,b,c,f,n,l,p))},1E3)};
