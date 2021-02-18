alert("testOK2");



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
  text = $("#content").text();
  console.log(text);
  
  if(text==undefined){console.log("テキストがない");return;}

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
  alert(wraped);
  let html = marked(wraped);
  console.log(html);


  // 退避したlatexタグを$$で包み直す
  let _html = html;
  let tuple = null;
  while(tuple = reg.exec(html)){
    _html = _html.split(tuple[0]).join("$$" + tuple[1] + "$$");
  }
  // _html = escapeHTML(_html);
  

  // mathjaxで処理
  const elem = document.getElementById("content");
  elem.innerHTML = _html;
  
  // elem.innerHTML = _html;
  // MathJax.typesetPromise();
  // MathJax.Hub.typeset(elem);
  // MathJax.Hub.Typeset();

  var math = document.getElementById("content");

  
  //ハイライト
  document.querySelectorAll('pre code').forEach((block) => {    
    hljs.highlightBlock(block);
    console.log(block);
  });
};


// $("#preview").click(function() {
//   mdToHTML();
// });
// $('#input').keyup(
//   function(){
//     checkChange(this);
//   }
// );
// let olddata = $("#input").val();
// function checkChange(e){
//     const newinput = $(e).val();
//     if(olddata!=newinput){
//       mdToHTML();
//       olddata=newinput;

//     }
// }


// var escapeHTML = function (str) {
//   return str
//           .replace(/&/g, '&amp;')
//           .replace(/</g, '&lt;')
//           .replace(/>/g, '&gt;')
//           .replace(/"/g, '&quot;')
//           .replace(/'/g, '&#39;');
// };

// mdToHTML();
alert("ok");
MathJax.Hub.Typeset();