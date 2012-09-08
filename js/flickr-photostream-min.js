/* 
Flickr Photostream
Version: 1.2
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

function getErrorHtml(a){return'<div style="font-size: 12px; border: 1px solid red; background-color: #faa; margin: 10px 0px 10px 0px; padding: 5px 0px 5px 5px;">'+a+"</div>"}function isIEVersionCompatible(){for(var a=3,j=document.createElement("div"),f=j.getElementsByTagName("i");j.innerHTML="<\!--[if gt IE "+ ++a+"]><i></i><![endif]--\>",f[0];);return 4<a&&9>a?!1:!0}
jQuery(document).ready(function(a){a(".flickrps-container").each(function(j,f){if(isIEVersionCompatible()){var d=0,b=Array(a(f).find(".flickrps-image-un").length),p="true"==a(f).find(".flickrps-meta-justify-last-row").html()?!0:!1,m=a(f).find(".flickrps-meta-row-height").html(),n="true"==a(f).find(".flickrps-meta-fixed-height").html()?!0:!1,q="true"==a(f).find(".flickrps-meta-lightbox").html()?!0:!1;imgCont=a(f).find(".flickrps-images");a(imgCont).find(".flickrps-image-un").each(function(c,i){b[c]=
Array(5);b[c].src=a(i).find("img").attr("src");b[c].alt=a(i).find("img").attr("alt");b[c].href=a(i).find("a").attr("href");b[c].title=a(i).find("a").attr("title");b[c].rel=a(i).find("a").attr("rel");a("<img/>").attr("src",b[c].src).load(function(){b[c].width=b[c].height!=m?Math.ceil(this.width/(this.height/m)):this.width;b[c].height=m;b[c].src=b[c].src.slice(0,b[c].src.length-6);d++;d==b.length&&processesImages(a,imgCont,f,b,0,p,m,n,q)})})}else a(f).prepend(getErrorHtml("Your Internet Explorer version is not compatible with Flickr Photostream, upgrade to a newer version or download a different browser"))})});
function buildImage(a,j,f,d){ris='<div class="flickrps-image">';ris+=' <a href="'+a.href+'" ';ris+='target="_blank" rel="'+a.rel+'"';ris+='title="'+a.title+'">';ris+='  <img alt="'+a.alt+'" src="'+a.src+j+'.jpg"';ris+='style="width: '+f+"px; height: "+d+'px;">';return ris+=" </a></div>"}
function processesImages(a,j,f,d,b,p,m,n,q){for(var b={},c=0,i=0,l=0,k,s="",h,g,r,t=a(f).width(),o=0;o<d.length;o++)if(l+d[o].width+4<=t)l+=d[o].width+4,b[i]=o,i++;else{l=Math.ceil((t-l)/i);k="";for(var e=0;e<i;e++)h=Math.ceil(d[b[e]].height*((d[b[e]].width+l)/d[b[e]].width)),g=d[b[e]].width+l,r=100>=g?"_t":240>=g?"_m":320>=g?"_n":500>=g?"_n":"_z",n||(0==e?c=h:c>h&&(c=h)),k+=buildImage(d[b[e]],r,g,h);s=n?s+('<div class="flickrps-row" style="height:'+m+'px;">'+k+"</div>"):s+('<div class="flickrps-row" style="height: '+
c+'px;">'+k+"</div>");b={};b[0]=o;i=1;l=d[o].width+4;k="";c=0}k="";if(p){l=Math.ceil((t-l)/i);for(e=0;e<i;e++)h=Math.ceil(d[b[e]].height*((d[b[e]].width+l)/d[b[e]].width)),g=d[b[e]].width+l,r=100>=g?"_t":240>=g?"_m":320>=g?"_n":500>=g?"_n":"_z",n||(0==e?c=h:c>h&&(c=h)),k+=buildImage(d[b[e]],r,g,h)}else for(e=0;e<i;e++)h=d[b[e]].height,g=d[b[e]].width,r=100>=g?"_t":240>=g?"_m":320>=g?"_n":500>=g?"_n":"_z",n||(0==e?c=h:c>h&&(c=h)),k+=buildImage(d[b[e]],r,g,h);a(j).html(n?s+('<div class="flickrps-row" style="height:'+
m+'px;">'+k+"</div>"):s+('<div class="flickrps-row" style="height: '+c+'px;">'+k+"</div>"));if(q)try{a(j).find(".flickrps-image a").colorbox({maxWidth:"80%",maxHeight:"80%",opacity:0.8,transition:"elastic",current:""})}catch(u){a(f).prepend(getErrorHtml("You have set this photostream to work with a lightbox, but there isn't any colorbox installed"))}a(f).find(".flickrps-loading").fadeOut(500,function(){a(j).fadeIn(500,function(){a(j).find(".flickrps-image img").one("load",function(){a(this).fadeTo(500,
1)}).each(function(){this.complete&&a(this).load()});checkWidth(a,j,f,d,t,p,m,n,q)})})}function checkWidth(a,j,f,d,b,p,m,n,q){var c=setInterval(function(){2<Math.abs(b-a(f).width())&&(clearInterval(c),processesImages(a,j,f,d,b,p,m,n,q))},1E3)};
