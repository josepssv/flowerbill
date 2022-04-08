
class Flower {
  constructor(p,contf,img,csetup,cfoto,imgsize) {
    this.p=p
    this.contf=contf
    this.id=contf
    this.inside=false
    this.shape=p.createGraphics(csetup.W, csetup.W, p.WEBGL); 
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
    this.angle = (2 * p.PI) / this.slices;
    this.angle2 = 0;
    this.sangle = this.angle / 2;
    this.aini2 = 0 + this.sangle * 1;
    this.propor=imgsize.propor
    this.cursor=imgsize.cursor
    this.ipcx=this.centerx*this.propor+this.cursor/2
    this.ipcy=this.centery*this.propor-this.cursor/2
    this.bills=[0,1,2,5,10,20,50]
    this.postx=this.w/5
    this.postx2=this.w/8
    this.postx3=this.w/16
    this.solo=false
    this.base={cx:this.w/2,cy:this.w/2,radius:40,angle:0}
  }

  change(contf,cfoto) {
    //this.p.background(144);
    this.id=contf
    this.contf=contf
    this.cfoto=cfoto
    this.centerx = this.cfoto.x;
    this.centery = this.cfoto.y;
    this.radius = this.csetup.W;
    this.offset = this.cfoto.o;
    this.diagonal2 = this.cfoto.d;
    this.slices = this.cfoto.n;
    this.angle = (2 * this.p.PI) / this.slices;
    this.angle2 = 0;
    this.sangle = this.angle / 2;
    this.aini2 = this.sangle;
    this.ipcx = this.centerx*this.propor+this.cursor/2
    this.ipcy = this.centery*this.propor-this.cursor/2
  }

  display() {

    for (var i = 0; i < this.slices * 2; i++) {
      this.p.push();
      this.module();
      if (i % 2 == 1) {
        this.shape.scale(-1, 1);
        this.shape.rotate(this.p.PI + this.angle2 + this.angle);
        this.shape.rotate(this.angle2);
        this.p.translate(this.csetup.W / 2, this.csetup.W / 2);
        this.angle2 += this.angle * 1.5;
        this.p.image(this.shape, this.posx, this.posy);
      } else {
        this.p.scale(1, 1);
        this.shape.rotate(this.angle2);
        this.p.translate(this.csetup.W / 2, this.csetup.W / 2);
        this.angle2 += this.angle * 0.5; 
        this.p.image(this.shape, this.posx, this.posy);
      }
       
      this.p.pop();

    }
    
  } //end display

  module(){
    this.shape.beginShape(this.p.TRIANGLES);
    this.shape.texture(this.img);
    this.shape.noStroke();
    this.shape.imageMode(this.p.CENTER);
    this.shape.vertex(0, 0, this.centerx, this.centery);
    this.shape.vertex(this.radius, 0, this.centerx + this.diagonal2, this.centery);
    this.shape.vertex(
      0 + this.radius * this.p.cos(this.angle),
      0 + this.radius * this.p.sin(this.angle),
      this.centerx + this.diagonal2 * this.p.cos(this.sangle + this.offset),
      this.centery + this.diagonal2 * this.p.sin(this.sangle + this.offset)
    );

    this.shape.endShape(this.p.CLOSE);
  }//end module
  
  drawText(am,expiration){
    this.p.imageMode(this.p.CENTER);
    var postx=this.w/5
    var postx2=this.w/8
    var postx3=this.w/16
    this.p.push()
      this.p.translate(this.posx+postx,this.posy+postx)
       this.p.scale(0.35);
      //this.shape.tint(20, 200, 20);
       this.p.image(this.shape,0,0)
   this.p.pop()
   this.p.fill(155,80)
   this.p.noStroke()
    //circle(this.posx+50,this.posy+50,90)
    this.p.textSize(postx);
    this.p.textStyle(this.p.BOLD)
    this.p.textAlign(this.p.CENTER, this.p.CENTER);
    this.p.fill(0)
    this.p.text(am,this.posx+postx,this.posy+postx)
    this.p.fill(255,255,244)
    this.p.text(am,this.posx+postx-2,this.posy+postx-2)

    this.p.textStyle(this.p.ITALIC)
    this.p.textSize(postx*0.7);
    this.p.fill(0)
    this.p.text('f',this.posx+postx,this.posy+postx*1.8)
    this.p.fill(255,255,244)
    this.p.text('f',this.posx+postx-2,this.posy+postx*1.8-2)

    this.p.fill(255,255,200,130)
    this.p.rectMode(this.p.CORNERS)
    this.p.rect(this.posx+this.w*0.5+postx3, this.posy+this.w*0.5+postx3, this.posx+this.w-postx3, this.posy+this.w-postx3, postx3);
    //rect(this.posx+this.radio/4,this.posy+this.radio/4,this.radio/4,this.radio/4)

    this.p.textStyle(this.p.ITALIC)
    this.p.textSize(postx3);
    this.p.fill(0)
    this.p.text('Expiration\ndate',this.posx+this.w*0.75,this.posy+this.w*0.5-postx3)
    this.p.fill(255,255,244)
    this.p.text('Expiration\ndate',this.posx+this.w*0.75,this.posy+this.w*0.5-postx3-2)

    var m=this.p.month()
    var y=this.p.year()
    this.p.textStyle(this.p.BOLD)
    this.p.textSize(postx2);
    this.p.fill(27,20,0)
    this.p.text(expiration,this.posx+this.w*0.75,this.posy+this.w*0.5+postx*1.3)
    //fill(27,20,0)
    //text(m+'\n'+y,this.posx+this.w*0.75,this.posy+this.w*0.5+postx*1.5-2)

  }
  
  textextra(txtx){
    this.p.textStyle(this.p.BOLD)
    this.p.textSize(this.postx2);
    this.p.fill(0,0,0)
    this.p.text(txtx,this.posx+this.w*0.75,this.posy+this.w*0.2)
    this.p.fill(255,255,244)
    this.p.text(txtx,this.posx+this.w*0.75,this.posy+this.w*0.2-2)
  }

  tumb(){
    var tum=this.p.canvas.toDataURL() ;
    return tum
    //return this.p.createImg(tum.data)
    //tum.position(100,200)
  }
  tumb1(){
    this.p.canvas.toDataURL() ;
  }
  pickangle(a){
    this.base.angle=a

  }
  pickposColor(){
    var px = this.base.cx + this.p.cos(this.p.radians(this.base.angle))*this.base.radius;
    var py = this.base.cy + this.p.sin(this.p.radians(this.base.angle))*this.base.radius;
    var pickc=this.p.get(px,py)
    var brg=this.p.brightness(pickc);
    return brg
    //this.p.fill(pickc)
    //this.p.ellipse(px,py,30,30)
  }

}