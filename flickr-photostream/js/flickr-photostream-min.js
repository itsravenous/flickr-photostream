/* 
Flickr Photostream
Version: 1.0
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

var rowWidth,lastRowWidth,images;
jQuery(document).ready(function(f){var c=0;images=Array(f("#content-flickrps .flickrps-image").length);f("#content-flickrps .flickrps-image-un").each(function(d,h){images[d]=Array(5);images[d].src=f(h).find("img").attr("src");images[d].alt=f(h).find("img").attr("alt");images[d].href=f(h).find("a").attr("href");f("<img/>").attr("src",images[d].src).load(function(){images[d].width=images[d].height!=rowHeight?Math.floor(this.width/(this.height/rowHeight)):this.width;images[d].height=rowHeight;images[d].src=
images[d].src.slice(0,images[d].src.length-6);c++;c==images.length&&processesImages(f)})})});
function processesImages(f){var c={},d=0,h=0,i=0,a,j="",g,e,l;lastRowWidth=rowWidth=f("#content-flickrps").width();for(var k=0;k<images.length;k++)if(i+images[k].width+4<rowWidth)i+=images[k].width+4,c[h]=k,h++;else{i=Math.ceil((rowWidth-i)/h);a="";for(var b=0;b<h;b++)g=Math.floor(images[c[b]].height*((images[c[b]].width+i)/images[c[b]].width)),e=images[c[b]].width+i,l=100>=e?"_t":240>=e?"_m":320>=e?"_n":500>=e?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',
a+=images[c[b]].href+'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+e+"px; height: "+g+'px;"></a></div>';j=fixedHeight?j+('<div id="flickrps-row">'+a+"</div>"):j+('<div id="flickrps-row" style="height: '+d+'px;">'+a+"</div>");c={};c[0]=k;h=1;i=images[k].width;d=0}a="";if(justifyLastRow){i=Math.ceil((rowWidth-i)/h);for(b=0;b<h;b++)g=Math.floor(images[c[b]].height*((images[c[b]].width+i)/images[c[b]].width)),e=images[c[b]].width+i,l=100>=
e?"_t":240>=e?"_m":320>=e?"_n":500>=e?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',a+=images[c[b]].href+'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+e+"px; height: "+g+'px;"></a></div>'}else for(b=0;b<h;b++)g=images[c[b]].height,e=images[c[b]].width,l=100>=e?"_t":240>=e?"_m":320>=e?"_n":500>=e?"_n":"_z",fixedHeight||(0==b?d=g:d>g&&(d=g)),a+='<div class="flickrps-image"><a href="',a+=images[c[b]].href+
'" target="_blank"><img alt="',a+=images[c[b]].alt+'" src="',a+=images[c[b]].src+l+'.jpg"',a+='style="width: '+images[c[b]].width+"px; height: "+images[c[b]].height+'px;"></a></div>';j=fixedHeight?j+('<div id="flickrps-row">'+a+"</div>"):j+('<div id="flickrps-row" style="height: '+d+'px;">'+a+"</div>");f("#content-flickrps").html(j);checkWidth(f)}function checkWidth(f){setInterval(function(){5<Math.abs(lastRowWidth-f("#content-flickrps").width())&&processesImages(f)},1E3)};
