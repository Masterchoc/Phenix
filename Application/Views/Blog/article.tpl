<a href="/blog">Tous les articles</a>
{IF:!empty($this->data['article'])}
	{FOR:article}
	<h2>{title}</h2>
	<p>{date|date_format}</p>
	<p>{content}</p>
	{END:}
{ELSE:}
	Aucun article n'a été trouvé à cette adresse.
{ENDIF:}