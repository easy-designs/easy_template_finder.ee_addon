Easy Template Finder
====================

An ExpressionEngine plugin that finds the template used by a given entry.

API
---

This plugin is most useful for dynamically embedding entries.

Here’s an example using a Playa field to control sidebars (stored in the `sidebars` custom field):

	{exp:channel:entries
		disable="categories|category_fields|member_data|pagination|trackbacks"
		}
		{sidebars}
			{embed="{exp:easy_template_finder entry_id='{entry_id}'}"
				entry_id="{entry_id}"
				}
		{/sidebars}
	{/exp:channel:entries}

The plugin only takes a single argument, the `entry_id`, and it returns the template path for embedding.