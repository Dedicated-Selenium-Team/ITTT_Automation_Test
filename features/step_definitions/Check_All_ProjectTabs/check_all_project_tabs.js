'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid \"([^\"]*)\" and \"([^\"]*)\"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^User should be logged in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User should be in project$/,function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^I should see the mouse pointer changes to the hand pointer on hovering on "([^"]*)"$/,function(tab){
    this.driver.actions().mouseMove(this.driver.findElement({ id: tab })).perform();
    this.driver.sleep(2000);
  });

  this.Then(/^"([^"]*)" button should be highlighted as I click on it "([^"]*)"$/, function(allProject,tab){
    this.driver.findElement({ id: allProject }).click();
    this.driver.sleep(2000);
    this.driver.findElement({ id: tab }).then(function(allProject_proj){
      if(allProject_proj.isDisplayed()) {
        console.log("Passed => Project list is displayed");
      }
      else{
        console.log("Failed => Project list is not get displayed");
      }
    });
  });
};
