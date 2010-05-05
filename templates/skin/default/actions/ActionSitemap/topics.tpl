<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
	<!-- Topics -->
{foreach from=$aTopics item=oItem}
	<url> 
		<loc>{cfg name="path.root.web"}/blog/{$oItem.blogURL}{$oItem.topic_id}.html</loc>
		<lastmod>{$oItem.lastmod}</lastmod> 
		<priority>0.9</priority> 
	</url> 
{/foreach}
	<!-- /Topics -->
</urlset>