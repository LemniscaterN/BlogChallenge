

window.MathJax = {
  // startup: {
  //   typeset: false
  // },
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
let text = $("#input").val();
  
let result = new RegExp(/<pre><code>([\S\s]+?)<\/pre><\/code>/igm);

let resultArray=text.split(result);

const len = resultArray.length
// console.log("***"+len);
if(len>=3){
  for (let i = 1; i < len; i+=2) {
    // console.log("loop:"+resultArray[i]);
    text=text.replace(resultArray[i],escapeHTML(resultArray[i]));
  }
}
  
let div = document.getElementById("output");
div.innerHTML = text;

div.querySelectorAll('pre code').forEach((block) => {    
  hljs.highlightBlock(block);
});

MathJax.typesetPromise();
div.innerHTML=marked(div.innerHTML);

};



// $("#preview").click(function() {
// mdToHTML();
// });


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

//MathJaxの読み込みタイミングが遅すぎるので表示に失敗することがあるon loadも同じ。
// $(document).ready(function(){
//   alert("ok");
//   mdToHTML();
// });