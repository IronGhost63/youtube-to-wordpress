# youtube-to-wordpress
Automatic create WordPress Post from YouTube Playlist

## Requirement
* WordPress 4.4 or Higher - Because I use meta_input in wp_insert_post()
* YouTube API Key - by create a Project in [Google Developers Console](https://console.developers.google.com/), Enable YouTube Data API, then create API Key in Credentials menu

## Instruction
I recommend you to use a newly created YouTube playlist. (And should be Public Playlist. since I haven't tested plugin with private playlist.) Then you get the playlist ID (https://www.youtube.com/playlist?list=xxxxxx which xxxxx is playlist ID)

Now edit config.php (Sorry, no backend *yet*) and specify these lovely value:
* $api_key - the API Key from Google Developers Console
* $playlist - your desired playlist ID
* $author_id - in case you want post to be associated with specific author. specify it here
* $category_id - in case you want post to be is specific category. specify here

Then you upload plugin into wp-content/plugins and activate. Voila! (or Boom!?)

All Post will be in "Pending" status sitting in All Posts.

Plugin wont get thumbnail automatically. I recommend you to use this plugin: [Video Thumbnail](https://wordpress.org/plugins/video-thumbnails/) for thumbnail. It will scrape for thumbnail once you publish post.

## Caution
Since there is no backend (yet). The plugin will run daily at the same time you activate this plugin. (At this point, scheduled event haven't tested *yet*) If you want to change time to run. you deactivate and activate plugin again on desired time.

## Force run
not "Force close" *ahem*

You can force the script to run at anytime using AJAX API. navigate to /wp-admin/admin-ajax.php?action=updatevideo

It wont return anything but 0 because I haven't write any return *yet*. So after you successfully run script. check in All Posts