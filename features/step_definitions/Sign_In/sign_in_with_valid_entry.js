'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application for valid login"([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter the valid "([^"]*)" and "([^"]*)"$/, function (username,password) {
    this.driver.findElement({ id: 'email' }).sendKeys(username);
    this.driver.findElement({ id: 'password' }).sendKeys(password);
  });

  this.Then(/^Click sign in button$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User must successfully signed in to the site$/, function () {
    this.driver.getTitle().then(function(title){
      if(title=="ITTT | Timesheet") {
        console.log("User successfully logged in to the site.");
      }
      else{
        console.log("User not logged in to the site.");
      }
    });
  });
};
