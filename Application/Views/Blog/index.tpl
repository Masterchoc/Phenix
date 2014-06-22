<div class="row">
<div class="large-9 columns" role="content">
{IF:!empty($this->data['articles'])}
	<div class="icon-bar five-up right">
		<a class="item">
			⚏
		</a>
	</div>
	{FOR:articles}
	<article>
		<h3><a href="/blog/{slug}">{title}</a></h3>
		<h6>Written by <a href="#">John Smith</a> le {date|date_format}</h6>
		<div class="row">
			<div class="large-6 columns blog-image">
				<img src="http://lorempicsum.com/simpsons/550/250/1"/>
				<span class="label">{name}</span>
			</div>
			<div class="large-6 columns">{content}</div>
		</div>
	</article>
	<hr/>
	{END:}
	<ul class="pagination">
	{IF:!empty($this->data['pages'])}{pages|raw}{ENDIF:}
	</ul>
{ELSE:}
	Aucun article trouvé
{ENDIF:}
</div>
