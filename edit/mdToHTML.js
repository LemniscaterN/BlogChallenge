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
    //ここを変更する場合は、このページのescapeTeX、RescapeTeX、
    //ホームページの組み込みコードを変更する必要があるので注意すること。
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
  
  //コードハイライトで<>を利用できる
  text = text.split(/<pre><code>|<\/pre><\/code>/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + "<pre><code>" + escapeHTML(str) + "</pre></code>";
  }, "");
  //markedに数式関連の記号が食われるのを防ぐ
  text = escapeTeX(text);

  
  //変更した箇所を逆変換
  let html = RescapeTeX(marked(text));
  // console.log(html);

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

//コードハイライトで<>が表示されなくなるのを防ぐ
var escapeHTML = function (str) {
return str
        .replace(/\</g, '&lt;')
        .replace(/\>/g, '&gt;');
};


//TeXで利用する記号がmarkedに食われるのを防ぐ
var escapeTeX = function(text){
  text = text.split(/\$\$/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + "<pre><2>" + str + "<2></pre>";
  }, "");
  text = text.split(/\$/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + "<pre><1>" + str + "<1></pre>";
  }, "");
  // console.log("変換"+text);
  return text;
}

var RescapeTeX = function(html){
  html = html.split(/<pre><1>|<1><\/pre>/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum + "$" + str + "$";
  }, "");
  html = html.split(/<pre><2>|<2><\/pre>/)
  .reduce(function(sum, str, i){
    return i % 2 === 0 ?
           sum + str :
           sum +
            "$$" + str + "$$";
  }, "");
  // console.log("逆変換"+html);
  return html;
}