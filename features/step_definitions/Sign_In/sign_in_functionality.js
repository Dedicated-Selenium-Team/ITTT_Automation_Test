'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter "([^"]*)" and "([^"]*)"$/, function (username,password) {
    this.driver.findElement({ id: 'email' }).sendKeys(username);
    this.driver.findElement({ id: 'password' }).sendKeys(password);
  });

  this.Then(/^Click on sign\-in button$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^Proper error message must be appeared or successfully login$/, function () {
    this.driver.findElement({ css:'#email + p'}).then(function(errUsername){
      var showError=errUsername.getText().then(function(err){
        console.log(err);
      });
    });
    this.driver.findElement({ css:'#password + p'}).then(function(errPassword){
      var showError=errPassword.getText().then(function(err){
        console.log(err);
      });
    });
  });
};
