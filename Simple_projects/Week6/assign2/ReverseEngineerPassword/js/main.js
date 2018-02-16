

passwordList = [];
function checkPass( password ) { 
    var total = 0 ;
    var charlist = "abcdefghijklmnopqrstuvwxyz" ;
    for ( var i = 0; i < password.length; i++) {
        var countone = password.charAt (i) ;
        var counttwo = ( charlist.indexOf( countone )) ;
        counttwo++; 
        total *= 17;
        total += counttwo; 
    }
    if ( total == 248410397744610 ) { 
        //setTimeout ("location.replace('index.php?password="+password + "' ) ; " , 0)
        console.log("true");
        passwordList.push(password);
    }
    else { 
        //alert ("Sorry, but the password was incorrect." ) ;
        console.log("false");
    } 
}

var charlist = "abcdefghijklmnopqrstuvwxyz" ;
/**
 * Check if n is an integer
 * @param {*int} n
 * @param {*float} n 
 */
function isInt(n) {
    return n % 1 === 0;
}
total = 248410397744610;
j=1;
reversePassword = [];

passwordTemp = "";
/**
 * Function to produce all passwords for the giver algorithm
 * @param {*int} totalTemp 
 * @param {*string} passwordTemp 
 */
function reverseEngine(totalTemp,passwordTemp) {
    for( var i = 0; i < 27; i++) {
        totalBeforeLast = totalTemp - i;
        if(totalBeforeLast == 0) {
            passwordTemp = charlist.charAt (i-1) + passwordTemp;
            reversePassword.push(passwordTemp);
            passwordTemp = "";
            break;
        }
        totalBeforeLast = totalBeforeLast/17;
        if(isInt(totalBeforeLast)) {
            passwordTemp1 = charlist.charAt (i-1) + passwordTemp;
            reverseEngine(totalBeforeLast,passwordTemp1);
        }
    }
    return;
}
reverseEngine(total,passwordTemp);
console.log(reversePassword);
sectionHtml = document.getElementById('main');
time = 0;
reversePassword.forEach(element => {
    checkPass(element);
    passwordFound = document.createElement('h1');
    passwordFound.innerHTML = element;
    //appendpass = sectionHtml.appendChild(passwordFound);
    timer = time*500;
    window.setTimeout(sectionHtml.appendChild(passwordFound),timer);
    time++;
});


console.log(passwordList);

