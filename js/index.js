//Animations for .photo
    $(window).on("scroll",()=>{
        let bottom_vh=$(window).scrollTop()+$(window).innerHeight()-100;
        for(let i=0;i<$(".photos_img").length;i++){
            if(bottom_vh>$(".photos_img")[i].offsetTop){
                $(".photos_img img")[i].classList.add("show_img");
            }
            else{
                $(".photos_img img")[i].classList.remove("show_img");
            }
        }

    });

//Animations for .photo