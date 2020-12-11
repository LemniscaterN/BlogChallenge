window.MathJax = {
  startup: {
    typeset: false
  },
  tex: {
    inlineMath: [ ['$','$'], ["\(","\)"] ],
    displayMath: [ ['$$','$$'], ["\\(","\\)"] ],
    processEscapes: true
  },
  options: {
    ignoreHtmlClass: 'tex2jax_ignore',
    processHtmlClass: 'tex2jax_process'
  }
};


marked.setOptions({
  renderer: new marked.Renderer(),
  gfm: true,
  tables: true,
  breaks: true,
  pedantic: false,
  sanitize: false,
  smartLists: false,
  smartypants: false
});

function mdToHTML(){
  text = $("#input").val();
// markedにlatexタグ食わせると&<>とかがエスケープされるので<pre />で包んで退避
// ちなみに```mathとかで<pre><code class="lang-math">になったのはエスケープされるので注意
  const PREFIX = "<pre><code class=\"lang-math\">";
  const SUFFIX = "</code></pre>";

  const reg = new RegExp( ("(?:" + PREFIX + "([\\s\\S]*?)" + SUFFIX + ")").replace(/\//g, "\/"), "gm");
  let wraped = text.split("$$")
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + PREFIX + str + SUFFIX;
  }, "");
  const html = marked(wraped);
  console.log(html);


  // 退避したlatexタグを$$で包み直す
  let _html = html;
  let tuple = null;
  while(tuple = reg.exec(html)){
    _html = _html.split(tuple[0]).join("$$" + tuple[1] + "$$");
  }
  // mathjaxで処理
  const div = document.getElementById("output");
  div.innerHTML = _html;
  MathJax.typesetPromise();
};


$("#preview").click(function() {
  mdToHTML();
});
$('#input').keyup(
  function(){
    checkChange(this);
  }
);
let olddata = $("#input").val();
function checkChange(e){
    const newinput = $(e).val();
    if(olddata!=newinput){
      mdToHTML();
      olddata=newinput;
    }
}
