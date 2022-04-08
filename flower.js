
class Flower {
  constructor(contf,img,csetup,cfoto,imgsize) {
    this.contf=contf
    this.id=contf
    this.inside=false
    this.shape=createGraphics(csetup.W, csetup.W, WEBGL); 
    this.contf=contf
    this.posx=imgsize.posx
    this.posy=imgsize.posy
    this.w=csetup.W
    this.img=img
    this.csetup=csetup
    this.radius = csetup.W;
    this.cfoto=cfoto
    this.centerx = cfoto.x;
    this.centery = cfoto.y;
    this.offset=cfoto.o;
    this.diagonal2=cfoto.d;
    this.slices=cfoto.n;
    this.angle = (2 * PI) / this.slices;
    this.angle2 = 0;
    this.sangle = this.angle / 2;
    this.aini2 = 0 + sangle * 1;
    this.propor=imgsize.propor
    this.cursor=imgsize.cursor
    this.ipcx=this.centerx*this.propor+this.cursor/2
    this.ipcy=this.centery*this.propor-this.cursor/2
    this.bills=[0,1,2,5,10,20,50]
  
  }

  change(contf,cfoto) {
    this.id=contf
    this.contf=contf
    this.cfoto=cfoto
    this.centerx = this.cfoto.x;
    this.centery = this.cfoto.y;
    this.radius = this.csetup.W;
    this.offset = this.cfoto.o;
    this.diagonal2 = this.cfoto.d;
    this.slices=this.cfoto.n;
    this.angle = (2 * PI) / this.slices;
    this.angle2 = 0;
    this.sangle = this.angle / 2;
    this.aini2 = this.sangle;
    this.ipcx=this.centerx*this.propor+this.cursor/2
    this.ipcy=this.centery*this.propor-this.cursor/2
  }

  display() {
    for (var i = 0; i < this.slices * 2; i++) {
      push();
      this.module();
      if (i % 2 == 1) {
        this.shape.scale(-1, 1);
        this.shape.rotate(PI + this.angle2 + this.angle);
        this.shape.rotate(this.angle2);
        translate(this.csetup.W / 2, this.csetup.W / 2);
        this.angle2 += this.angle * 1.5;
        image(this.shape, this.posx, this.posy);
      } else {
        scale(1, 1);
        this.shape.rotate(this.angle2);
        translate(this.csetup.W / 2, this.csetup.W / 2);
        this.angle2 += this.angle * 0.5; 
        image(this.shape, this.posx, this.posy);
      }
       
      pop();

    }
    
  } //end display

  module(){
    this.shape.beginShape(TRIANGLES);
    this.shape.texture(this.img);
    this.shape.noStroke();
    this.shape.imageMode(CENTER);
    this.shape.vertex(0, 0, this.centerx, this.centery);
    this.shape.vertex(this.radius, 0, this.centerx + this.diagonal2, this.centery);
    this.shape.vertex(
      0 + this.radius * cos(this.angle),
      0 + this.radius * sin(this.angle),
      this.centerx + this.diagonal2 * cos(this.sangle + this.offset),
      this.centery + this.diagonal2 * sin(this.sangle + this.offset)
    );

    this.shape.endShape(CLOSE);
  }//end module
  
  drawText(cipher,expiration,symbol,labelx){
    imageMode(CENTER);
    var postx=this.w/5
    var postx2=this.w/8
    var postx3=this.w/16
    push()
      translate(this.posx+postx,this.posy+postx)
       scale(0.35);
      //this.shape.tint(20, 200, 20);
       image(this.shape,0,0)
   pop()
   fill(155,80)
    noStroke()
    //circle(this.posx+50,this.posy+50,90)
    textSize(postx);
    textStyle(BOLD)
    textAlign(CENTER, CENTER);
    fill(0)
    //text(this.bills[this.id],this.posx+postx,this.posy+postx)
    text(cipher,this.posx+postx,this.posy+postx)
    fill(255,255,244)
    //text(this.bills[this.id],this.posx+postx-2,this.posy+postx-2)
    text(cipher,this.posx+postx-2,this.posy+postx-2)

    textStyle(ITALIC)
    textSize(postx*0.7);
    fill(0)
    text(symbol,this.posx+postx,this.posy+postx*1.8)
    fill(255,255,244)
    text(symbol,this.posx+postx-2,this.posy+postx*1.8-2)

    fill(255,255,200,130)
    rectMode(CORNERS)
    rect(this.posx+this.w*0.5+postx3, this.posy+this.w*0.5+postx3, this.posx+this.w-postx3, this.posy+this.w-postx3, postx3);
    //rect(this.posx+this.radio/4,this.posy+this.radio/4,this.radio/4,this.radio/4)

    textStyle(ITALIC)
    textSize(postx3);
    fill(0)
    if(labelx){
    text('Expiration\ndate',this.posx+this.w*0.75,this.posy+this.w*0.5-postx3)
    fill(255,255,244)
    text('Expiration\ndate',this.posx+this.w*0.75,this.posy+this.w*0.5-postx3-2)
   }

    var m=month()
    var y=year()
    textStyle(BOLD)
    textSize(postx2);
    fill(27,20,0)
    text(expiration,this.posx+this.w*0.75,this.posy+this.w*0.5+postx*1.3)
    //fill(27,20,0)
    //text(m+'\n'+y,this.posx+this.w*0.75,this.posy+this.w*0.5+postx*1.5-2)

  }

  cssChange(){
    contdiv.html(this.contf)
    ipoint.style('left', this.ipcx+'px')
    ipoint.style('top',  this.ipcy+'px')
  }
  clicked(){
    this.isInside()
    if (this.inside) {
        newi(this.id)
        redraw()
    }
  }
   isInside(){
     if ((mouseX > this.posx) && (mouseX < this.posx+this.w) && (mouseY > this.posy) && (mouseY < this.posy+this.w)) {
      this.inside= true
     }else{
      this.inside=false
     }
   }
  
}