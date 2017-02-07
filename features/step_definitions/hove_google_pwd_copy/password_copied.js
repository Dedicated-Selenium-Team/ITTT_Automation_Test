'use strict';

var assert=require('assert');

module.exports = function() {
	this.World = require('../../support/world.js').World;

  //open url in browser
  this.Given(/^Open browser Start Application "(.*?)"$/, function(url){
  	this.driver.get(url);
  });

   //enter username and password
   this.When(/^I enter valid "(.*?)" andd "(.*?)"$/, function(user,pass){
   	this.driver.findElement({ id: 'email' }).sendKeys(user);
   	this.driver.findElement({ id: 'password' }).sendKeys(pass);
   });

   this.Then(/^I copy the password value$/, function(){
    var select = this.driver.findElement({ css: '#password' });
    select.sendKeys(this.webdriver.Key.CONTROL, 'a');
    this.driver.sleep(1000);

    this.driver.findElement({ css: '.form-group #password' }).then(function(select){
      var copy = select.getText().then(function(select_all){
        console.log(select_all);
        if(select_all){
          console.log(select_all);
        }else{
          console.log("Password field are not copied");
        }
      });
    });

    this.driver.sleep(2000);
  });

   this.Then(/^I print it for check in console$/, function(){
    console.log('');
  });
 };
