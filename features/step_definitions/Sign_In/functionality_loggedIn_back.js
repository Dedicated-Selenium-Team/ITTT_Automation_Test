'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application \(for back button\)"([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid "([^"]*)" and "([^"]*)"$/, function (username,password) {
    this.driver.findElement({ id: 'email' }).sendKeys(username);
    this.driver.findElement({ id: 'password' }).sendKeys(password);
  });

  this.Then(/^I Click on sign in button$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User must successfully logged\-in$/, function () {
    this.driver.getTitle().then(function(title){
      if(title=="ITTT | Timesheet") {
        console.log("User successfully logged in to the site.");
      }
      else{
        console.log("User not logged in to the site.");
      }
    });
  });

  this.When(/^I click back button$/, function () {
    this.driver.navigate().back();
    this.driver.sleep(2000);
  });

  this.Then(/^The current page should not be redirected to the login page"([^"]*)"$/, function (url) {
    this.driver.getCurrentUrl().then(function(currUrl){
      if(currUrl!=url){
        console.log("Passed=> User is not redirected to the login page");
      }
      else{
        console.log("Failed=> User redirected to the login page");
      }
    });
  });

};
