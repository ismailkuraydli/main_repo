describe("TimeLockService", function() {
    before(function(done) {
      this.timeout(0);
      var contractsConfig = {
        "TimeLockService": {
        }
      };
      EmbarkSpec.deployAll(contractsConfig, done);
    });
  
    it("should set constructor value", function(done) {
        TimeLockService.numberOfCapsules(function(err, result) {
        assert.equal(result.toNumber(), 0);
        done();
      });
    });
    
    it("can create a new capsule", function(done){
      TimeLockService.newCapsule(50, function(err, result) {
        TimeLockService.numberOfCapsules(function(err, result) {
          assert.equal(result.toNumber(), 1);
          done();
        });
      });
    });
  
  });