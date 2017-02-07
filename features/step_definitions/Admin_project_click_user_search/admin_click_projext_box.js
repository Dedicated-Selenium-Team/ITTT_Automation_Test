'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  //open browser
  this.Given(/^Open browser and Start Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  //enter username and password
  this.When(/^I enter valid \"([^\"]*)\" and \"([^\"]*)\"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  //click on login button
  this.Then(/^User should be logged in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });
  
  //check in project or not
  this.Then(/^User should be in project$/,function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(1000);
  });

  //see the hover effect and mouse pointer changes
  this.Then(/^I should see hover and mouse pointer$/, function(){
    this.driver.actions()
    .mouseMove(this.driver.findElement({ css: '.wrap-project' }))
    .perform();
    this.driver.sleep(1000);
  });

  //click on any random project ans check selected and resulted project
  this.When(/^I click on any random Project$/, function () {
    var a = this.driver.findElement({ css: '.wrap-project .pro_name' }).then(function(project){
      var project_name  = project.getText().then(function(pro_name){
        console.log("Selected Project is: " +pro_name);
      });
    });
    
    this.driver.findElement({ css: '.wrap-project' }).click();
    this.driver.sleep(1000);

    var b = this.driver.findElement({ css: '.total-hrs .prj-name span' }).then(function(exp_project){
      var exp_project_name  = exp_project.getText().then(function(exp_pro_name){
        console.log("Result project name is: "+ exp_pro_name);
      });
    });
  });
  
  //result for selected project
  this.Then(/^I should see the project which I have selected$/, function(){
   var b = this.driver.findElement({ css: '.total-hrs .prj-name span' }).then(function(exp_project){
    var exp_project_name  = exp_project.getText().then(function(exp_pro_name){
      console.log("Opened project is: "+ exp_pro_name);
    });
  });
 });
};
