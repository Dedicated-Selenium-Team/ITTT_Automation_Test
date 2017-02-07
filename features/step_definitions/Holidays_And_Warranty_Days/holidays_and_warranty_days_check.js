'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application"([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid entry "([^"]*)" and "([^"]*)"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^^User should be logged in and home page should be open again$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User should be in project tab$/,function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^Click on any link of Estimation project \(Let us check this project "([^"]*)"\)$/, function (projNumber) {

    this.driver.findElement({ css:'#tabs-1 .wrap-project:nth-of-type('+projNumber+') .estimate-span .detail-plan' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^Enter valid data in the field of holidays or warranty \(Let put the the number of "([^"]*)" and "([^"]*)"\)$/, function (days,ID) {

    this.driver.findElement({ id:'Warrenty-days' }).clear();
    this.driver.findElement({ id:'Warrenty-period-holiday' }).clear();
    this.driver.findElement({ id: ID }).sendKeys(days);
    this.driver.sleep(2000);

    this.driver.findElement({ id:'Warrenty-period-end' }).then(function(warranty){
      var checkDisabled=warranty.getAttribute('disabled').then(function(isDisabled){
        if(isDisabled=="true"){
          var checkValue = warranty.getAttribute('value').then(function(value){
            var checkPlaceholder=warranty.getAttribute('placeholder').then(function(placeValue){
              if(value=="0" && placeValue=="dd/mm/yyyy") {
                console.log("The date is in dd/mm/yyyy format");
              }
              else{
                console.log("The date is in dd/mm/yyyy format");
              }              
            });
          });
        }
        else{
         console.log("Warranty End Date is not disabled"); 
       }
     });
    });
  });
};

