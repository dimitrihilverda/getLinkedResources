# getLinkedResources
A MODX snippet that returns all symlinks to a resource including the resource itself.

You can use &docId to set the resource to look from, if not set current resource id is used
&tpl can be used this wil have the following fields: id,parent,pagetitle,alias

We use this snippet for our project pages, some projects could have multiple categories, and we like to get nice url's so we created a container resource for each project and in them created the project resourses, and when the same project also belongs to another category we make a symlink to the original.
Then this snippet is used on the overview page to show in what categories the project is in. and on the detail page the same. like tags with links to the real categorie pages. we could have use tags and taglister but this way we got nice url's.

p.s. And ofcource we created a simple piece of code to see if its a symlink, if so it wil add a canonical tag to the original to prevent duplicate content: ```[[*id:pdofield=`class_key`:is=`modSymLink`:then=`<link rel="canonical" href="[[~[[*id:pdofield=`content`]]]]"/>`]]```
