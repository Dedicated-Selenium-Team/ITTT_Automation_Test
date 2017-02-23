'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start the Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^Enter valid "([^"]*)" and "([^"]*)"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^User should be logged\-in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User should be in users tab$/, function () {
    this.driver.findElement({ css:'.hamb' }).click();
    this.driver.sleep(2000);
    this.driver.findElement({ css:'.user' }).click();
  });

  this.Then(/^Click on Add new button present on the left top corner, pop\-up will get displayed$/, function(){
    this.driver.findElement({ id:'admin-user' }).click();
    this.driver.sleep(2000);
    this.driver.findElement({ css:'.modal' }).then(function(modal){
      if(modal.isDisplayed()){
        console.log("Pop-up get displayed");
      }
      else{
        console.log("Pop-up not get displayed");
      }
    });
  });

  this.Then(/^Fill all the fields with invalid data$/, function () {
    this.driver.findElement({ id:'fname' }).sendKeys("()*?");
    this.driver.findElement({ id:'lname' }).sendKeys("()*?");
    this.driver.findElement({ id:'qualification' }).sendKeys("()*?");
    this.driver.findElement({ id:'address' }).sendKeys("()*?");
    this.driver.findElement({ id:'mobile_no' }).sendKeys("abcd");
    this.driver.findElement({ id:'alt_no' }).sendKeys("abcdef");
    this.driver.findElement({ id:'email' }).sendKeys("abcdef");
    this.driver.findElement({ id:'password'}).sendKeys("abc");
    this.driver.findElement({ id:'re-password'}).sendKeys("ghi");
    this.driver.findElement({ id:'save'}).click();


    this.driver.findElement({ css:'#fname + p'}).then(function(errFname){
      var showError=errFname.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#lname + p'}).then(function(errLname){
      var showError=errLname.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#qualification + p'}).then(function(errQualification){
      var showError=errQualification.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#address + p'}).then(function(errAddress){
      var showError=errAddress.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#mobile_no + p'}).then(function(errContactNo){
      var showError=errContactNo.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#alt_no + p'}).then(function(errAltNo){
      var showError=errAltNo.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#email + p'}).then(function(errEmail){
      var showError=errEmail.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#password + p'}).then(function(errPassword){
      var showError=errPassword.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#password + p'}).then(function(errRePassword){
      var showError=errRePassword.getText().then(function(err){
        console.log(err);
      });
    });
  });

};
