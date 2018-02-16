/*globals $, SimpleStorage, document*/
import { default as secrets } from 'secrets.js-grempe';
import { default as sjcl, json } from 'sjcl';

//console.log(TimeLockService.options.address);

var addToLog = function(id, txt) {
    $(id + " .logs").append("<br>" + txt);
  };

function createRandomPassword(textToDealWith) {
  sjcl.random.startCollectors();
    console.log('fitna');
    $("body").on('mousemove',function(e) {
        console.log('doing');
        console.log(sjcl.random.getProgress(8));
        sjcl.random.addEntropy(e.pageX,2048, "mouse");
        if(sjcl.random.isReady(8) === 2) {
        console.log('done');
        sjcl.random.stopCollectors();
        var randomArray = new Array;
        var stringPass = "";
        randomArray = sjcl.random.randomWords(5,8);
        console.log(sjcl.random.randomWords(5,8));
        $("body").unbind("mousemove");
        randomArray.forEach(function(element) {
            stringPass += Math.abs(element).toString(16); 
        });
          afterPassCreation(stringPass, textToDealWith);
        }
    });
 }

function encryptText(inputText, password, mySalt) {
  var salt = btoa(mySalt);
  var options = {
      mode : "ccm",
      iter: 1000,
      ks:128,
      ts:64,
      v: 1,
      cipher:"aes",
      adata:"",
      salt: salt
  };
  var encryptedText = sjcl.encrypt(password, inputText, options);
    var parsedMessage = JSON.parse(encryptedText);
    var prop;
    for(prop in options) {
        delete parsedMessage[prop];
    };
    var encryptedTextNoParameters = JSON.stringify(parsedMessage);
    return encryptedTextNoParameters;
}

function decryptText(encryptedText, password, mySalt) {
  var parsedEncMessage = JSON.parse(encryptedText);
  var salt = btoa(mySalt);
  var options = {
    mode : "ccm",
    iter: 1000,
    ks:128,
    ts:64,
    v: 1,
    cipher:"aes",
    adata:"",
    salt: salt
  }
  jQuery.extend(parsedEncMessage,options);
  var messageWithParams = JSON.stringify(parsedEncMessage);
  var decreptedMessage = sjcl.decrypt(password, messageWithParams);
  return decreptedMessage;
}

function parseIPFSText(IPFSContent) {
  var content= IPFSContent.slice(5, -3);
  return content;
}

function loadingToggle(bool) {
  if (bool) {
    $("#loading").css('display', 'block');
    $("#section-2").css('opacity','0.5');
    $("#section-4").css('opacity','0.5');
  } else {
    $("#section-2").css('opacity','1');
    $("#section-4").css('opacity','1');
    $("#loading").css('display', 'none');
  }
    
}
  // ===========================
  // Blockchain example
  // ===========================
  var value;
  
  $(document).ready(function() {
    loadingToggle(false);
    $("#text-title").css('visibility','hidden');
    $("#box-create-section #seal").prop('disabled', true);
    $("#box-create-section #upload").prop('disabled', true);
    $("#box-create-section #box-id").keyup(function(){
      console.log("u pressed");
      var sendObject = {};
      sendObject.senderAddress = web3.eth.defaultAccount;
      sendObject.boxId = parseInt($("#box-create-section #box-id").val().trim());
      var jsonString = JSON.stringify(sendObject);
      var XHR = new XMLHttpRequest();
      XHR.open('POST', 'http://localhost:3000/checkbox');
      XHR.setRequestHeader('Content-Type','application/json');
      console.log(jsonString);
      XHR.send(jsonString);
      XHR.onreadystatechange = function() {
        if (XHR.readyState === 4) {
          console.log("response", XHR.response);
          if(XHR.response == 200) {
            $("#box-create-section #seal").prop('disabled', false);
            $("#box-create-section #upload").prop('disabled', false);
            // return;
          } 
          if(XHR.response == 100) {
            $("#box-create-section #seal").prop('disabled', true);
            $("#box-create-section #upload").prop('disabled', false);
            // return;
          } 
          if(XHR.response == 404) {
            $("#box-create-section #seal").prop('disabled', true);
            $("#box-create-section #upload").prop('disabled', true);
            // return;
          } 
        }
      };
    });

    
    $("#box-create-section #create-box").click(function() {
      loadingToggle(true);
      var member1 = $("#box-create-section #member1").val().trim();
      var dateLock = $("#box-create-section #open-date").val();
      var creatorEmail = $("#box-create-section #creator-email").val();
      var numberOfKeepers = parseInt($("#box-create-section #number-keepers").val().trim());
      console.log(typeof dateLock);
      dateLock = new Date(dateLock).getTime();
      dateLock = Math.floor(dateLock / 1000);
      console.log(numberOfKeepers);
      var nowDate = Date.now();
      var numberOfYears = ((dateLock*1000) - nowDate) / 31556926000;
      numberOfYears = Math.round(numberOfYears);
      numberOfYears = Math.abs(numberOfYears);
      console.log(numberOfYears, "Years");

      var gasPrice = 300000 * numberOfKeepers;
      var myPrice = 214521 * numberOfYears;
      console.log(gasPrice);
      var price = myPrice + gasPrice;
      var cost = web3.utils.toWei((price * 51), 'gwei');
      // var cost = web3.utils.toWei(1, 'ether');
      console.log(cost , "cost");
      // If web3.js 1.0 is being used
      if (EmbarkJS.isNewWeb3()) {
        console.log(TimeLockService.options.address);
        TimeLockService.methods.newCapsule(dateLock, numberOfKeepers).send({from: web3.eth.defaultAccount, value : cost}).then(function(capsule) {
          console.log(capsule);
          console.log(capsule.events.NewCapsuleEvent.returnValues);
          $("#box-create-section #box-id").val(capsule.events.NewCapsuleEvent.returnValues.capsuleId);
          var sendObject = capsule.events.NewCapsuleEvent.returnValues;
          sendObject.numberOfYears = numberOfYears;
          sendObject.groupMembers = member1.split(',');
          sendObject.groupMembers.forEach(function(member) {
            member1.trim();
          });
          sendObject.groupMembers.push(web3.eth.defaultAccount);
          sendObject.email = creatorEmail;
          var jsonString = JSON.stringify(sendObject);
          var XHR = new XMLHttpRequest();
          XHR.open('POST', 'http://localhost:3000/boxcreation');
          XHR.setRequestHeader('Content-Type','application/json');
          console.log(jsonString);
          XHR.send(jsonString);
          XHR.onreadystatechange = function() {
            if (XHR.readyState === 4) {
              console.log("response", XHR.response);
              if(XHR.response) {
                loadingToggle(false);
                $("#box-create-section #upload").prop('disabled', false);
              }
            }
          };
        });
        addToLog("#box-create-section", "SimpleStorage.methods.set(value).send({from: web3.eth.defaultAccount})");
      } else {
        SimpleStorage.set(value);
        KeyLock.methods.addKeeperAddress();
        addToLog("#box-create-section", "SimpleStorage.set(" + value + ")");
      }
    });
    $("#box-create-section #upload").click(function() {
      loadingToggle(true);
      var stringValue = $("#box-create-section #dataToBeSent").val();
      var boxId = $("#box-create-section #box-id").val().trim();
      console.log(stringValue); 
      
      var sendObject = {data : stringValue, senderAddress : web3.eth.defaultAccount, boxId : boxId};
          var jsonString = JSON.stringify(sendObject);
          var XHR = new XMLHttpRequest();
          XHR.open('POST', 'http://localhost:3000/addData');
          XHR.setRequestHeader('Content-Type','application/json');
          console.log(jsonString);
          XHR.send(jsonString);
          XHR.onreadystatechange = function() {
            if (XHR.readyState === 4) {
              console.log("response", XHR.response);
              if(XHR.response) {
                window.setTimeout( function(){
                  loadingToggle(false);
                },4000);
                $("#box-create-section #seal").prop('disabled', false);
              }
            }
          };
    });
    $("#box-create-section #seal").click(function() {
      loadingToggle(true);
      var boxId = $("#box-create-section #box-id").val().trim();
      console.log("3emel she?")
      var sendObject = {senderAddress : web3.eth.defaultAccount, boxId : boxId};
          var jsonString = JSON.stringify(sendObject);
          var XHR = new XMLHttpRequest();
          XHR.open('POST', 'http://localhost:3000/sealbox');
          XHR.setRequestHeader('Content-Type','application/json');
          console.log(jsonString);
          XHR.send(jsonString);
          XHR.onreadystatechange = function() {
            console.log(XHR.response);
            if (XHR.readyState === 4) {
              window.setTimeout( function(){
                loadingToggle(false);
              },4000);
              console.log("response", XHR.response);
            }
          };
    });
  });
  // ===========================
  // Storage (IPFS) example
  // ===========================

  $(document).ready(function() {
    $("#add-keeper-section #apply-keeper").click(function() {
      var value = $("#add-keeper-section #keeper-email").val().trim();
      var sendObject = {};
          sendObject.email = value;
          sendObject.keeperAddress = web3.eth.defaultAccount;
          var jsonString = JSON.stringify(sendObject);
          var XHR = new XMLHttpRequest();
          XHR.open('POST', 'http://localhost:3000/addnewkeeper');
          XHR.setRequestHeader('Content-Type','application/json');
          console.log(jsonString);
          XHR.send(jsonString);
          XHR.onreadystatechange = function() {
            if (XHR.readyState === 4) {
              console.log("response", XHR.response);
            }
          };
    });
  });
  
  // ===========================
  // Communication (Whisper) example
  // ===========================
  $(document).ready(function() {
    
     $("#open-box-section #submitkey").click(function() {
      var secretKey = $("#open-box-section #secret-key").val().trim();
      console.log(secretKey);
      var contractAddress = $("#open-box-section #contract-address").val().trim();
      if (EmbarkJS.isNewWeb3()) {
        var value = $("#open-box-section #submitkey").val().trim();
        TimeLock.options.address = contractAddress;
        TimeLock.methods.getLockedWei().call(function(err, value) {
          console.log(value);
        });
        TimeLock.methods.getKeeperAddress().call(function(err, value) {
          console.log(value);
        });
        TimeLock.methods.getTimeTillOpen().call(function(err, value) {
          console.log(value);
        });
        TimeLock.methods.getKey().call(function(err, value) {
          console.log(value);
        });
        TimeLock.methods.getCurrentTime().call(function(err, value) {
          console.log(value);
        });
        TimeLock.methods.releaseKey(secretKey).estimateGas({from: web3.eth.defaultAccount}).then(function(gasEstimate){
          console.log(gasEstimate);
          TimeLock.methods.releaseKey(secretKey).send({from: web3.eth.defaultAccount, gas: gasEstimate + 10000}).then(function(contract){
            console.log(contract);
          });
        });
        
        addToLog("#box-create-section", "SimpleStorage.methods.get(console.log)");
      } else {
      addToLog("#open-box-section", "EmbarkJS.Messages.sendMessage({topic: '" + channel + "', data: '" + message + "'})");
      }
    });
    $("#open-box-section #unlock-box").click(function() {
      loadingToggle(true);
      var boxHash = $("#open-box-section #details").val().trim();
      if (EmbarkJS.isNewWeb3()) {
        console.log("fet lahon")
        EmbarkJS.Storage.get(boxHash).then(function(content, err) {
          console.log(content);
          if(err) console.log("error");
          console.log(content);
          if(!content) console.log("no result");
          var ipfsObject = JSON.parse(parseIPFSText(content));
          var secretShareArray = [];
          var promises = []
            ipfsObject.keeperContracts.forEach(function(contractAddress){
              TimeLock.options.address = contractAddress;
              var promise = TimeLock.methods.getKey().call(function(err, value) {
                console.log(value);
                if(value != 0)
                secretShareArray.push(value);
                console.log(value);
              }); 
              promises.push(promise);
            });
            Promise.all(promises).then(function(){
              console.log(secretShareArray);
              var comb = secrets.combine(secretShareArray);  
              var pass = secrets.hex2str(comb);
              console.log("this is :"+pass);
              console.log(ipfsObject.data);     
              var boxContent = sjcl.decrypt(pass,ipfsObject.data);
              console.log(sjcl.decrypt(pass,ipfsObject.data));
              loadingToggle(false);
              $("#text-title").css('visibility','visible');
              $("#box-text").text(boxContent);
            });
          addToLog("#add-keeper-section", "EmbarkJS.Storage.get('" + value + "').then(function(content) { })");
        })
        .catch(function(err) {
          if(err){
            console.log("IPFS get Error => " + err.message);
          }
        });
        addToLog("#box-create-section", "SimpleStorage.methods.get(console.log)");
      } else {
      addToLog("#open-box-section", "EmbarkJS.Messages.sendMessage({topic: '" + channel + "', data: '" + message + "'})");
      }
    });  
  });
  