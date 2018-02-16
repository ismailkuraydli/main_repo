pragma solidity ^0.4.10;

contract TimeLockService {
    uint public numberOfCapsules;
    address serviceOwner;
    mapping (uint => Capsule) capsules;
    
    event NewCapsuleEvent(uint capsuleId, address creatorAddress, uint reqKeepers, uint lockUntill);

    struct Capsule {
        address capsuleOwner;
        uint lockUntil;
        uint requiredKeepers;
        uint paidAmmount;
    }
    struct Keeper {
        uint lockedAmmount;
        address contractAddress;
    }
    function TimeLockService() public {
        numberOfCapsules = 0;
        serviceOwner = msg.sender;
    }

    function () public payable {

    }

    function newCapsule (uint256 _lockUntill, uint _requiredKeepers) public payable {
        Capsule memory x;
        x.capsuleOwner = msg.sender;
        x.lockUntil = _lockUntill;
        x.requiredKeepers = _requiredKeepers;  
        x.paidAmmount = msg.value;   
        capsules[numberOfCapsules] = x;
        serviceOwner.transfer(msg.value);
        NewCapsuleEvent(numberOfCapsules, msg.sender, _requiredKeepers, _lockUntill);
        numberOfCapsules++;
    }

    function getTimeUntillOpen(uint _capsuleId) public view returns (uint256 retVal) {
        return capsules[_capsuleId].lockUntil;
    }

    function getNumberOfCapsules() public view returns (uint retVal) {
        return numberOfCapsules;
    }

    function getCapsuleLockUntil(uint _capsuleId) public view returns (uint retVal) {
        return capsules[_capsuleId].lockUntil;
    }

    function getCapsuleOwner(uint _capsuleId) public view returns (address reVal) {
        return capsules[_capsuleId].capsuleOwner;
    }

    function getPaidAmmount(uint _capsuleId) public view returns (uint retVal) {
        return capsules[_capsuleId].paidAmmount;
    }
}