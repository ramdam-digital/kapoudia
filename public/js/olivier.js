function olivier(){
    setInterval(function(){
        $(".ecologique").animate({height: "show", width: "show"}, 1000, "easeOutQuart");
    },1000);
    setInterval(function(){
        $(".ecologique span").slideDown();
    },2000);

    setInterval(function(){
        $(".adopter").animate({height: "show", width: "show"}, 1000, "easeOutQuart");
    },3000);
    setInterval(function(){
        $(".adopter span").slideDown();
    },4000);

    setInterval(function(){
        $(".offrir").animate({height: "show", width: "show"}, 1000, "easeOutQuart");
    },5000);
    setInterval(function(){
        $(".offrir span").slideDown();
    },6000);

    setInterval(function(){
        $(".visiter").animate({height: "show", width: "show"}, 1000, "easeOutQuart");
    },7000);
    setInterval(function(){
        $(".visiter span").slideDown();
    },8000);
}