��    \      �     �      �  .   �  �     �   �  �   	  g   �	  1   �	     (
     =
     F
  T   W
  |   �
     )     6     E  G   V     �  K   �  N     	   Q     [     q     �     �     �     �  �   �     c  l   �  J   �  �   :  �   �  7   h  �   �     C     Y  2   h     �     �     �     �  !   �  1   �  
   #  	   .     8  f   =     �     �  
   �     �     �  �   �  �   �     B     O     T     ]     o  G   t  M   �  <   
  D   G  D   �  E   �  �     �   �  _   V  �   �  �   �  �   _  �     �   �  \   R  �   �     �  H   �  B   �  `   7  F   �  A   �     !  1   8  2   j  @   �  >   �  <     4   Z  K   �  �   �  �   �     >   �  C   )   ("  z   R"  {   �"  y   I#  `   �#  6   $$     [$  	   n$     x$  ^   �$  �   �$     �%     �%     �%  Q   �%     &  N   &  K   n&     �&     �&  !   �&     �&  
   '     '     #'  �   5'  (   �'  z   (  j   �(  �   �(  �   �)  G   `*  �   �*     �+     �+  4   �+  
   �+     �+     �+     ,  !   ,  6   ?,     v,     �,     �,  w   �,     -     ,-     :-     F-     ^-  �   m-  �   .     �.     �.     �.     �.     /  H   /  ^   \/  =   �/  K   �/  W   E0  U   �0  �   �0  �   �1  d   "2    �2  �   �3  �   I4  �   5  �   �5  W   O6  �   �6  	   �7  B   �7  D   �7  �   18  D   �8  ?   �8  "   79  C   Z9  ;   �9  E   �9  A    :  <   b:  8   �:  Q   �:  �   *;  �   %<     �<     "   W   8           Y      F   C          D           X         0   1      $      .   5   !             A       >       &   B      O                        E   M   (   #                 %   V           2   I            G   3   S   :   @   Z   )                H   9   ;       4       T           [                          U       Q   6   J       L      R      
   '   +       ,       *      \          -       =   <       P   ?          /          	       N       K      7    </code> attribute to change this default value </code> attribute to change this default value (with the value <code>justify</code>, <code>nojustify</code> or <code>hide</code>) </code> attribute to change this default value (with the value <code>none</code>, <code>colorbox</code> or <code>swipebox</code>). </code> attribute to change this default value (with the value <code>none</code>, <code>prevnext</code> or <code>numbers</code>) </code> attribute to change this default value (with the value <code>true</code> or <code>false</code>) <span class="meta-nav">&larr;</span> Older photos API Key is not valid Captions Default Settings Displays photos with all the tags listed (the list is viewed as an AND combination). Displays photos with one or more of the tags listed (the list is viewed as an OR combination, that is the default behavior). Fixed Height Flickr API Key Flickr API error Flickr Photostream can't be activated: the cache Folder is not writable FlickrPhotostream error For example, the <code>gallery_id</code> of the gallery located in the URL: For example, the <code>photoset_id</code> of the photo set located in the URL: Galleries Get the User ID from  Get your Flickr API Key from  Global Settings Group pools Help Help the project Help the project to grow. Donate something, or simply <a href="http://wordpress.org/plugins/flickr-photostream" target="_blank">rate the plugin on Wordpress</a>. Hide if it cannot be justified However, you can also use the attributes to have settings that are different than the defaults. For example: If enabled, each row has the same height, but the images will be cut more. If enabled, navigation buttons will be shown, and you can see the older photos.<br/><i>Use only one instance per page with this settings enabled!</i> If enabled, the lightbox will show the original images if they are available. Consider to leave this option off if your original images are very large. If enabled, the photos of the same page are randomized. If enabled, the title of the photo will be shown over the image when the mouse is over. Note: <i>captions, with small images, become aesthetically unpleasing</i>. Images Height (in px) Invalid UserID Invalid values, the settings have not been updated Justify Last Row Lightbox Margin between the images Maximum number of photos per page Newer photos <span class="meta-nav">&rarr;</span> No justify No photos None On the contrary, Swipebox comes with this plugin and you don't have to provide it with another plugin. Open original images Page Numbers Pagination Previous and Next Randomize order Remember that, if the gallery is owned by the default user (specified in the settings), you don't need the <code>user_id</code> attribute in the shortcode. Remember that, if the photo that you want to display is owned by the default user (specified in the settings), you don't need the <code>user_id</code> attribute in the shortcode. Save Changes Sets Settings Settings updated. Tags The 'Images Height' field must have a value greater than or equal to 30 The 'Margins' field must have a value greater than 0, and not greater than 30 The 'Photos per page' field must have a value greater than 0 The last_row attribute can be only "hide", "justify" or "nojustify". The lightbox attribute can be only "none", "colorbox" or "swipebox". The pagination attribute can be only "none", "prevnext" or "numbers". Then, you can choose to use the list as a OR combination of tags (to return photos that have <b>any</b> tag), or an AND combination (to return photos that have <b>all</b> the tags). To display the default user's Photostream, create a page and simply write the following shortcode where you want to display the gallery. To do this, you need to use the <code>tags_mode</code>, specifying "any" or "all". For example: To show a particular gallery, you need to use the <code>flickr_gallery</code> shortcode, and specify the <code>user_id</code> with the attribute <code>user_id</code>, and the <code>gallery_id</code> with the attribute <code>id</code>. For example: To show a particular group pool, you need to use the <code>flickr_group</code> shortcode, and specify the <code>group_id</code> with the attribute <code>id</code>. For example: To show a particular photoset, you need to use the <code>flickr_set</code> shortcode, and specify the <code>photoset_id</code> with the attribute <code>id</code>. For example: To show the photos of a particular gallery, you need to know the <code>user_id</code> of the user that owns it, and its <code>gallery_id</code>. To show the photos of a particular group pool, you need to know the <code>group_id</code>, that you can retrieve using <a href="http://idgettr.com/" target="_blank">idgettr</a>. To show the photos of a particular photo set, you need to know its <code>photoset_id</code>. To show the photos that have some particular tags, you need to use the <code>flickr_tags</code> shortcode, and specify the <code>user_id</code> and the tags with the attribute <code>tags</code>, as a comma-delimited list of words. For example: User ID With Colorbox, make sure that you have installed it with a plugin (i.e.  You can also configure it to show other Photostreams. For example: You can also exclude results that match a term by prepending it with a <code>-</code> character. You can see that it is always the number after the word '/galleries/'. You can see that it is always the number after the word '/sets/'. You can use the <code> You can't use an attribute to change this setting You must specify a valid tags_mode: "any" or "all" You must specify the id of the gallery, using the "id" attribute You must specify the id of the group, using the "id" attribute You must specify the id of the set, using the "id" attribute You must specify the tags using the "tags" attribute You must specify the user_id for this action, using the "user_id" attribute displays the Photostream of the specified user, no matter what is the default user ID in the settings. Remember that you can use <a href="http://idgettr.com/" target="_blank">idgettr</a> to retrieve the <code>user_id</code>. displays the latest 50 photos of the default user Photostream, without any page navigation. (the other settings are the defaults) is:  Project-Id-Version: Flickr Photostream
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2014-04-13 17:40+0100
PO-Revision-Date: 2014-04-13 17:44+0100
Last-Translator: Miro Mannino <miro.mannino@gmail.com>
Language-Team: Miro Mannino <miro.mannino@gmail.com>
Language: it_IT
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: esc_attr__;_e;__;_n;esc_attr_e
X-Poedit-Basepath: .
X-Generator: Poedit 1.6.4
X-Poedit-SearchPath-0: ..
 </code> per cambiare il valore di default </code> per cambiare il valore di default (con i valori <code>justify</code>, <code>nojustify</code> o <code>hide</code>). </code> per cambiare il valore di default (con i valori <code>none</code>, <code>colorbox</code> or <code>swipebox</code>). </code> per cambiare il valore di default (con i valori <code>none</code>, <code>prevnext</code> o <code>numbers</code>). </code> per cambiare il valore di default (con i valori <code>true</code> o <code>false</code>). <span class="meta-nav">&larr;</span> Foto meno recenti API Key non valida Etichette Impostazioni di Default Mostra le foto che hanno tutti i tag listati (la lista è vista come una combinazione in AND). Mostra le foto che hanno uno o più tag tra quelli listati (la lista è vista come una combinazione in OR, che è il comportamento predefinito). Altezza fissata Chiave Flickr API Errore Flickr API Flickr Photostream non può essere attivato: la cartella chache non è scrivibile Errore FlickrPhotostream Per esempio, il <code>gallery_id</code> della galleria accessibile con la URL: Per esempio, il <code>photoset_id</code> del photoset accessibile dall'URL: Gallerie Ottieni l'ID Utente da  Ottieni la tua Flickr API Key da  Impostazioni Globali Group Pool Aiuto Aiuta il progetto Aiuta il progetto a crescere. Dona qualcosa, o semplicemente <a href="http://wordpress.org/plugins/flickr-photostream" target="_blank">recensisci il plugin su Wordpress</a>. Nascondi se non può essere giustificata Tuttavia, puoi utilizzare gli attributi per avere impostazioni che sono diverse rispetto a quelle di default. Per esempio: Se abilitato, ogni riga avrà la stessa altezza, quindi le immagini potranno essere maggiormente tagliate. Se abilitato,  verranno mostrati dei pulsanti di navigazione e si potranno visualizzare le pagine delle foto meno recenti.<br/><i>Per ogni pagina, utilizza solo un istanza con questa opzione abilitata!</i> Se abilitato, il lightbox mostrerà le foto originali se sono disponibili. Considera di togliere questa opzione se le tue immagini originali sono molto grandi. Se abilitato, le foto della stessa pagina saranno disposte casualmente. Se abilitata, il titolo della foto verrà mostrato sopra l'immagine quando il mouse sarà sopra di essa. Nota: <i>quando l'altezza delle immagini è troppo piccola, le etichette diventano esteticamente sgradevoli</i>. Altezza Immagini (in px) ID Utente non valido Valori non validi, le opzioni non sono state salvate Giustifica Ultima riga Lightbox Margine tra le immagini Massimo numero di foto per pagina Foto più recenti <span class="meta-nav">&rarr;</span> Non giustificare Nessuna foto Nessuna Al contrario, Swipebox viene fornito insieme al plugin e non devi necessariamente fornirlo installando un altro plugin. Apri immagini originali Numero pagine Paginazione Precedente e successiva Ordine casuale Ricorda che, se la galleria è posseduta dall'utente di default (specificato nelle impostazioni), puoi anche non utilizzare l'attributo <code>user_id</code> nello shortcode. Ricorda che, se le foto che vuoi mostrare sono possedute dall'utente di default (specificato nelle impostazioni), puoi anche non utilizzare l'attributo <code>user_id</code> nello shortcode. Salva le modifiche Sets Impostazioni Opzioni salvate Tags Il campo 'Altezza Immagini' deve essere un valore maggiore o uguale a 30 Il campo 'Margini tra le immagini' deve avere un valore maggiore di 0, e non più grande di 30 Il campo 'Foto per pagina' deve avere un valore maggiore di 0 L'attributo last_row può essere solamente "hide", "justify" o "nojustify". L'attributo per il lightbox può essere solamente "none", "colorbox" oppure "swipebox". L'attributo per la paginazione può essere solamente "none", "prevnext" or "numbers". Poi puoi scegliere di utilizzare la lista come una combinazione di tag in OR (specificando "any"), oppure una combinazione in AND (specificando "all"). Per mostrare il Photostream dell'utente di default, create una pagina e inserite semplicemente il seguente shortcode dove volete mostrare la galleria. Per fare ciò, devi utilizzare <code>tags_mode</code>, specificando "any" oppure "all". Per esempio: Per mostrare una particolare galleria devi utilizzare lo shortcode <code>flickr_gallery</code>, e specificare l'<code>user_id</code> utilizzando l'attributo <code>user_id</code>, e il <code>gallery_id</code> utilizzando l'attributo <code>id</code>. Per esempio: Per mostrare un particolare group pool devi utilizzare lo shortcode <code>flickr_group</code>, e specificare il <code>group_id</code> utilizzando l'attributo <code>id</code>. Per esempio: Per mostrare un particolare photoset devi utilizzare lo shortcode <code>flickr_set</code>, e specificare il <code>photoset_id</code> utilizzando l'attributo <code>id</code>. Per esempio: Per mostrare una particolare galleria bisogna conoscere l'<code>user_id</code> dell'utente che la possiede, ed anche la sua <code>gallery_id</code>. Per mostrare le foto di un particolare group pool bisogna conoscere il <code>group_id</code>, puoi recuperarlo utilizzando <a href="http://idgettr.com/" target="_blank">idgettr</a>. Per mostrare un particolare photoset bisogna conoscere il suo <code>photoset_id</code>. Per mostrare le foto che hanno un tag particolari, bisogna utilizzare lo shortcode <code>flickr_tags</code>, e specificare l'<code>user_id</code> e i tag con l'attributo <code>tags</code>, come una lista di parole separata da virgole. Per esempio: ID Utente Con Colorbox, assicurati di averlo installato con un plugin (i.e.  Puoi anche configurarlo per mostrare altri Photostream. Per esempio: Puoi anche escludere i risultati che corrispondono ad un termine aggiungendo all'inizio del termine il carattere <code>-</code>. Nota che è sempre il numero che viene dopo la parola '/galleries/'. Nota che è sempre il numero che viene dopo la parola '/sets/'. Puoi utilizzare l'attributo <code> Non puoi utilizzare un attributo per modificare questa impostazione Bisogna specificare un tags_mode valito: "any" oppure "all" Bisogna specificare l'id della galleria, utilizzando l'attributo "id" Bisogna specificare l'id del gruppo, utilizzando l'attributo "id" Devi specificare l'id del set, utilizzando l'attributo "id". Bisogna specificare i tag utilizzando l'attributo "tags" Bisogna specificare l'user_id per quest'azione, utilizzando l'attributo "user_id" mostra il Photostream dell'utente specificato, indipendentemente dall'ID dell'utente che è stato specificato nelle impostazioni. Ricorda che puoi utilizzare <a href="http://idgettr.com/" target="_blank">idgettr</a> per sapere l'<code>user_id</code>. mostra le ultime 50 foto del Photostream dell'utente di default, senza nessuna navigazione tra pagine. (le altre impostazioni sono quelle di default) è: 