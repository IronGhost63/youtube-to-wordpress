<?php
/**
 * Plugin Name: YouTube to WordPress
 * Plugin URI: https://github.com/IronGhost63/youtube-to-wordpress
 * Description: Automatic create WordPress Post from YouTube Playlist
 * Version: 1.0.0
 * Author: Jirayu Yingthawornsuk
 * Author URI: http://jirayu.in.th
 * License: GPL2
 */

function my_activation() {
	if (! wp_next_scheduled ( 'my_daily_event' )) {
		wp_schedule_event(time(), 'daily', 'my_daily_event');
	}
}

function ig63_get_playlist() {
	require_once("config.php");

	$json_data = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=". $playlist ."&key=" .$api_key), true);

	$cached = get_option("ig63_cached_video", array());
	$new_video = array();

	foreach ($json_data['items'] as $item){
		if(!in_array($item['snippet']['resourceId']['videoId'], $cached)){
			$cached[] = $item['snippet']['resourceId']['videoId'];

			/*
			$new_video[] = array(
				'id' => $item['snippet']['resourceId']['videoId'],
				'title' => $item['snippet']['title'],
				'description' => $item['snippet']['description'],
				'thumbnail' => "http://img.youtube.com/vi/". $item['snippet']['resourceId']['videoId'] ."/maxresdefault.jpg"
			);
			*/
			$content = "https://www.youtube.com/watch?v=" . $item['snippet']['resourceId']['videoId'];
			$content .= "\n\n" . $item['snippet']['description'];

			$args = array(
				'post_title' => $item['snippet']['title'],
				'post_author' => $author_id,
				'post_status' => 'pending',
				'post_content' => $content,
				'post_category' => $category_id
			);

			wp_insert_post($args);
		}
	}
	update_option("ig63_cached_video", $cached, false);
}

register_activation_hook(__FILE__, 'my_activation');
add_action("my_daily_event", "ig63_get_playlist");
add_action("wp_ajax_updatevideo", "ig63_get_playlist");
?>