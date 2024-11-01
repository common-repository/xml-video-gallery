=== XML Video Gallery ===
Contributors: flashblue
Tags: banner, rotator, xml, slide, slideshow, as3, flashblue, html, content, x, y, position, jpg, gif, png, swf, random, radius, url, link, timer, target, order, clock, left, center, right
Requires at least: 2.8.0
Tested up to: 3.0.1
Stable tag: trunk

XML driven flash banner / image rotator.

== Description ==

Features included:

* All data can be changed in the XML file
* Supports multiple FLV-Video files
* Supports RTMP live stream
* Plays YouTube videos
* First visible item selection
* Dynamic menu list
* Supports video streaming with buffer
* Preloader for buffer
* 3 video modes (normal/original, stretch, full view) from XML & control bar
* Click the video for play/pause
* Supports FLVs and MOV , MP4 , M4A , MP4V , 3GP, 3G2 if they contain H.264 video and/or HE-AAC encoded audio
* You can set volume, buffer time via XML
* Video title & description font size, color, background color, alpha can be changed from XML
* Content background color, alpha set in XML
* Supports HTML formatting for video content
* Menu item title, title color can be change using the XML file
* Mouse scroll appears if menu height is higher than video gallery height
* You can auto-play first item & playlist
* Button location set left-right from XML
* Includes WordPress plugin & Joomla module

== Installation ==

Make sure your Wordpress version is greater than 2.8 and your hosting provider is using PHP5.

1. Create a new folder inside your **wp-content** folder called **flashdo**, inside this folder create a new one called **flashblue**, inside this folder create a new one called **xml-video-gallery** and copy files under **deploy** folder there
2. If you copied the **deploy** to a location different than the one above, go to **XML Video Gallery** from the **Settings** tab in your **WordPress Dashboard** and update the path accordingly
3. Add `[xml-video-gallery][/xml-video-gallery]` where you want the Flash to show up in your post/page
4. If you want to make the XML Video Gallery part of your theme, edit the template files and add `<?php xmlvideogallery_echo_embed_code(); ?>` where you want it to show up
5. Modify the `videogallery.xml` content and use it to overwrite `wp-content/flashdo/flashblue/xml-video-gallery/xml/videogallery.xml`
6. To use your own videos, upload them to `wp-content/flashdo/flashblue/xml-video-gallery/videos/`

= Additional settings file =

To embed the XML Video Gallery more than once, you will need another settings file. Let's assume your new file is called `videogallery2.xml`. Add `[xml-video-gallery xmlUrl="xml/videogallery2.xml"][/xml-video-gallery]` where you want the Flash to show up in your post/page. If you made the Flash part of your theme, add the file name as **the first argument** of the `xmlvideogallery_echo_embed_code()` function call (for example `<?php xmlvideogallery_echo_embed_code("xml/videogallery2.xml"); ?>`).

= No Flash support text =

To support visitors without Adobe Flash Player, you can provide alternative content by adding the text between `[xml-video-gallery]` and `[/xml-video-gallery]`. If you made the Flash part of your theme, add the text as **the second argument** of the `xmlvideogallery_echo_embed_code()` function call (for example `<?php xmlvideogallery_echo_embed_code("","Alternative content"); ?>`).

= If you have PHP4 =

To make it work with PHP4, add `[xml-video-gallery width="850" height="450"][/xml-video-gallery]` where you want the Flash to show up in your post/page. If you made the Flash part of your theme, add the width and height as **the third and fourth argument** of the `xmlvideogallery_echo_embed_code()` function call. Don't forget to provide your own width and height values, since 850 and 450 are just examples.

== Screenshots ==

1. You can view the live demo on [flashdo.com](http://www.flashdo.com/item/xml-video-gallery/439 "XML Video Gallery") for XML Video Gallery.