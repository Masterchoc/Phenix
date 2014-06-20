<h1>Blog <small>Derniers articles</small></h1>
{IF:!empty($this->data['articles'])}
	{FOR:articles}
	<h2><a href="/blog/{slug}">{title}</a></h2>
	{name}
	<p>{date|date_format}</p>
	<p>{content}</p>
	{END:}
	<ul class="pagination">
	{IF:!empty($this->data['pages'])}{pages|raw}{ENDIF:}
	</ul>
{ELSE:}
	Aucun article n'a été trouvé.
{ENDIF:}