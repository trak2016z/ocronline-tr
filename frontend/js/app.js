console.log("-- app.js --");
class TestClass {
  constructor() {
    this.id = 22;
  }
  getId() {
    //...
    return this.id;
  }
}

var c = new TestClass();
console.log('JS Babel test: '+c.getId());