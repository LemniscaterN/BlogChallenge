alert("out");
window.MathJax = {
  startup: {
    pageReady: () => {
      return MathJax.startup.defaultPageReady().then(() => {
        console.log('MathJax initial typesetting complete');
        mdToHTML();
      });
    }
  },
  tex: {
    inlineMath: [ ['$','$'] ],//["\(","\)"]
    displayMath: [ ['$$','$$'] ],// ["\\(","\\)"]
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

  let wraped = text.split(/<pre><code>|<\/pre><\/code>/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + "<pre><code>" + escapeHTML(str) + "</pre></code>";
  }, "");
  let html = marked(wraped);

  const div = document.getElementById("output");
  div.innerHTML = html;

  MathJax.typesetPromise();

  let nodeList = document.getElementById("output").querySelectorAll('pre code');
  if(nodeList.length>=1){
    nodeList.forEach((block) => {          
      hljs.highlightBlock(block);
    });
  }

};


$('#input').keyup(
  function(){
    const ch = $('input[name="preview"]').is(':checked');
    if(ch)checkChange(this);
  }
);

let olddata = $("#input").val();
function checkChange(e){
  const ch = $()
  if(olddata!=$(e).val()){
    const newinput = $(e).val();
    mdToHTML();
    olddata=newinput;
  }
}


var escapeHTML = function (str) {
return str
        .replace(/\</g, '&lt;')
        .replace(/\>/g, '&gt;');
};