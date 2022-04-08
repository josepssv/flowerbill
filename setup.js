 
var bankCreated='March 2022'
///////////////////
var limitBankFlowers = 600
var limitWalletFlowers=30
///////////////////
///////////////////
//repeat erase
 var limitFlowers = 30
 var limitAmount = limitFlowers * 50
 ///////////////////
var limitWallets=limitBankFlowers/limitWalletFlowers
// Should be limitBankAmout -- to change
var limitAmount = limitBankFlowers * 50
var limitWalletAmount = limitWalletFlowers*50
var expirationDate=[]
//var urln=location.href
var urln = window.location.href.replace(/\/$/, '');
var bankName = urln.substr(urln.lastIndexOf('/') + 1);

var bank={name:bankName,created:bankCreated,flowers:0,amount:0,flowersLimit:0,amountLimit:0,remainFlowers:0,remainAmount:0,nwallets:0,limitWallets:limitWallets,expirationMonths:2}
bank.flowersLimit=limitBankFlowers
bank.amountLimit=limitAmount
bank.remainFlowers=bank.flowersLimit-0
bank.remainAmount=bank.amountLimit-0
var personal={flowers:0,amount:0,flowersLimit:0,amountLimit:0,remainFlowers:0,remainAmount:0}
personal.flowersLimit=limitWalletFlowers
personal.amountLimit=limitWalletAmount
personal.remainFlowers=personal.flowersLimit-personal.flowers
personal.remainAmount=personal.amountLimit-personal.amount

var keybank = location.href.substring(0,location.href.lastIndexOf('/') + 1);
var par = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 36, 38, 40]
function makedate(nmonths){
    yeh = new Date().getFullYear();
    moh = new Date().getMonth();
    moho=moh+nmonths
    if(moho > 12){ moho=moho-12; yeh+=1}
    let d = new Date(yeh, moho);
    let ind=new Date(yeh,moh)
    let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
    let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
    var exp1= `${mo}`;
    var exp2= `${ye}`;
    let inye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(ind);
    let inmo = new Intl.DateTimeFormat('en', { month: 'short' }).format(ind);
    var inexp1= `${inmo}`;
    var inexp2= `${inye}`;
    return [exp1,exp2,inexp1,inexp2]
}
  
var expirationDate=makedate(bank.expirationMonths)
var expDate=makedate(bank.expirationMonths)
var exp1=expDate[0]
var exp2=expDate[1]
var inexp1=expDate[2]
var inexp2=expDate[3]

function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

var chords=["4","5","7","9","11","13","64","M","M#5","M#5add9","M13","M13#11","M6","M6#11","M69","M69#11","M7#11","M7#5","M7#5sus4","M7#9#11","M7add13","M7b5","M7b6","M7b9","M7sus4","M9","M9#11","M9#5","M9#5sus4","M9b5","M9sus4","Madd9","Maj7","Mb5","Mb6","Msus2","Msus4","addb9","11b9","13#11","13#9","13#9#11","13b5","13b9","13b9#11","13no5","13sus4","69#11","7#11","7#11b13","7#5","7#5#9","7#5b9","7#5b9#11","7#5sus4","7#9","7#9#11","7#9#11b13","7#9b13","7add6","7b13","7b5","7b6","7b9","7b9#11","7b9#9","7b9b13","7b9b13#11","7no5","7sus4","7sus4b9","7sus4b9b13","9#11","9#11b13","9#5","9#5#11","9b13","9b5","9no5","9sus4","m","m#5","m11","m11A 5","m11b5","m13","m6","m69","m7","m7#5","m7add11","m7b5","m9","m9#5","m9b5","mMaj7","mMaj7b6","mM9","mM9b6","mb6M7","mb6b9","o","o7","o7M7","oM7","sus24","+add#9","madd4","madd9"]
var notesmidi =
        "                     A0 A#0 B0 C1 C#1 D1 D#1 E1 F1 F#1 G1 G#1 A1 A#1 B1 C2 C#2 D2 D#2 E2 F2 F#2 G2 G#2 A2 A#2 B2 C3 C#3 D3 D#3 E3 F3 F#3 G3 G#3 A3 A#3 B3 C4 C#4 D4 D#4 E4 F4 F#4 G4 G#4 A4 A#4 B4 C5 C#5 D5 D#5 E5 F5 F#5 G5 G#5 A5 A#5 B5 C6 C#6 D6 D#6 E6 F6 F#6 G6 G#6 A6 A#6 B6 C7 C#7 D7 D#7 E7 F7 F#7 G7 G#7 A7 A#7 B7 C8";
var notemidi = notesmidi.split(" ");
var soloMelodies = [];


function initSound(chordProgression){
    var chi = [3,4];
    var generatorOptions = {
            raw: true,
            limit: false,
            filter: false,
    };
   var acc = AutoComposerJS.melody.buildSimpleMelodies(
        chordProgression,
        generatorOptions
    );
   var mychords = [];
       
   for (a = 0; a < acc.length; a++) {
            r = acc[a].split(" ");
            mychords = mychords.concat(r);
    }
    var contc = 1;
    for (a = 0; a < mychords.length; a++) {
        toc =  1;
        compass=1
        nr = notemidi.indexOf(mychords[a]);
        mychords[a] += " " + notemidi[nr + chi[0]] + " " +  notemidi[nr + chi[0] + chi[1]];
                // if(toc==1){break}
    }
    
    return mychords    
}

    
function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function randomNumber(min, max) {
    return Math.random() * (max - min) + min;
}

function randomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

window.onkeydown = function(event) {
   if (event.keyCode === 81) {
      alert("This is a test.");
   }
};
function limitch(element,maxch){
    element.value=element.value.replace(/["]/g, '”')
    element.value=element.value.replace(/[']/g, "’")
    if(element.value.length > maxch) {
        element.value = element.value.substr(0, maxch);
    }
}
