'use strict'

const Hapi = require('hapi');
const Web3 = require('web3');
const EmbarkJS = require('embarkjs');

TimeLock = new EmbarkJS.Contract({abi: [{"constant":true,"inputs":[],"name":"getLockedAmmount","outputs":[{"name":"retVal","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getTimeTillOpen","outputs":[{"name":"retVal","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"lockAmmount","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":true,"inputs":[],"name":"getKeeperAddress","outputs":[{"name":"retVal","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getLockedWei","outputs":[{"name":"retVal","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_secretKey","type":"string"}],"name":"releaseKey","outputs":[{"name":"retVal","type":"string"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_owner","type":"address"},{"name":"_keeper","type":"address"},{"name":"_lockUntill","type":"uint256"}],"payable":true,"stateMutability":"payable","type":"constructor"},{"payable":true,"stateMutability":"payable","type":"fallback"}], address: undefined, code: '60606040526040516060806103ff83398101604052808051919060200180519190602001805160018054600160a060020a03968716600160a060020a03199182161790915560008054959096169416939093179093555042600355600255506103928061006d6000396000f300606060405236156100755763ffffffff7c0100000000000000000000000000000000000000000000000000000000600035041663143feee0811461007b578063236b29a8146100a057806365c8c440146100b3578063bbc9e99a146100bd578063dff632cd146100ec578063faf6c341146100ff575b34600555005b341561008657600080fd5b61008e6101c7565b60405190815260200160405180910390f35b34156100ab57600080fd5b61008e6101ce565b6100bb6101d4565b005b34156100c857600080fd5b6100d06101da565b604051600160a060020a03909116815260200160405180910390f35b34156100f757600080fd5b61008e6101e9565b341561010a57600080fd5b61015060046024813581810190830135806020601f820181900481020160405190810160405281815292919060208401838380828437509496506101f795505050505050565b60405160208082528190810183818151815260200191508051906020019080838360005b8381101561018c578082015183820152602001610174565b50505050905090810190601f1680156101b95780820380516001836020036101000a031916815260200191505b509250505060405180910390f35b6005545b90565b60025490565b34600555565b600054600160a060020a031690565b600160a060020a0330163190565b6101ff6102bc565b60005433600160a060020a039081169116141561022b5760048280516102299291602001906102ce565b505b4260025411156102a957600054600160a060020a039081169030163180156108fc0290604051600060405180830381858888f19350505050151561026e57600080fd5b60408051908101604052600881527f5472616e73666572000000000000000000000000000000000000000000000000602082015290506102b7565b600154600160a060020a0316ff5b919050565b60206040519081016040526000815290565b828054600181600116156101000203166002900490600052602060002090601f016020900481019282601f1061030f57805160ff191683800117855561033c565b8280016001018555821561033c579182015b8281111561033c578251825591602001919060010190610321565b5061034892915061034c565b5090565b6101cb91905b8082111561034857600081556001016103525600a165627a7a72305820a7466091fb369dad2517dd19c4ab3adcd5bccc7e872ac05debc5bf1c29d041bb0029', gasEstimates: {"creation":[80923,182800],"external":{"":20194,"getKeeperAddress()":20042,"getLockedAmmount()":20042,"getLockedWei()":20042,"getTimeTillOpen()":20042,"lockAmmount()":20152,"releaseKey(string)":null},"internal":{}}});


function web3Default() {
    // web3 = new Web3();
    if (typeof web3 !== 'undefined') {
        var web3 = new Web3(web3.currentProvider);
        console.log("Mist");
    } else {
        var web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
    }
    web3.eth.defaultAccount = "0xF9F7386F7Bc4Aa841c6E570eAaF62eEef71b0B4C";
    var defaultAccount = web3.eth.defaultAccount;
    console.log(defaultAccount);
    console.log(web3.isConnected());
    console.log(web3.eth.accounts);
    TimeLock.deploy([defaultAccount, defaultAccount, 100]);
    TimeLock.methods.getLockedAmmount().call(function(err, value) {
        console.log(value);
      });
}

const server = Hapi.Server({
    host: 'localhost',
    port: 3000
}); 

server.route({
    method: 'GET',
    path: '/',
    handler: function (request, h) {
        web3Default();
        return 'Hello World';
    }
});

async function start() {

    try {
        await server.start;
    } catch (err) {
        console.log(err);
        process.exit(1);
    }

    console.log('Server running ar:', server.info.uri);
}

server.start();

