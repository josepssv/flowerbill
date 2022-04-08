

var angle;
var angle2;
var radius;
var shape;
var shape2;
var offset = 0;
var factor;

var aangle1 = 0;
var aangle2 = 0;
var sangle = 0;
var aini1 = 0;
var aini2 = 0;
var offset = 0;
var centerx = 0;
var centery = 0;
var diagonal2 = 100;
var W = 400;
var H = 400;
var clickCount = 1;
var contSaved = 0;
var coord;
var inpt;
var contdiv;
var showr,showl,reloadi,savef,inum
var contf=1

var cfoto=[]
var slices = 24;
var img;
var started=false
var imgsize={w:10,h:10,propor:1,cursor:40,posx:0,posy:0}
var flower=[]
var flower1
var flower2
var hash=''
var billmax=2

url=location.href.split('?')
h1=url[1].split('id=')
hash=h1[1]

$(document).ready(function(){
  //hash=GetURLParameter(window.location)
  
  if(hash.length==50) {
    $.post('viewer.php', { name:'read', n:0, hash:hash } ,function(data){
       cfoto=JSON.parse(data)
       slices=cfoto[0].n 
       //inpt.value(JSON.stringify(cfoto))
       started=true
       img = loadImage('upload/'+cfoto[0].img+'.jpg');
  
    });
      setTimeout(function() {
         setup1()
        },2000);
   } else {
   document.write('<h3>We need a collectio billet id</h3>')
}
});



function newi(n){
  cfoto[0].n=slices
  ix=parseInt(Math.random()*(cfoto[0].w-diagonal2))
  iy=parseInt(Math.random()*(cfoto[0].h-diagonal2))
  cfoto[n]={"x":ix,"y":iy}
  inpt.value(JSON.stringify(cfoto))

}



function preload() {

 //img = loadImage(cfoto[0].img); 
}

function setup1() {
   cfoto[0].w=img.width
   W = cfoto[0].W;
   H= cfoto[0].W;
   cfoto[0].h=img.height 
   diagonal2 = cfoto[0].d;
   offset=0
   if(cfoto[0].o!=0){
      offset=PI/cfoto[0].o 
   }
   //preload()
   pp=1/2 
   imgsize={w:img.width*pp,h:img.height*pp,propor:pp,cursor:40,posx:0,posy:0}
   contf=1
   billmax=cfoto.length-1

   noLoop();
   image(img,0,0)
  nh=3
  margin=10 
  imgw=cfoto[0].W
  marginx = margin*(nh+1)
  nrows = ceil((cfoto.length-1)/3)
  marginy = margin*(nrows+1)
  createCanvas(imgw*nh+marginx,imgw*nrows+marginy);

  factor = 2; 
  angle = (2 * PI) / slices;
  angle2 = (2 * PI) / slices;
  sangle = angle / 2;
  aini2 = 0 + sangle * 1;
  aangle2 = 0;
  radius = min(W, H); //2*4.9;
  //angleMode(RADIANS);
  imageMode(CENTER);
  flower=[]  
  //alert(cfoto)
  //cfoto[0].W=200
  var hpos=0
  var contx=1
  var conty=1
  imgsize.posx=0+margin
  imgsize.posy=hpos+margin
  billmax=1
  //alert(cfoto.length-1+' '+cfoto[0].id)
  if(cfoto.length>0){
    billmax=cfoto.length-1
  }
  //cfoto[0].W=200
  for(var a=1;a<=billmax;a++){
    flower[a]=new Flower(a,img,cfoto[0],cfoto[a],imgsize); 
    if(a%3==0 && a>1){
      hpos+=cfoto[0].W; 
      conty++
      imgsize.posy=hpos+margin*conty; 
      contx=0
    }
    imgsize.posx = cfoto[0].W*contx+margin*contx+margin
    contx++
  }

  setTimeout(function() {
    redraw();
  },2000);
 // redraw()
}

function draw(){

  
  if (started && img.width > 12) {
    background(44, 44, 44);
    for(var a=1;a<=billmax;a++){
        flower[a].change(a,cfoto[a])
        flower[a].display()
         flower[a].drawText()
        //text(a,flower[a].posx+100,flower[a].posy+100)
    }
    //flower1.cssChange()
    noLoop()
  } else {
        background(100);
        image(img, 0, 0, width + frameCount * 1.8, height + frameCount * 1.8)
        fill(100 + frameCount, 150)
        textStyle(BOLD)
        rect(0, 0, width, height)
        textAlign(CENTER, CENTER)
        fill(0)
        text('loading \n FlowerBill \n ' + frameCount, width / 2, height / 2)
    }
}

function linkto(){

}

function chinum(){
  slices=parseInt(inum.value())
  angle = (2 * PI) / slices;
  angle2 = (2 * PI) / slices;
  sangle = angle / 2;
  aini2 = 0 + sangle * 1;
  
}

function toreload(){
  chinum()
  newi(contf)
  redraw();
}

function mousePressed() {
    if (started) {
        for (var a = 1; a <= billmax; a++) {
            flower[a].clicked();
        }
    }

}


function mouseMoved() {
    if (started) {
        for (var a = 1; a <= billmax; a++) {
            flower[a].isInside();
            if (flower[a].inside) {
                cursor(HAND)
                //contdiv.html(bills[a])
                break
            } else {
                cursor(ARROW)
            }

        }
    }

}
