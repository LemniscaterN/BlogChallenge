// function sucessLogin(name){
//     $("#output").addClass("alert alert-success animated").html("Welcome back " + "<span style='text-transform:uppercase'>" + name + "</span>");
//     $("#output").removeClass(' alert-danger');
//     $('#loginform').append('<h>ログインしました</h>');
//     $("input").css({
//     "height":"0",
//     "padding":"0",
//     "margin":"0",
//     "opacity":"0"
//     });
    

//     $('.login').remove();

// }

$(function(){
    var textfield = $("input[name=name]");
                $('button[type="submit"]').click(function(e) {
                    // e.preventDefault();
                    
                    if (textfield.val() != "" && $("input[name=password]").val()!="") {
                        //$("body").scrollTo("#output");

                        sucessLogin(textfield.val());

                        //show avatar
                        // $(".avatar").css({
                        //     "background-image": "url('http://api.randomuser.me/0.3.2/portraits/women/35.jpg')"
                        // });
                        // return true;
                        return false;
                    } else {
                        //remove success mesage replaced with error message
                        $("#output").removeClass(' alert alert-success');
                        $("#output").addClass("alert alert-danger animated fadeInUp").html("Enter a username and password");
                        return false;
                    }
                    //console.log(textfield.val());
    
                });
    });
    