pragma solidity ^0.4.10;

contract TimeLock {
  

  struct Rule {
    address keeper;
    address owner;
    uint lockUntill;
    string secretKey;
    bytes32 keyHash;
    uint256 lockedAmmount;
  }

  Rule public lock;

  function TimeLock(address _owner, address _keeper, uint _lockUntill, bytes32 _keyHash) public payable {
    lock = Rule ({
      owner : _owner,
      keeper : _keeper,
      keyHash : _keyHash,
      lockUntill : _lockUntill,
      lockedAmmount : msg.value,
      secretKey : "0"
    });
    
  }

  function () public payable {
      lock.lockedAmmount = msg.value + this.balance;
  }

  function lockAmmount() public payable {
    lock.lockedAmmount = msg.value;
  }

  function releaseKey(string _secretKey) public {
    
    if ( lock.lockUntill < block.timestamp && msg.sender == lock.keeper && keccak256(_secretKey) == lock.keyHash) {
      lock.secretKey = _secretKey;
      lock.keeper.transfer(this.balance); 
    }
  }

  function getKey() public view returns (string retVal) {
    return lock.secretKey;
  }

  function getKeeperAddress() public view returns (address retVal) {
    return lock.keeper;
  }

  function getTimeTillOpen() public view returns (uint retVal) {
    return lock.lockUntill;
  }

  function getLockedWei() public view returns (uint retVal) {
    return this.balance;
  }

  function getCurrentTime() public view returns(uint retVal) {
    return block.timestamp;
  }

  function destroyContract() public {
    if (msg.sender == lock.owner) {
      selfdestruct(lock.owner);
    }
  }
}