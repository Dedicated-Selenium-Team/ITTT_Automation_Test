'use strict';

var assert=require('assert');

module.exports = function() {
	this.World = require('../../support/world.js').World;

  //open url in browser
  this.Given(/^Open browser and Start Application "(.*?)"$/, function(url){
  	this.driver.get(url);
  });

   //enter username and password
   this.When(/^I enter valid "(.*?)" and "(.*?)"$/, function(user,pass){
   	this.driver.findElement({ id: 'email' }).sendKeys(user);
   	this.driver.findElement({ id: 'password' }).sendKeys(pass);
   });

   //verify the cta
   this.Then(/^Verify the CTA is "(.*?)"$/, function(cta){
    this.driver.findElement({ css:'.form-group #customBtn' }).then(function(cta_value){
      var select_cta=cta_value.getAttribute("title").then(function(selected_cta){
        if(selected_cta==cta){
          console.log("Result===>>> CTA is currect and CTA is: "+ selected_cta);
        }else{
          console.log("Result===>>> CTA is wrong");
        }
      });
    });
    this.driver.sleep(2000);
  });

   //hover verify
   this.Then(/^Verify Hover on sign in with google$/, function(){
    this.driver.actions()
    .mouseMove(this.driver.findElement({ css: '.form-group #customBtn' }))
    .perform();
    this.driver.sleep(1000);
  });

   //click on sign in and check popup
   this.Then(/^Click on sign in with google button and check popup is displayed$/, function(){
    this.driver.findElement({ css: '.form-group #customBtn' }).click();
    this.driver.sleep(2000);
  });
 };
