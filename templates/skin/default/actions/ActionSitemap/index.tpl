<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">
{foreach from=$aObjects item=oItem}
	<sitemap>
		<loc>{cfg name="path.root.web"}/sitemaps/{$oItem.type}/sitemap_{$oItem.index}.xml</loc>
	</sitemap>
{/foreach}
</sitemapindex>
