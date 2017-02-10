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

  this.Then(/^I should see the mouse pointer changes to the hand pointer \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (projNumber,tab) {
    this.driver.actions().mouseMove(this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') >a' })).perform();
    this.driver.sleep(2000);
  });

  //Planning link of any project

  this.Then(/^color of "([^"]*)" changes to red \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (link,projNumber,tab) {
    this.driver.actions().mouseMove(this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') .'+link+' .detail-plan' })).perform();
    this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') .'+link+' .detail-plan:hover' }).then(function(detailPlan){
      var checkHover=detailPlan.getCssValue('color').then(function(newColor){
        if(newColor=="rgba(218, 65, 67, 1)"){
          console.log("Hover color is red");
        }
        else{
          console.log("Hover color is not red");
        }
      });
    });
    this.driver.sleep(2000);
  });

  this.Then(/^color of link changes to red and tool tip appears on hovering on Estimation and Planning "([^"]*)" link \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (link,projNumber,tab) {
   this.driver.findElement({ css: '#'+tab+' .wrap-project:nth-of-type('+projNumber+') .'+link+' .detail-plan:hover' }).then(function(detailPlan){
    var checkToolTip=detailPlan.getAttribute('title').then(function(toolTip){
      console.log("Tooltip text is => "+toolTip);
    });
  });
   this.driver.sleep(2000);
 });

  this.Then(/^I click on any link of Estimation and Planning "([^"]*)" project \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (link,projNumber,tab) {

    this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') .pro_name'}).then(function(projName){
      var name=projName.getText().then(function(text){
        console.log("Selected Project is => "+text);
      });
    });

    this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') .'+link+' .detail-plan' }).click();

    this.driver.findElement({ css:'.proj-data h2:nth-of-type(2) span'}).then(function(projName){
      var name=projName.getText().then(function(text){
        console.log("Redirected Project is => "+text);
      });
    });
    this.driver.sleep(2000);
  });
};
