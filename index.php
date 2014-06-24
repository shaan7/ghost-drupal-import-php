<?php

require_once(dirname(__FILE__) . '/HTML_To_Markdown.php');

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function get_posts_tags($drupal_node, $duplicate_tag_correction) {
	$node_id = $drupal_node->nid;
	$posts_tags = array();
	foreach(get_object_vars($drupal_node) as $key => $value) {
		if (startsWith($key, "taxonomy_vocabulary_")) {
			foreach($value["und"] as $tag) {
				$tag_id = (int)$tag["tid"];
				if (array_key_exists($tag_id, $duplicate_tag_correction)) {
					$tag_id = $duplicate_tag_correction[$tag_id];
				}
				$posts_tags[] = array("tag_id" => (int)$tag["tid"], "post_id" => (int)$node_id);
			}
		}
	}

	return $posts_tags;
}

function get_ghost_post_from_drupal_node($drupal_node, $duplicate_tag_correction) {
	$obj = new stdClass();
	$obj->id = (int)$drupal_node->nid;
	$obj->title = $drupal_node->title;
	$obj->slug = $drupal_node->title;
	$obj->html = $drupal_node->body["und"][0]["value"];
	$obj->markdown = (new HTML_To_Markdown(stripslashes($obj->html), array('strip_tags' => true)))->output();
	$obj->image = "";
	$obj->featured = false;		#TODO
	$obj->page = false;
	$obj->status = "published";	#TODO
	$obj->language = "en_US";
	$obj->meta_title = "";
	$obj->meta_description = "";
	$obj->author_id = 1;		#TODO
	$obj->created_at = 1000 * (int)$drupal_node->created;
	$obj->created_by = 1;		#TODO
	$obj->updated_at = 1000 * (int)$drupal_node->changed;
	$obj->updated_by = 1;		#TODO
	$obj->published_at = 1000 * (int)$drupal_node->created;
	$obj->created_by = 1;		#TODO

	$posts_tags = get_posts_tags($drupal_node, $duplicate_tag_correction);

	return array("posts" => $obj, "posts_tags" => $posts_tags);
}

function in_array_by_key($needle, $haystack, $key) {
	foreach ($haystack as $k => $element) {
		if ($element[$key] === $needle[$key]) {
			return $k;
		}
	}
	return false;
}

function get_ghost_tags_from_drupal_vocabularies($drupal_vocabs) {
	$tags = array();
	$duplicate_tag_correction = array();
	foreach ($drupal_vocabs["vocabulary_terms"] as $vocabulary) {
		foreach ($vocabulary as $id => $term) {
			$tag["id"] = $id;
			$tag["name"] = $term->name;
			$tag["slug"] = strtolower(str_replace(".", "-", str_replace(" ", "-", $term->name)));
			$tag["description"] = $term->description;

			if ($key_of_original = in_array_by_key($tag, $tags, "slug")) {
				$duplicate_tag_correction[(int)$tag["id"]] = (int)$key_of_original;
			} else {
				$tags[] = $tag;
			}
		}
	}

	return array("tags" => $tags, "duplicate_tag_correction" => $duplicate_tag_correction);
}

#function merge_duplicate_tags(&$ghost_tags, &$ghost_posts_tags) {
#	tags_to_delete = array();
#	foreach ($ghost_tags as $ghost_tag) {
#		$id = $ghost_tag["id"];
#		$slug = $ghost_tag["slug"];
#
#		foreach ($ghost_tags as $other) {
#			$other_id = $other["id"];
#			if ($other_id === $id)	continue;
#			
#			$other_slug = $other["slug"];
#			if ($other_slug === $slug) {
#				
#			}
#		}
#	}
#}

$taxonomy_terms_file = "/tmp/data_export_import/taxonomy_terms/20140622_100022_taxonomy_terms.dataset";
$nodes_file = "/tmp/data_export_import/nodes/20140622_100016_nodes_story.dataset";
$users_file = "/tmp/data_export_import/users/20140622_100026_users.dataset";

###########################
########## TAGS ###########
###########################

$ghost_tags_and_duplicates = get_ghost_tags_from_drupal_vocabularies(unserialize(file_get_contents($taxonomy_terms_file)));
$ghost_data["tags"] = $ghost_tags_and_duplicates["tags"];
$duplicate_tag_correction = $ghost_tags_and_duplicates["duplicate_tag_correction"];

###########################
########## NODES ##########
###########################

$nodes_handle = fopen($nodes_file, "r");
$content_type = fgets($nodes_handle);	//We don't give a damn about this

$ghost_posts_array = array();
$ghost_posts_tags_array = array();
while ($node_content = fgets($nodes_handle)) {
	$ghost_posts_and_posts_tags = get_ghost_post_from_drupal_node(unserialize(base64_decode($node_content)), $duplicate_tag_correction);
	$ghost_posts_array[] = $ghost_posts_and_posts_tags["posts"];
	$ghost_posts_tags_array = array_merge($ghost_posts_tags_array,$ghost_posts_and_posts_tags["posts_tags"]);
}

$ghost_data["posts"] = $ghost_posts_array;
$ghost_data["posts_tags"] = $ghost_posts_tags_array;

fclose($nodes_handle);

###########################
########## FINAL ##########
###########################

$ghost_meta["exported_on"] = 1000 * time();
$ghost_meta["version"] = "000";

$ghost_import["data"] = $ghost_data;
$ghost_import["meta"] = $ghost_meta;

#merge_duplicate_tags($ghost_import["data"]["tags"], $ghost_import["data"]["posts_tags"]);

echo(json_encode($ghost_import));
?>

