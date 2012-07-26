/* 
Flickr Photostream
Version: 1.0.1
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

var rowWidth,lastRowWidth,images,ieAdv='<div style="font-size: 12px; border: 1px solid red; background-color: #faa; margin: 10px 0px 10px 0px; padding: 5px 0px 5px 5px;">Your Internet Explorer version is not compatible with Flickr Photostream, upgrade to a newer version or download a different browser</div>';
function isIEVersionCompatible(){for(var e=3,c=document.createElement("div"),d=c.getElementsByTagName("i");c.innerHTML="<\!--[if gt IE "+ ++e+"]><i></i><![endif]--\>",d[0];);return 4<e&&9>e?!1:!0}
jQuery(document).ready(function(e){if(isIEVersionCompatible()){var c=0;images=Array(e("#content-flickrps .flickrps-image").length);e("#content-flickrps .flickrps-image-un").each(function(d,h){images[d]=Array(5);images[d].src=e(h).find("img").attr("src");images[d].alt=e(h).find("img").attr("alt");images[d].href=e(h).find("a").attr("href");e("<img/>").attr("src",images[d].src).load(function(){images[d].width=images[d].height!=rowHeight?Math.ceil(this.width/(this.height/rowHeight)):this.width;images[d].height=
rowHeight;images[d].src=images[d].src.slice(0,images[d].src.length-6);c++;c==images.length&&processesImages(e)})})}else e("#content-flickrps").prepend(ieAdv)});
function processesImages(e){var c={},d=0,h=0,i=0,a,j="",g,f,l;lastRowWidth=rowWidth=e("#content-flickrps").width();for(var k=0;k<images.length;k++)if(i+images[k].width+4<=rowWidth)i+=images[k].width+4,c[h]=k,h++;else{i=Math.ceil((rowWidth-i)/h);a="";for(var b=0;b<h;b++)g=Math.ceil(images[c[b]].height*((images[c[b]].width+i)/images[c[b]].width)),f=images[c[b]].width+i,l=100>=f?"_t":240>=f?"_m":320>=f?"_n":500>=f?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',
a+=images[c[b]].href+'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+f+"px; height: "+g+'px;"></a></div>';j=fixedHeight?j+('<div id="flickrps-row">'+a+"</div>"):j+('<div id="flickrps-row" style="height: '+d+'px;">'+a+"</div>");c={};c[0]=k;h=1;i=images[k].width+4;d=0}a="";if(justifyLastRow){i=Math.ceil((rowWidth-i)/h);for(b=0;b<h;b++)g=Math.ceil(images[c[b]].height*((images[c[b]].width+i)/images[c[b]].width)),f=images[c[b]].width+i,l=100>=
f?"_t":240>=f?"_m":320>=f?"_n":500>=f?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',a+=images[c[b]].href+'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+f+"px; height: "+g+'px;"></a></div>'}else for(b=0;b<h;b++)g=images[c[b]].height,f=images[c[b]].width,l=100>=f?"_t":240>=f?"_m":320>=f?"_n":500>=f?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',a+=images[c[b]].href+
'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+images[c[b]].width+"px; height: "+images[c[b]].height+'px;"></a></div>';j=fixedHeight?j+('<div id="flickrps-row">'+a+"</div>"):j+('<div id="flickrps-row" style="height: '+d+'px;">'+a+"</div>");e("#content-flickrps").html(j);checkWidth(e)}function checkWidth(e){setInterval(function(){2<Math.abs(lastRowWidth-e("#content-flickrps").width())&&processesImages(e)},1E3)};
