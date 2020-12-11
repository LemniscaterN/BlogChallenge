$("#post").click(function() {
    clickPost();
});

function clickPost(){
    let title = $("#title").val(); 
    let main = $("#input").val();
    let tag = $("#tag").val();
    if(title.trim() !=false && main.trim()!=false){
        console.log(title);
        console.log(main);
        console.log(tag);
        //送信。
    }
};