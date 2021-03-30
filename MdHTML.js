//参考
//https://github.com/kerzol/markdown-mathjax

//使い方:以下のコメントアウトの内容をコピーして貼り付ける。
//別途、my-mathjax.cssが必要。
//利用しているページは/indexと/edit/

// MathJax = {
//   chtml: {
//     matchFontHeight: false
//   },
//   tex: {
//     displayMath: [ ["$$","$$"] ],
//     inlineMath: [ ["$","$"] ],
//     processEscapes: false
//   },
//   options: {
//     ignoreHtmlClass: "tex2jax_ignore",
//     processHtmlClass: "tex2jax_process"
//   },
//   startup: {
//     typeset: false,
//     skipStartupTypeset: true,
//     pageReady: () => {
//       //準備が整うと呼ばれる。MathJax2系ではMathjax.Hub.Queueだったっぽい
//       console.log("Mathjax pageReady");
//       let text = document.getElementById("input").value;
//       let OutDiv = document.getElementById("output");
//       MdToHTML(text,OutDiv);          
//     }
//   }
// };


//1.MathJaxのpageReady
//2.MdToHTML 
// 2.1 Escape　<>"\
// 2.2 Typeset(Mathjaxの適用)
// 2.3 MakrdAndHighlight
//     2.3.1 PartialRHTMLEscape コード内とコード外で適切な逆エスケープ
//     2.3.2 marked 全て (この時点で```が<pre><code>になる)
//     2.3.3 hljs.highlightBlock　<pre><code>内(コード内)のみハイライト
marked.setOptions({
  renderer: new marked.Renderer(),  
  gfm: true,
  tables: true,
  breaks: true,
  pedantic: false,
  sanitize: false,
  smartLists: true,
  smartypants: false
});

//div.innerText,valueなどのタグが認識されない形式でのtextと出力先のdivを渡す。
//注:innerHTMLにするとタグが補完されるっぽい<math><math>みたいになる。
function MdToHTML(text,OutDiv) {
    text = HTMLEscape2(text);
    OutDiv.innerHTML = text;
    //同期　非同期はMathJax.typesetPromise()
    MathJax.typeset(
      [OutDiv],
    );
    MakrdAndHighlight(OutDiv);
}

function HTMLEscape2(html) {
    return html
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
     .replace(/'/g, '&#39;');
}

function RHTMLEscape2(html) {
  return html
  .replace(/&lt;/g, '<')
  .replace(/&gt;/g, '>')
  .replace(/&quot;/g, '"')
  .replace(/&#39;/g, '\'');
}

function MakrdAndHighlight(OutDiv){
    let text = OutDiv.innerHTML;
    text = PartialRHTMLEscape2(text);
    OutDiv.innerHTML = marked (text); 

    // シンタックスハイライト
    let nodeList = OutDiv.querySelectorAll("code");
    if(nodeList.length>=1){
        nodeList.forEach((block) => {  
          // console.log("block"+block.innerHTML);      
          hljs.highlightBlock(block);
        });
    }
}

function PartialRHTMLEscape2(html) {
  //この時点で数式は全てMathjaxを通じてごちゃごちゃしたタグになっている。
  //```内部は特殊記号が全てエスケープされた状態の文字列
  html =  html.split(/```/)
    .reduce(function(sum, str, i){
      // console.log("Partial:"+i+"="+str);
      return i % 2 === 0 ?
             sum + str.replace(/&gt;/g, '>') :
             sum + "```" +RHTMLEscape2(str) +"```";
    }, ""); 
  // console.log(html);  
  return html;
}