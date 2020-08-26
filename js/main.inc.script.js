"use strict"

let leftButton = document.getElementsByClassName('mainPageButton1');
let rightButton = document.getElementsByClassName('mainPagebutton2');

let mainSliders = document.getElementsByClassName('sliderBlock');

for( let i = 0; i < 3; i++ ){
    let sliderChilds = mainSliders[i].childNodes;
    
    let k = 1;
    function leftButton(){
        k--;
        
        if( k < 1 ){
            k = 3;
        }
        if( k > 3 ){
            k = 1;
        }
        
        sliderChilds[3].setAttribute("src", "../img/tourTypesImage" + (i+1) + "_" + k + ".jpg");
    }
    
    function rightButton(){
        k++;
        
        if( k < 1 ){
            k = 3;
        }
        if( k > 3 ){
            k = 1;
        }
        sliderChilds[3].setAttribute("src", "../img/tourTypesImage" + (i+1) + "_" + k + ".jpg");
    }
    
    sliderChilds[1].addEventListener('click', leftButton);
    sliderChilds[5].addEventListener('click', rightButton);
}


