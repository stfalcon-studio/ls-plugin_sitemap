<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
	<!-- Blogs -->
{foreach from=$aBlogs item=oItem}
	<url> 
		<loc>{cfg name="path.root.web"}/blog/{$oItem.blog_url}/</loc>
		<lastmod>{$oItem.lastmod}</lastmod> 
		<priority>0.8</priority> 
	</url> 
{/foreach}	
	<!-- /Blogs -->
</urlset>