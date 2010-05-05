<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
	<!-- UserProfiles and UserBlogs and UserComments-->
{foreach from=$aUsers item=oItem}
	<url> 
		<loc>{cfg name="path.root.web"}/my/{$oItem.user_login}/</loc>
		<lastmod>{$oItem.lastmod}</lastmod> 
		<priority>0.9</priority> 
	</url>
	<url> 
		<loc>{cfg name="path.root.web"}/profile/{$oItem.user_login}/</loc>
		<lastmod>{$oItem.lastmod}</lastmod> 
		<priority>0.8</priority> 
	</url> 
	<url> 
		<loc>{cfg name="path.root.web"}/my/{$oItem.user_login}/comment/</loc>
		<lastmod>{$oItem.lastmod}</lastmod> 
		<priority>0.7</priority> 
	</url> 
{/foreach}	
	<!-- /UserProfiles -->
</urlset>	