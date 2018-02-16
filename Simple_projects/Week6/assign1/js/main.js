
/**
 * sets the coordinates of the tiles to strating point
 */
function setInitialPlaces() {
    for(i=0; i< 8; i++ ) {
        setXY(i+1, 0, i);
    }
}
/**
 * sets each rectangle element to appropriate coordinates
 * @param {*int} tileNumber 
 * @param {*int} positionRod 
 * @param {*int} relativePosition 
 */
function setXY(tileNumber, positionRod, relativePosition ) {
    tile = getTileElement(tileNumber);
    posX = 0.5 + (12.5 * relativePosition)+ (positionRod * 250);
    tile.setAttribute("x",posX);
    posY = 258.5 - (25 * relativePosition);
}

/**
 * Algorithm for tower Hanoi starts at n = 0 to 8 tiles 
 * @param {*int} n 
 * @param {*int} fromRod 
 * @param {*int} toRod 
 * @param {*int} auxRod 
 */
function towerOfHonoi(n,fromRod,toRod,auxRod) {
    if(n==8) {
        timeout = timer * 1000;
        window.setTimeout(moveTile,timeout,n,toRod,fromRod);
        timer++;
        return;
    }
    towerOfHonoi(n+1,fromRod,auxRod, toRod);
    timeout = timer * 1000;
    window.setTimeout(moveTile,timeout,n,toRod,fromRod);
    timer++;
    towerOfHonoi(n+1,auxRod,toRod,fromRod);
}
/**
 * moves tile and shadow from one position to another
 * @param {*int} tileNumber 
 * @param {*int} newPosition from 0 to 2
 * @param {*int} oldPosition from 0 to 2
 */
function moveTile(tileNumber,newPosition,oldPosition) {
    numberOftilesOnStack = getRodStack(newPosition);
    tile = getTileElement(tileNumber);
    shadow = getShadowElement(tileNumber);
    xPos = tileXPosition(tile);
    yPos = tileYPosition(tile);
    yPosNew = 258.5 - (25 * numberOftilesOnStack) ;
    xPosNew = xPos + (250* (newPosition - oldPosition));
    move(tile,xPos,-70);
    move(shadow,xPos,-70);
    window.setTimeout(move,666.6666,tile,xPosNew,-70);
    window.setTimeout(move,666.6666,shadow,xPosNew,-70);
    window.setTimeout(move,1000,tile,xPosNew,yPosNew);
    window.setTimeout(move,1000,shadow,xPosNew,yPosNew);
}
/**
 * Gets elemnt according to tile number
 * @param {*int} tileNumber 
 */
function getTileElement(tileNumber) {
    tileId = "tile" + tileNumber;
    var tile = document.getElementById(tileId);
    return tile;
}
/**
 * Gets shadow element according to tile number
 * @param {*int} tileNumber 
 */
function getShadowElement(tileNumber) {
    shadowId = "shadow" + tileNumber;
    var shadow = document.getElementById(shadowId);
    return shadow;
}
/**
 * Moves tile to specified coordinates
 * @param {*int} tile 
 * @param {*float} x 
 * @param {*float} y 
 */
function move(tile, x, y) {
    tile.classList.add('move');
    tile.setAttribute("x",x);
    tile.setAttribute("y",y);
    soundBitNo.play();
}
/**
 * Gets current tiles already stacked on a specific rod
 * @param {*int} rodNumber from 0 to 2
 */
function getRodStack(rodNumber) {
    count = 0
    switch (rodNumber) {
        case 0: 
            for(i=0; i< 8; i++ ) {
                tile = getTileElement(i+1);
                xPos = tileXPosition(tile);
                if(xPos <=  88) {
                    count++;
                }
            }
            break;
        case 1: 
            for(i=0; i< 8; i++ ) {
                tile = getTileElement(i+1);
                xPos = tileXPosition(tile);
                if(xPos <=  338 && xPos >= 250.5) {
                    count++;
                }
            }
            break;
        case 2: 
            for(i=0; i< 8; i++ ) {
                tile = getTileElement(i+1);
                xPos = tileXPosition(tile);
                if(xPos <=  588 && xPos >= 499) {
                    count++;
                }
            }
            break;
    }
    return count;
}
/**
 * Gets current X position  
 * @param {*int} tile tile number
 */
function tileXPosition(tile) {
    return parseInt(tile.getAttribute("x"));
}
/**
 * Gets current Y position  
 * @param {*int} tile tile number
 */
function tileYPosition(tile) {
    return parseInt(tile.getAttribute("y"));
}

/**
 * Main
 */
setInitialPlaces();
soundBitNo = new Audio("bit-no.mp3");
soundYes = new Audio("yes.mp3");
soundWantHim = new Audio("want-him-in-the-games.mp3");
soundMusic = new Audio("tron-music.mp3");
button = document.getElementById("button-play");
button.onclick = function() {
    soundWantHim.play();
    timer = 0;
    window.setTimeout(towerOfHonoi,7000,1,0,2,1); 
    window.setTimeout(soundMusic.play(),8000)
};

button2 = document.getElementById("button-reset");
button2.onclick = function(){
    soundYes.play();
    window.setTimeout(refreshPage,2000);
   
};
function refreshPage() {
    window.location.reload(true);
}
/**
 * FireFox fix
 */
if (typeof InstallTrigger !== 'undefined') {
    firefoxFix = document.getElementById("button-section");
    firefoxFix.style.display = 'none';
    alert("Please use google chrome for a better experience")
    timer = 0;
    towerOfHonoi(1,0,2,1);
}