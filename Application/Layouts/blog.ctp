     
 <div class="row">
  <div class="large-12 columns">
    <h1>Blog <small>This is my blog. It's awesome.</small></h1>
    <hr/>
  </div>
</div>
 
{content_for_layout|raw}

<aside class="large-3 columns">
  <h5>Categories</h5>
  {IF:!empty($this->data['categories'])}
    <ul class="side-nav">
    {FOR:categories}
      <li><a href="/blog/categorie/{name|slugify}">{name}</a></li>
    {END:}
    </ul>
  {ENDIF:}

  {IF:!empty($this->data['featured'])}
  <div class="panel">
    <h5>Featured</h5>
    {FOR:featured}
    <p>{content}</p>
    <a href="/blog/{slug}">Lire la suite →</a>
    {END:}
  </div>
  {ENDIF:}

</aside>
</div>
<footer class="row">
  <div class="large-12 columns">
    <hr/>
    <div class="row">
      <div class="large-6 columns">
        <p>© Copyright no one at all. Go to town.</p>
      </div>
      <div class="large-6 columns">
        <ul class="inline-list right">
          <li><a href="#">Link 1</a></li>
          <li><a href="#">Link 2</a></li>
          <li><a href="#">Link 3</a></li>
          <li><a href="#">Link 4</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
    